<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use WjCrypto\Models\CoreModel;

/**
 * UserAddressModel
 */
class UserAddressModel extends CoreModel {
  private $address_id;
  private $acc_number;
  private $postcode;
  private $contry;
  private $region;
  private $city;
  private $street;
  private $complement;

  public function __construct()
  {
    parent::__construct();
    parent::setAttributes(
      "wj_crypto.user_address",
      [
        "address_id",
        "acc_number",
        "postcode",
        "country",
        "region",
        "city",
        "street",
        "complement"
      ]
    );
  }

  /**
   * Get the value of address_id
   */ 
  public function getAddressId()
  {
    return $this->address_id;
  }

  /**
   * Set the value of address_id
   *
   * @return  self
   */ 
  public function setAddressId($address_id)
  {
    $this->address_id = $address_id;

    return $this;
  }

  /**
   * Get the value of acc_number
   */ 
  public function getAccNumber()
  {
    return $this->acc_number;
  }

  /**
   * Set the value of acc_number
   *
   * @return  self
   */ 
  public function setAccNumber($acc_number)
  {
    $this->acc_number = $acc_number;

    return $this;
  }

  /**
   * Get the value of postcode
   */ 
  public function getPostcode()
  {
    return $this->postcode;
  }

  /**
   * Set the value of postcode
   *
   * @return  self
   */ 
  public function setPostcode($postcode)
  {
    $this->postcode = $postcode;

    return $this;
  }

  /**
   * Get the value of contry
   */ 
  public function getContry()
  {
    return $this->contry;
  }

  /**
   * Set the value of contry
   *
   * @return  self
   */ 
  public function setContry($contry)
  {
    $this->contry = $contry;

    return $this;
  }

  /**
   * Get the value of region
   */ 
  public function getRegion()
  {
    return $this->region;
  }

  /**
   * Set the value of region
   *
   * @return  self
   */ 
  public function setRegion($region)
  {
    $this->region = $region;

    return $this;
  }

  /**
   * Get the value of city
   */ 
  public function getCity()
  {
    return $this->city;
  }

  /**
   * Set the value of city
   *
   * @return  self
   */ 
  public function setCity($city)
  {
    $this->city = $city;

    return $this;
  }

  /**
   * Get the value of street
   */ 
  public function getStreet()
  {
    return $this->street;
  }

  /**
   * Set the value of street
   *
   * @return  self
   */ 
  public function setStreet($street)
  {
    $this->street = $street;

    return $this;
  }

  /**
   * Get the value of complement
   */ 
  public function getComplement()
  {
    return $this->complement;
  }

  /**
   * Set the value of complement
   *
   * @return  self
   */ 
  public function setComplement($complement)
  {
    $this->complement = $complement;

    return $this;
  }
}
