
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Jhps Admin Panel" />
	<meta name="author" content="" />
	<title>PICKMYCHOICE | Dashboard</title>
	<link rel="stylesheet" href="{{URL::asset('assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/font-icons/entypo/css/entypo.css')}}">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/neon-core.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/neon-theme.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/neon-forms.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/custom.css')}}">

	<script src="{{URL::asset('assets/js/jquery-1.11.0.min.js')}}"></script>
	<script type="text/javascript" src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
	<link rel="stylesheet" type="text/css" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">
	<script type="text/javascript" src="{{URL::asset('assets/ckeditor/ckeditor.js')}}"></script>
	<script src="{{URL::asset('assets/ckeditor/_samples/sample.js')}}" type="text/javascript"></script>
	<script src="{{URL::asset('assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
	<!-- <link href="{{URL::asset('assets/ckeditor/_samples/sample.css')}}" rel="stylesheet" type="text/css" /> -->
    <style type="text/css">
    	.name
    	{
    		font-size: 22px;
    		color: #fff !important;
    		font-weight: 800;
    	}
    </style>
</head>
<body class="page-body page-fade-only">
	@if(LayoutHelper::status('')[0]->collapse==1)
    <div class="page-container sidebar-collapsed">
	@else
	<div class="page-container">
	@endif
	<div class="sidebar-menu">
		<div class="sidebar-menu-inner">
			<header class="logo-env">
				<!-- logo -->
				<div class="logo">
					<a class="name" href="{{URL::to('/dashboard')}}">
					 <img src="{{URL::asset('assets/images/logo-new.png')}}" width="120" alt="" /> 
					  <!-- MAGNIFICIT -->
					</a>
				</div>
				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="javascript:void[0]" status="{{LayoutHelper::status('')[0]->collapse}}" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>
				<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
				<div class="sidebar-mobile-menu visible-xs">
					<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i>
					</a>
				</div>
			</header>
			
			<ul id="main-menu" class="main-menu">
				{!! LayoutHelper::load_menus('') !!}
				@if(LayoutHelper::userdata('')[0]->department_id==1)
				<li class="active">
					<a href="{{URL::to('access-management')}}">
						<i class="entypo-check"></i>
						<span class="title">Access Management</span>
					</a>
				</li>
				<!--<li class="active">
					<a href="{{URL::to('latest-updates')}}">
						<i class="entypo-check"></i>
						<span class="title">Latest Updates</span>
					</a>
				</li>
				<li class="active">
					<a href="{{URL::to('side-menus')}}">
						<i class="entypo-check"></i>
						<span class="title">Page Side Menus</span>
					</a>
				</li>-->
				@endif
			</ul>
		</div>
	</div>

	<div class="main-content">
		<div class="row">
			<!-- Profile Info and Notifications -->
			<div class="col-md-6 col-sm-8 clearfix">
				<ul class="user-info pull-left pull-none-xsm">
					<!-- Profile Info -->
					<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
						<a href="javascript:void[0]" class="dropdown-toggle" data-toggle="dropdown">
							@if(LayoutHelper::userdata('')[0]->profile_photo!="")
							<img src="{{URL::asset('assets/portal/user/'.LayoutHelper::userdata('')[0]->profile_photo)}}" class="img-circle" width="44" />
							@else
							<img src="{{URL::asset('assets/images/thumb-1@2x.png')}}" alt="" class="img-circle" width="44" />
							@endif
							{{ucfirst(LayoutHelper::userdata('')[0]->name)}}
						</a>
						<ul class="dropdown-menu">
							<!-- Reverse Caret -->
							<li class="caret"></li>
							<li>
								<a href="javascript:void[0]" onclick="jQuery('#modal-6').modal('show', {backdrop: 'static'});"><i class="entypo-eye"></i>Change Password</a>
							</li>
							<li>
								<a href="{{URL::to('logout')}}"><i class="entypo-logout"></i>Logout</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- Raw Links -->
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
				<ul class="list-inline links-list pull-right">
					<li>
						<a href="{{URL::to('logout')}}">Log Out <i class="entypo-logout right"></i></a>
					</li>
				</ul>
			</div>
		</div>
		<hr />
		<!-- Modal 6 (Long Modal)-->
		<div class="modal fade" id="modal-6">
			<div class="modal-dialog">
				<div class="modal-content">
					<form role="form" id="form1" action="{{URL::to('update-password')}}" name="updatepass" method="post" class="validate">
						@csrf
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;font-weight: bolder;background: red;border-radius: 50%;width: 20px;">&times;</button>
							<h4 class="modal-title">Change your Password</h4>
						</div>
						<div class="modal-body">
							<div class="alert text-center" style="display: none;"></div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="field-5" class="control-label">Old Password</label>
										<input type="password" class="form-control" name="old_password" data-validate="required" required data-message-required="Old Password is required"  placeholder="Old Password">
									</div>	
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="field-6" class="control-label">New Password</label>
										<input type="password" class="form-control"  name="new_password" data-validate="required" required data-message-required="New Password is required"  placeholder="New Password">
									</div>	
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-info">Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
        
        @php
          $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        @endphp
		<script type="text/javascript">
			var link = "{{$actual_link}}";
			$(document).ready(function(){
				$("#main-menu ul li a").each(function(){
					if($(this).attr("href")==link)
					{
                       $(this).parent().parent().parent().addClass('opened');
                       $(this).parent().addClass('active');
					}
				})
			})
		</script>

		@if(session()->get('msg')=="3")
		<script type="text/javascript">
			swal("Success", "Password Updated Successfully", "success");
		</script>
		{{session()->forget('msg')}}
		@endif

		@if(session()->get('err1')=="3")
		<script type="text/javascript">
			swal("Error", "Old Password is incorrect", "error");
		</script>
		{{session()->forget('err1')}}
		@endif


		<script type="text/javascript">
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			sessioncheck();
			setInterval(function(){ sessioncheck(); }, 5000);
			function sessioncheck()
			{
				$.get('{{URL::to("session-check")}}', function(data) {
					if(data == "500"){
						alert('Ooops! Session Expired');location.reload();
					}
				});
			}
			$('.sidebar-collapse-icon').click(function(){
				 $.post('{{URL::to("status")}}',{status:$(this).attr('status')},function(data){})
			})
		</script>
		