<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Jhps Admin Panel" />
	<meta name="author" content="" />

	<title>Magnificit | Login</title>

	<link rel="stylesheet" href="{{URL::asset('assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/font-icons/entypo/css/entypo.css')}}">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/neon-core.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/neon-theme.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/neon-forms.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/custom.css')}}">

	<script src="{{URL::asset('assets/js/jquery-1.11.0.min.js')}}"></script>
	<script>$.noConflict();</script>
</head>
<body class="page-body login-page login-form-fall">
	<div class="login-container">

		<div class="login-form">
			<div class="login-content">
			    
			    <div class="login_img">
			        <img src="assets/images/logo-icon.png">
			        
			    </div>
			    
			    
				@if(session()->get('msg'))
				 <div class="alert alert-danger text-center"><strong>Invalid Credentials. Please Try again</strong></div>
				 {{session()->forget('msg')}}
				@endif
				<form method="post" action="{{URL::to('Login')}}">
					@csrf
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="entypo-user"></i>
							</div>
							<input type="text" class="form-control" value="{{session()->get('username')}}" required name="username" id="username" placeholder="Username" autocomplete="off" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="entypo-key"></i>
							</div>
							<input type="password" class="form-control" required name="password" id="password" placeholder="Password" autocomplete="off" />
						</div>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block btn-login">
							<i class="entypo-login"></i>
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>


<!-- Bottom scripts (common) -->
<script src="{{URL::asset('assets/js/gsap/main-gsap.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap.js')}}"></script>
<script src="{{URL::asset('assets/js/joinable.js')}}"></script>
<script src="{{URL::asset('assets/js/resizeable.js')}}"></script>
<script src="{{URL::asset('assets/js/neon-api.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{URL::asset('assets/js/neon-login.js')}}"></script>
<!-- JavaScripts initializations and stuff -->
<script src="{{URL::asset('assets/js/neon-custom.js')}}"></script>
<!-- Demo Settings -->
<script src="{{URL::asset('assets/js/neon-demo.js')}}"></script>

</body>
</html>