<!-- Stored in Views/pages/general_layout.blade.php -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" type="image/png" href="Misc/Icon/wj.jpeg">
		<link rel="stylesheet" href="Misc/CSS/mainstyle.css">
		@yield('head')
	</head>
	<body>
		<header>
			<h1 id="title">
				WJ<span id="title-color2">Crypto</span>
			</h1>
			@yield('header')
		</header>
		<div class="content-wrapper">
			<div id="bg-opacity"></div>
			<nav></nav>
			<main>
				@yield('content')
			</main>
		</div>
		@section('footer')
			<footer>
				<div id="developer-name">
					<span>
						Desenvolvido por <strong>{{ $name }}</strong>
					</span>
				</div>
			</footer>
		@show
	</body>
</html>
