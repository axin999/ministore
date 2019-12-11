<!DOCTYPE html>
<html>
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@yield('title')</title>
		<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
		

	</head>
	<body>

		<div id="app">
		@include('sketchynav')
		@yield('content')
		<router-view></router-view>
			
		
		



		
		</div>
		


		
		{{-- <script src="{{ asset('js/bootstrap.js') }}"></script> --}}
		<script src="{{ asset('js/app.js') }}"></script>

		<script>
		</script>
	</body>
</html>