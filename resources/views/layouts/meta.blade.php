		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title> {{config('app.name')}} </title>
		<meta name="description" content="This is a secret webpage">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:400,700|Montserrat:300,400,500,600" rel="stylesheet">
		<link href="/css/app.css" rel="stylesheet">
		<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
		<script src="/js/app.js" defer></script>
		@yield('head')
