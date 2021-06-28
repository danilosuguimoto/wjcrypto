<?php

use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;
use WjCrypto\DI\Builder;

class Helper 
{
	/**
	 * Get url for a route by using either name/alias, class or method name.
	 *
	 * The name parameter supports the following values:
	 * - Route name
	 * - Controller/resource name (with or without method)
	 * - Controller class name
	 *
	 * When searching for controller/resource by name, you can use this syntax "route.name@method".
	 * You can also use the same syntax when searching for a specific controller-class "MyController@home".
	 * If no arguments is specified, it will return the url for the current loaded route.
	 *
	 * @param string|null $name
	 * @param string|array|null $parameters
	 * @param array|null $getParams
	 * @return \Pecee\Http\Url
	 * @throws \InvalidArgumentException
	 */
	public static function url(?string $name = null, $parameters = null, ?array $getParams = null): Url
	{
		return Router::getUrl($name, $parameters, $getParams);
	}

	/**
	 * @return \Pecee\Http\Response
	 */
	public static function response(): Response
	{
		return Router::response();
	}

	/**
	 * @return \Pecee\Http\Request
	 */
	public static function request(): Request
	{
		return Router::request();
	}

	/**
	 * Get input class
	 * @param string|null $index Parameter index name
	 * @param string|mixed|null $defaultValue Default return value
	 * @param array ...$methods Default methods
	 * @return \Pecee\Http\Input\InputHandler|array|string|null
	 */
	public static function input($index = null, $defaultValue = null, ...$methods)
	{
		if ($index !== null) {
			return request()->getInputHandler()->value($index, $defaultValue, ...$methods);
		}

		return request()->getInputHandler();
	}

	/**
	 * @param string $url
	 * @param int|null $code
	 */
	public static function redirect(string $url, ?int $code = null): void
	{
		if ($code !== null) {
			response()->httpCode($code);
		}

		response()->redirect($url);
	}

	/**
	 * Get current csrf-token
	 * @return string|null
	 */
	public static function csrf_token(): ?string
	{
		$baseVerifier = Router::router()->getCsrfVerifier();
		if ($baseVerifier !== null) {
			return $baseVerifier->getTokenProvider()->getToken();
		}

		return null;
	}

	public function generate_crypt_key() 
	{
		$key = base64_encode(openssl_random_pseudo_bytes(256));

		return $key;
	}
	
	/**
	 * Encrypts the given string so that it can be saved in the database
	 *
	 * @param  string $data
	 * @return string|false
	 */
	public static function encrypt_data(string $data) 
	{
		$cipher = "AES-256-CBC";
		$key = "02f286562d24ed2e1f3d2cceddbd40edf799679b9e4355ed3bd07ac33fbf2a454c34f44deb5e6d081f14a44c0664961d1ee5b0b511ef2a4862beacb62f54252b";

		$ivLength = openssl_cipher_iv_length($cipher);
		$iv = substr("randomwordsarebeingwrittenhere", 0, $ivLength);

		$cipheredText = openssl_encrypt($data, $cipher, $key, 0, $iv);
		$cipheredText = base64_encode($cipheredText);

		return $cipheredText;
	}
	
	/**
	 * Decrypts the given encrypted data so that it can be shown somewhere else
	 *
	 * @param  string $data
	 * @return string|false
	 */
	public static function decrypt_data(string $data) 
	{
		$cipher = "AES-256-CBC";
		$key = "02f286562d24ed2e1f3d2cceddbd40edf799679b9e4355ed3bd07ac33fbf2a454c34f44deb5e6d081f14a44c0664961d1ee5b0b511ef2a4862beacb62f54252b";

		$ivLength = openssl_cipher_iv_length($cipher);
		$iv = substr("randomwordsarebeingwrittenhere", 0, $ivLength);

		$cipheredText = openssl_decrypt(base64_decode($data), $cipher, $key, 0, $iv);
	
		return $cipheredText;
	}
	
	/**
	 * getApiConnection
	 *
	 * @param  string $endpoint
	 * @param  array $data
	 * @return mixed
	 */
	public static function getApiConnection(string $endpoint, array $data, bool $returnTransfer = true)
	{
		$url =  'http://' . $_SERVER['HTTP_HOST'] . "/rest/API" . $endpoint;

		try {
			$curl_handler = curl_init($url);

			// Check if initialization had gone wrong*    
			if ($curl_handler === false) {
				throw new Exception('Failed to initialize');
			}

			$request_body = json_encode($data);

			if(self::hasSession()) {
				curl_setopt(
					$curl_handler,
					CURLOPT_HTTPHEADER,
					[
						'Content-Type: application/json',
						'Authorization: Bearer ' . $_SESSION['authentication_token'] 
					]
				);	
			} else {
				curl_setopt($curl_handler, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
			}

			curl_setopt($curl_handler, CURLOPT_POST, true);
			curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $request_body);
			curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, true);

			$result = curl_exec($curl_handler);

			// Check the return value of curl_exec()
			if ($result === false) {
				throw new Exception(curl_error($curl_handler), curl_errno($curl_handler));
			}

			curl_close($curl_handler);

			if($returnTransfer) {
				$json = json_decode($result);
				return $json;
			}
		} catch (Exception $e) {
			trigger_error(sprintf(
        "Curl failed with error #%d: %s",
        $e->getCode(), $e->getMessage()),
        E_USER_ERROR);
		}
	}
	
	/**
	 * apiResponse
	 *
	 * Returns the base response array. Can also receive 2 optional parameters to set additional data
	 * 
	 * @param  string $message
	 * @param  string|null $optParam
	 * @param  mixed $optValue
	 * @return array
	 */
	public static function apiResponse(string $message, string $optParam = null, $optValue = null) 
	{
		if(isset($optParam) && isset($optValue)) {
			$data = [
				'statusCode' => http_response_code(),
				'message' => $message,
				$optParam => $optValue
			];
		} else {
			$data = [
				'statusCode' => http_response_code(),
				'message' => $message
			];
		}

		self::response()->json($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}
	
	/**
	 * getContainer
	 *
	 * Returns a new container with the given dependency
	 * 
	 * @param  mixed $dependency
	 * @return mixed
	 */
	public static function getContainer($dependency) 
	{
		return Builder::buildContainer()->get($dependency);
	}
	
	/**
	 * hasSession
	 *
	 * Checks if the user is authenticated
	 * 
	 * @return bool
	 */
	public static function hasSession() 
	{
		if(isset($_SESSION['acc_number']) && isset($_SESSION['authentication_token'])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * getUserBalance
	 *
	 * Returns the account's balance for the authenticated user
	 * 
	 * @return string
	 */
	public static function getUserBalance()
	{
		if(self::hasSession()) {
			$user = self::getContainer('UserModel');

			$acc = $user->selectDataFrom('acc_number', $_SESSION['acc_number']);

			$balance = $acc[0]->balance;

			return $balance;
		}
	}
}
