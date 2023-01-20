<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
	<meta content="Coderthemes" name="author" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Dashboard Project</title>
	<link rel="stylesheet" rel="shortcut icon" href="{{asset('contents/admin')}}/assets/images/favicon.png">
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/vendor/jquery-jvectormap-1.2.2.css" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/icons.min.css" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/app.min.css" id="light-style" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/app-dark.min.css" id="dark-style" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/vendor/dataTables.bootstrap5.css" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/vendor/responsive.bootstrap5.css" />
	<link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/style.css" />
</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":true, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
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

			<div class="h-100" id="leftside-menu-container" data-simplebar>

				<!--- Sidemenu -->
				<ul class="side-nav">

					<li class="side-nav-title side-nav-item">Navigation</li>

					<li class="side-nav-item"><a href="{{url('dashboard')}}" class="side-nav-link"><i class="uil-home-alt"></i><span> Dashboards </span></a></li>
					<li class="side-nav-item">
						<a data-bs-toggle="collapse" href="#sidebarPermission" aria-expanded="true" aria-controls="sidebarPermission" class="side-nav-link"><i class=" uil-user-check "></i><span> Permission </span><span class="menu-arrow"></span></a>
						<div class="collapse" id="sidebarPermission">
							<ul class="side-nav-second-level">
								<li><a href="{{url('dashboard/permission')}}"> Permission</a></li>
								
							</ul>
						</div>
					</li>
					<li class="side-nav-item">
						<a data-bs-toggle="collapse" href="#sidebarRole" aria-expanded="false" aria-controls="sidebarUser" class="side-nav-link"><i class=" uil-user-check "></i><span> Role </span><span class="menu-arrow"></span></a>
						<div class="collapse" id="sidebarRole">
							<ul class="side-nav-second-level">
								<li><a href="{{url('dashboard/role')}}">Role</a></li>
							</ul>
						</div>
					</li>
					<li class="side-nav-item">
						<a data-bs-toggle="collapse" href="#sidebarUser" aria-expanded="false" aria-controls="sidebarUser" class="side-nav-link"><i class=" uil-user-check "></i><span> Users </span><span class="menu-arrow"></span></a>
						<div class="collapse" id="sidebarUser">
							<ul class="side-nav-second-level">
								<li><a href="{{url('dashboard/user')}}">All User</a></li>
								<li><a href="{{url('dashboard/user/add')}}">Add User</a></li>
							</ul>
						</div>
					</li>

					<li class="side-nav-item">
						<a data-bs-toggle="collapse" href="#sidebarIncome" aria-expanded="false" aria-controls="sidebarIncome" class="side-nav-link"><i class=" uil-bitcoin "></i><span> Payment Types </span><span class="menu-arrow"></span></a>
						<div class="collapse" id="sidebarIncome">
							<ul class="side-nav-second-level">
								<li><a href="{{url('dashboard/income/category')}}">Payment Types</a></li>
								<li><a href="{{url('dashboard/income/category/add')}}">Add Payment Types</a></li>
							</ul>
						</div>
					</li>

					<li class="side-nav-item">
						<a data-bs-toggle="collapse" href="#sidebarIIncome" aria-expanded="false" aria-controls="sidebarIIncome" class="side-nav-link"><i class=" uil-bitcoin "></i><span> Payments  </span><span class="menu-arrow"></span></a>
						<div class="collapse" id="sidebarIIncome">
							<ul class="side-nav-second-level">
								<li><a href="{{url('dashboard/income')}}">Payments</a></li>
								<li><a href="{{url('dashboard/income/add')}}">New Payment</a></li>
							</ul>
						</div>
					</li>

					<li class="side-nav-item">
						<a data-bs-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="reports" class="side-nav-link"><i class=" uil-chart-pie "></i><span> Reports  </span><span class="menu-arrow"></span></a>
						<div class="collapse" id="reports">
							<ul class="side-nav-second-level">
								<li><a href="{{url('dashboard/report/reports')}}">General Reports</a></li>
								<li><a href="{{url('dashboard/report/current')}}">Currennt Month Report</a></li>
								<li><a href="{{url('dashboard/report/summary')}}">Summary Report</a></li>
								<li><a href="{{url('dashboard/report/')}}">Last 7 Day Report</a></li>
							</ul>
						</div>
					</li>

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
							<a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<i class="dripicons-search noti-icon"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
								<form class="p-3">
									<input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
								</form>
							</div>
						</li>
						<li class="dropdown notification-list topbar-dropdown">
							<a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<img src="{{asset('contents/admin')}}/assets/images/flags/us.jpg" alt="user-image" class="me-0 me-sm-1" height="12">
								<span class="align-middle d-none d-sm-inline-block">English</span> <i class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu">
								<a href="javascript:void(0);" class="dropdown-item notify-item">
									<img src="{{asset('contents/admin')}}/assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
								</a>
							</div>
						</li>
						<li class="dropdown notification-list">
							<a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<i class="dripicons-bell noti-icon"></i>
								<span class="noti-icon-badge"></span>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">
								<div class="dropdown-item noti-title">
									<h5 class="m-0">
										<span class="float-end">
											<a href="javascript: void(0);" class="text-dark">
												<small>Clear All</small>
											</a>
										</span>Notification
									</h5>
								</div>
								<div style="max-height: 230px;" data-simplebar>
									<!-- item-->
									<a href="javascript:void(0);" class="dropdown-item notify-item">
										<div class="notify-icon bg-primary">
											<i class="mdi mdi-comment-account-outline"></i>
										</div>
										<p class="notify-details">Caleb Flakelar commented on Admin
											<small class="text-muted">1 min ago</small>
										</p>
									</a>
								</div>
								<a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
									View All
								</a>
							</div>
						</li>
						<li class="dropdown notification-list">
							<a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<span class="account-user-avatar">
									<img src="{{asset('contents/admin')}}/assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
								</span>
								<span>
									<span class="account-user-name">{{Auth::user()->name}}</span>
									<span class="account-position">{{Auth::user()->email}}</span>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
								<!-- item-->
								<div class=" dropdown-header noti-title">
									<h6 class="text-overflow m-0">Welcome !</h6>
								</div>

								<!-- item-->
								<a href="javascript:void(0);" class="dropdown-item notify-item">
									<i class="mdi mdi-account-circle me-1"></i>
									<span>My Account</span>
								</a>

								<!-- item-->
								<a href="javascript:void(0);" class="dropdown-item notify-item">
									<i class="mdi mdi-account-edit me-1"></i>
									<span>Settings</span>
								</a>

								<!-- item-->
								<a href="javascript:void(0);" class="dropdown-item notify-item">
									<i class="mdi mdi-lifebuoy me-1"></i>
									<span>Support</span>
								</a>

								<!-- item-->
								<a href="javascript:void(0);" class="dropdown-item notify-item">
									<i class="mdi mdi-lock-outline me-1"></i>
									<span>Lock Screen</span>
								</a>

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
						<form>
							<div class="input-group">
								<input type="text" class="form-control dropdown-toggle" placeholder="Search..." id="top-search">
								<span class="mdi mdi-magnify search-icon"></span>
								<button class="input-group-text btn-primary" type="submit">Search</button>
							</div>
						</form>

						<div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">
							<!-- item-->
							<div class="dropdown-header noti-title">
								<h5 class="text-overflow mb-2">Found <span class="text-danger">1</span> results</h5>
							</div>

							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item notify-item">
								<i class="uil-notes font-16 me-1"></i>
								<span>Analytics Report</span>
							</a>
						</div>
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
										<div class="input-group">
											<input type="text" class="form-control form-control-light" id="dash-daterange">
											<span class="input-group-text bg-primary border-primary text-white">
												<i class="mdi mdi-calendar-range font-13"></i>
											</span>
										</div>
										<a href="javascript: void(0);" class="btn btn-primary ms-2">
											<i class="mdi mdi-autorenew"></i>
										</a>
										<a href="javascript: void(0);" class="btn btn-primary ms-1">
											<i class="mdi mdi-filter-variant"></i>
										</a>
									</form>
								</div>
								<h4 class="page-title">Dashboard</h4>
							</div>
						</div>
					</div>
					<!-- end page title -->

					@yield('content')

				</div>
			</div>

			<!-- Footer Start -->
			<footer class="footer">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<script>
								document.write(new Date().getFullYear())

							</script> Sabbbir Hossai2021
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
	<script src="{{asset('contents/admin')}}/assets/js/custom.js"></script>
</body>

</html>
