<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible"
		content="ie=edge">
	@vite('resources/css/app.css')
	@yield('head')
	<title>@yield('title', 'FreeTest - Website Tạo đề thi trắc nghiệm')</title>
</head>

<body>
	@includeIf('partials.header')
	<div class="app p-10 lg:px-primary">
		@yield('content')
	</div>
	@includeIf('partials.footer')
	@vite('resources/js/app.js')
	@yield('script')
</body>

</html>
