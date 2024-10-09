<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
        <link rel="icon" href="/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sakai Vue</title>
        <link href="https://fonts.cdnfonts.com/css/lato" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
	</head>
	<body>
		<div id="app"></div>
        @vite(['resources/js/app.js'])
	</body>
</html>
