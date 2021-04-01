<html>
	<head>
		<title>Xero</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.min.js"  crossorigin="anonymous"></script>
		<script src="{{asset('xero/xero.js')}}"  crossorigin="anonymous"></script>
	</head>
	<body>
		<div id="req" class="container">
			<div class="row">
				<div class="col">
					<h2>Xero OAuth2</h2>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<a href="{{route('xero.authorization')}}"><img src="{{asset('xero/images/connect-blue.svg')}}">
					</a>
				</div>
			</div>
		</div>
	</body>
</html>
