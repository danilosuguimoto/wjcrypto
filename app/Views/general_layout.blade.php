<!-- Stored in Views/general_layout.blade.php -->

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/png" href="Misc/Icon/wj.jpeg">
		<link rel="stylesheet" href="Misc/CSS/mainstyle.css">
		<link rel="stylesheet" href="Misc/CSS/pages/alert.css">
		<script src="Misc/JS/jquery-3.6.0.js"></script>
		@yield('head')
	</head>
	<body>
		<header>
			<h1 id="main-title">
				<a href="/">
					WJ<span id="main-title-color2">Crypto</span>
				</a>
			</h1>
			@yield('header')
		</header>
		<div class="content-wrapper">
			<div id="bg-opacity"></div>
			<div class="page-title">
				@yield('page-title')
			</div>
			<hr id="page-title-hr">
			<main>
				@yield('alert')
				@yield('content')
			</main>
		</div>
		@section('footer')
			<footer>
				<div id="developer-name">
					<span>
						Desenvolvido por <strong>Danilo Suguimoto</strong>
					</span>
				</div>
			</footer>
		@show
	</body>
</html>
