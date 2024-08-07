
@include("admin.temp.meta")
<body class="fixed">
    @include("admin.temp.loader")
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="main-content">

                <body>
                    <div class="account-pages my-5 pt-sm-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-center mb-5 text-muted">
                                        <img src="assets/images/logo-dark.png" alt="" height="20" class="auth-logo-dark mx-auto">
                                        <img src="assets/images/logo-light.png" alt="" height="20" class="auth-logo-light mx-auto">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="alert alert-info mb-0" id="otpAlert" role="alert" style="display: none;">
                            <p id="otpMessage"></p>
                        </div>
                        <div class="row justify-content-center">
                            {{-- @include('layouts.partials.alerts') --}}
                            <div class="col-md-8 col-lg-6 col-xl-5">
                                <div class="card">

                                    <div class="card-body">

                                        <div class="p-2">
                                            <div class="text-center">

                                                <div class="avatar-md mx-auto">
                                                    <div class="avatar-title rounded-circle bg-light">
                                                        <i class="bx bxs-envelope h1 mb-0 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="p-2 mt-4">

                                                    <h4>Verify your account to proceed</h4>
                                                    <div class="mt-3"></div>
                                                    <form method="POST" action="">
                                                        @csrf
                                                       {{--  <input class="form-check-input" type="radio" name="otpVia"
                                                        id="otpVia" value=1>
                                                        <label class="form-check-label" for="formRadiosRight1">
                                                            Via SMS
                                                        </label>


                                                        <input class="form-check-input" type="radio" name="otpVia"
                                                        id="otpVia" value=2>
                                                        <label class="form-check-label" for="formRadiosRight2">
                                                            Via E-mail
                                                        </label> --}}
                                                        <div class="mt-3"></div>

                                                        <button type="button" onclick="sendOtp();" class="btn btn-primary btn-sm">
                                                            Send OTP
                                                        </button>
                                                    </form>
                                                    <hr>
                                                    <p class="mb-5">Please enter the 6 digit code sent to <span
                                                        class="fw-semibold">your email</span></p>

                                                        <form method="POST" action="">
                                                            @csrf
                                                            <div class="row">
                                                                <input type="number" class="form-control" name="otp">
                                                            </div>
                                                            <div class="mt-4">
                                                                <button type="submit" class="btn btn-success">Verify</button>
                                                            </div>
                                                        </form>


                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mt-5 text-center">
                                        <p>Didn't receive a code ? <a href="#" class="fw-medium text-primary"> Resend </a> </p>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </body>
            </div>

        </div>
        @include("admin.temp.footer-script")
        @section('js')
        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- two-step-verification js -->
        <script src="assets/js/pages/two-step-verification.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <script>

            $(document).ready(function(){
                $("#otpAlert").hide();



            });
            function sendOtp(){

             var otpChoice = $("input[name='otpVia']:checked").val();
        //    alert(typeof(otpChoice));
        //    return false;
        //   var otpChoice = 25;
        var requestData = {otpChoice : otpChoice};  
        $.ajax({

            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            cache:false,
            processData:false,
            contentType:false,
            {{-- url: '{{route('supervisor.sendOtp')}}', --}}
            data: otpChoice,
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                    // alert(res);
                    $('.handle').attr('style','display: block');
                    $('#otpMessage').text(res);
                    $("#otpAlert").show('slow');
                    $("#otpAlert").delay(3200).fadeOut(300);



                }


            });

    }
</script>

@endsection