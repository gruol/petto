<nav class="sidebar sidebar-bunker no-print no-print">
	<div class="sidebar-header">
		{{-- <a href="#" class="logo"><span>Tyler Firm</span></a> --}}
		<a href="{{url("/")}}" class="logo"><img src="{{asset('assets/images/logo/logo.png')}}" alt=""></a>
		{{-- <a href="{{url("/")}}" class="logo"><img src="{{asset('assets/images/logo/logo.webp')}}" alt=""></a> --}}
	</div>
	<div class="profile-element d-flex align-items-center flex-shrink-0">
		{{-- <div class="avatar online">
			<img src="assets/dist/img/avatar-1.jpg" class="img-fluid rounded-circle" alt="">
		</div> --}}

		<div class="profile-text">

			{{-- <span>{{ auth()->user()->email }}</span> --}}
		</div>
	</div>
	<div class="sidebar-body" style="height: 100% !important;">
		<nav class="sidebar-nav">
			<ul class="metismenu">
				{{-- <li class="nav-label">Main Menu</li> --}}
				{{-- @can('dashboard-view') --}}
				<li class="@if(Request::segment(2) == "dashboard" || Request::segment(2) == "home")) {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('vendor.dashboard') }}">
						<i class="typcn typcn-home-outline mr-2"></i>
						Dashboard
					</a>
				</li>
				<li class="@if( Request::segment(2) == "shipment") {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('vendor.products') }}">
						<i class="fa fa-product-hunt  mr-2"></i>Products</a>
				</li>
				<li>
					<a class="dropdown-item" href="{{ route('vendor.logout') }}"
					onclick="event.preventDefault();
					document.getElementById('logout-form').submit();"><i class="typcn typcn-user-delete mr-2"></i> Logout</a>
					<form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" class="d-none">
						@csrf
					</form> 
					<form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" class="d-none">
						@csrf
					</form>
				</li>
			</ul>
		</nav>
	</div><!-- sidebar-body -->
</nav>