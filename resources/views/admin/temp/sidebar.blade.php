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
			<h6 class="m-0">{{ auth()->user()->name }}</h6>
			<span>{{ auth()->user()->email }}</span>
		</div>
	</div>
	<div class="sidebar-body" style="height: 100% !important;">
		<nav class="sidebar-nav">
			<ul class="metismenu">
				{{-- <li class="nav-label">Main Menu</li> --}}
				{{-- @can('dashboard-view') --}}
				<li class="@if(Request::segment(2) == "dashboard" || Request::segment(2) == "home")) {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.dashboard') }}">
						<i class="typcn typcn-home-outline mr-2"></i>
						Dashboard
					</a>
				</li>
				{{-- @endcan --}}
				@can('roles-list')
				<li class="@if(Request::segment(2) == "roles")) {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.roles.index') }}">
						<i class="typcn typcn-key-outline mr-2"></i>
						Roles
					</a>
				</li>
				@endcan
				@can('users-list')
				<li class="@if(Request::segment(2) == "users")) {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.users.index') }}">
						<i class="typcn typcn-user mr-2"></i>
						Users
					</a>
				</li>
				@endcan
				{{-- @can('orders-list') --}}
				<li class="@if( Request::segment(2) == "shipment") {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.shipment.index') }}">
						<i class="typcn typcn-plane  mr-2"></i>Shipments</a>
				</li>
				<li class="@if( Request::segment(2) == "clinic") {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.clinic.index') }}">
						<i class='fas fa-hospital mr-2'> </i> Clinics
					</a>
				</li>
				<li class="@if( Request::segment(2) == "doctors") {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.doctors.index') }}">
						<i class="fas fa-user-md mr-2"></i> Doctors
					</a>
				</li>
				<li class="@if( Request::segment(2) == "appointments") {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.appointments.index') }}">
						<i class='fas fa-book mr-2'> </i> Appointments
					</a>
				</li>
				<li class="@if( Request::segment(2) == "vendors") {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.vendors.index') }}">
						<i class='fas fa-users mr-2'> </i> Vendors
					</a>
				</li>
				{{-- @endcan --}}

				<li  class="@if( Request::segment(2) == "change-password") {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.changePassword') }}">
						<i class="typcn typcn-user mr-2"></i>
						Change Password
					</a>
				</li>
				<li>
					

					     <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="typcn typcn-user-delete mr-2"></i> Logout</a>
                                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                 @csrf
                                             </form> 
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
				</li>
			</ul>
		</nav>
	</div><!-- sidebar-body -->
</nav>