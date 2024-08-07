@include("vendor.temp.meta")
<body class="fixed">
@include("vendor.temp.loader")
<div class="wrapper">
	@include("vendor.temp.sidebar")
	<div class="content-wrapper">
		<div class="main-content">
			@include("vendor.temp.top")
			@include("vendor.temp.breadcrumb", compact("pageTitle"))
			@yield('content')
			@include("vendor.temp.footer")
		</div>
	</div>
	
</div>
@include("vendor.temp.footer-script")
@yield('footer-script')