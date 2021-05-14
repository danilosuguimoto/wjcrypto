<!-- Stored in Views/general_layout.blade.php -->

<html>
	<head>
		<title>WjCrypto - @yield('title')</title>
	</head>
	<body>
		@section('sidebar')
			This is the master sidebar.
		@show

		<div class="container">
			@yield('content')
		</div>
	</body>
</html>