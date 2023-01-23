{{-- @php
	print_r($navArray = session()->get('navArray')); die('admin.blade')
@endphp --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
	<meta content="Coderthemes" name="author" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Expense</title>	
	<script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
	<link rel="stylesheet" rel="shortcut icon" href="{{asset('contents/admin')}}/assets/images/favicon.png">
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/vendor/jquery-jvectormap-1.2.2.css" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/icons.min.css" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/app.min.css" id="light-style" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/app-dark.min.css" id="dark-style" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/vendor/dataTables.bootstrap5.css" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/vendor/responsive.bootstrap5.css" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/style.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"light","leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
	<!-- Begin page -->
	<div class="wrapper">
		<!-- ========== Left Sidebar Start ========== -->
		<div class="leftside-menu">
			<!-- LOGO -->
			<a href="{{url('dashboard')}}" class="logo text-center logo-light">
				<span class="logo-lg">
					<img src="{{asset('contents/admin')}}/assets/images/logo.png" alt="">
				</span>
				<span class="logo-sm">
					<img src="{{asset('contents/admin')}}/assets/images/logo_sm.png" alt="">
				</span>
			</a>

			<!-- LOGO -->
			<a href="{{url('dashboard')}}" class="logo text-center logo-dark">
				<span class="logo-lg">
					<img src="{{asset('contents/admin')}}/assets/images/logo-dark.png" alt="">
				</span>
				<span class="logo-sm">
					<img src="{{asset('contents/admin')}}/assets/images/logo_sm_dark.png" alt="">
				</span>
			</a>
			<div class="h-100 mt-4" id="leftside-menu-container" data-simplebar>
				<!--- Sidemenu -->
				<ul class="side-nav">
					<li class="side-nav-item"><a href="{{url('dashboard')}}" class="side-nav-link"><i class="uil-home-alt"></i><span> Dashboard </span></a></li>
					@php
					$navArray = session()->get('navArray');
					@endphp
					@foreach($navArray as $nav)
						<li  class="side-nav-item">						
							<a data-bs-toggle="collapse" href="#{{$nav['url']}}" aria-expanded="false" aria-controls="company" class="side-nav-link"><i class="mdi mdi-arrow-right-drop-circle-outline me-1 "></i><span> {{$nav['name']}}</span><span class="menu-arrow"></span></a>
							<div class="collapse" id="{{$nav['url']}}">
								<ul class="side-nav-second-level">								
									@foreach($nav['child'] as $k=>$v)
									<li><a href="{{url('/')}}/{{$k}}"><i class="mdi mdi-chevron-right me-1 "></i>{{$v}}</a></li>
									@endforeach
								</ul>
							</div>
						</li>
					@endforeach
					<li class="side-nav-item"><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="side-nav-link"><i class="uil-exit"></i><span> Logout </span></a></li>
				</ul>
				<!-- End Sidebar -->
				<div class="clearfix"></div>
			</div>
			<!-- Sidebar -left -->
		</div>
		<div class="content-page">
			<div class="content">
				<!-- Topbar Start -->
				<div class="navbar-custom">
					<ul class="list-unstyled topbar-menu float-end mb-0">
						<li class="dropdown notification-list d-lg-none">
							<a class="nav-link dropdown-toggle arrow-none" href="{{url('dashboard')}}">
								<i class="dripicons-home noti-icon"></i>
							</a>
						</li>
						<li class="dropdown notification-list d-lg-none">
							<a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<i class="dripicons-search noti-icon"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
								<form class="p-3" action="{{route('searching')}}" method="post" >
									@csrf
									<input name="keyword" type="text" class="form-control" placeholder="Search ..." aria-label="Search">
								</form>
							</div>
						</li>						
						
						<li class="dropdown notification-list topbar-dropdown">
							<a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<i class="dripicons-alarm noti-icon"></i>
								<span class="align-middle d-sm-inline-block" id="timer"></span> <i class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu">
								<a href="javascript:plus2timer(5)" class="dropdown-item notify-item">
									<span class="align-middle">Add 5 mins</span>
								</a>
							</div>							
						</li>
						
						<li class="dropdown notification-list">
							<a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<span class="account-user-avatar">
									@if(Auth::user()->avatar!='')
									<img src="{{asset('')}}uploads/users/{{Auth::user()->avatar}}" alt="user-image" class="rounded-circle">
									@else
									<img class="rounded-circle" src="{{asset('uploads/avatar.png')}}"/>
									@endif	
								</span>
								<span>
									<span class="account-user-name">{{Auth::user()->name}}</span>
									<span class="account-position">{{Auth::user()->email}}</span>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
								<!-- item-->
								<div class=" dropdown-header noti-title">
									<h6 class="text-overflow m-0">Welcome {{Auth::user()->name}}</ !</h6>
								</div>
								<!-- item-->
								<a href="{{route('user.profile')}}" class="dropdown-item notify-item">
									<i class="mdi mdi-account-circle me-1"></i>
									<span>My Account</span>
								</a>
								<!-- item-->
								
								<!-- item-->
								<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
									<i class="mdi mdi-logout me-1"></i>
									<span>Logout</span>
								</a>
							</div>
						</li>
					</ul>
					<button class="button-menu-mobile open-left">
						<i class="mdi mdi-menu"></i>
					</button>
					<div class="app-search dropdown d-none d-lg-block">
						<form method="post" action="{{route('searching')}}">
							@csrf
							<div class="input-group">
								<input type="text" class="form-control dropdown-toggle" name="keyword" placeholder="Payment ref. no., File ref. no, Guest name, email or Tally ref. no" id="top-search" value="{{isset($keyword)?$keyword:''}}">
								<span class="mdi mdi-magnify search-icon"></span>
								<button class="input-group-text btn-primary" type="submit">Search</button>
							</div>
						</form>
					</div>
				</div>
				<!-- end Topbar -->

				<!-- Start Content-->
				<div class="container-fluid">
					<!-- start page title -->
					<div class="row">
						<div class="col-12">
							<div class="page-title-box">
								<div class="page-title-right">
									<form class="d-flex">
										<a href="" class="btn btn-primary m-0">
											<i class="mdi mdi-autorenew">Refresh</i>
										</a>
									</form>
								</div>
							</div>
						</div>
					</div>
					<br>
					<!-- end page title -->
					@yield('content')

				</div>
			</div>			
			<!-- Footer Start -->
			<footer class="footer">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<b>
							&copy; {{date('Y')}} Indian Holiday Pvt. Ltd.
							</b>
						</div>
					</div>
				</div>
			</footer>
			<!-- end Footer -->

		</div>
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			@csrf
		</form>
	</div>
	
	<!-- END wrapper -->
	<script src="{{asset('contents/admin')}}/assets/js/vendor.min.js"></script>
	<script src="{{asset('contents/admin')}}/assets/js/app.min.js"></script>
	<script src="{{asset('contents/admin')}}/assets/js/vendor/apexcharts.min.js"></script>
	<script src="{{asset('contents/admin')}}/assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="{{asset('contents/admin')}}/assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
	<script src="{{asset('contents/admin')}}/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="{{asset('contents/admin')}}/assets/js/vendor/dataTables.bootstrap5.js"></script>
	<script src="{{asset('contents/admin')}}/assets/js/vendor/dataTables.responsive.min.js"></script>
	<script src="{{asset('contents/admin')}}/assets/js/vendor/responsive.bootstrap5.min.js"></script>
	<script src="{{asset('contents/admin')}}/assets/js/pages/demo.dashboard.js"></script>
	<script src="{{asset('contents/admin')}}/assets/js/custom.js" type="text/javascript"></script>
	
	<script src="{{asset('js/app.js')}}"></script>
	@php
	$timer=session()->get('config_info');
	$timeexpired = $timer['TIMER_EXPIRY'];			
	@endphp	
	<script>
		startTimer({{$timeexpired}},'{{ route('logout') }}');		
	</script>
	@include('admin.role.partials.scripts')
    @yield('scripts')

	{{-- chaingin scripts --}}
	{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
	<script src="{{asset('public\contents\admin\assets\js\jquery.chained.js')}}" type="text/javascript"></script>
	<script src="{{asset('public\contents\admin\assets\js\jquery.chained.remote.js')}}" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	$(function() {
		/* For jquery.chained.js */
		$("#branch").chained("#company_name");
		});
	</script> --}}
</body>

</html>