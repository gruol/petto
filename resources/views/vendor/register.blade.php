<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bdtask">
    <title>Register</title>
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">
    <link href="{{asset('b/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('b/plugins/bootstrap/css/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{asset('b/plugins/bootstrap/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('b/plugins/bootstrap/css/typicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('b/plugins/bootstrap/css/themify-icons.min.css')}}" rel="stylesheet">
    <link href="{{asset('b/dist/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('b/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('b/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet" />

    <link href="{{asset('b/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

    <style type="text/css">
    body{
        background-image: url({{asset('assets/images/loginBack.png')}});
        height: 100%; 
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
</head>
<body class="bg-white">
    <div class="d-flex align-items-center justify-content-center text-center h-100vh">
        <div class="form-wrapper m-auto" style="position: absolute;left: 15%;">
            <div class="form-container my-4" style="max-width:100% !important">
                <div class="register-logo text-center ">
                    <img src="{{asset('assets/images/logo.png')}}" alt="">
                </div>
                <div class="panel">
                    <div class="panel-header text-center mb-3">
                        <h3 class="fs-24">Register new account!</h3>
                        {{-- <p class="text-muted text-center mb-0">Nice to see you! Please log in with your account.</p> --}}
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{route('vendor.register')}}"  method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Enter Business Name" value="" required>
                            </div>
                            <div class="col-md-4 mb-3">
                               <input type="text" class="form-control" name="ntn" id="ntn" placeholder="Enter NTN" value="" required>
                           </div>
                           <div class="col-md-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                </div>
                                <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="Enter Vender Name" aria-describedby="inputGroupPrepend2" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            {{-- <input type="number" class="form-control" id="cnic"   name="cnic" placeholder="Enter CNIC" required> --}}
                            <input type="text" class="form-control"   id="cnic"   name="cnic"  data-inputmask="'mask': '9999999999999'"  placeholder="CNIC"  name="cnic" required="" >

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="web_link" name="web_link" placeholder="Enter Website URL" >
                        </div>
                        <div class="col-md-4 mb-3">
                            <select class="form-control product_category" name="product_category[]" placeholder="Enter Website URL" multiple="">
                                <option disabled="" value="">Select Product category</option>
                                @foreach($product_category as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>}
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <input type="password" class="form-control" id="password"   name="password" placeholder=" Password" required>
                        </div>
                        <div class="col-md-4 mb-3">

                            <input type="password" class="form-control" id="confirmpassword"   name="confirmpassword" placeholder="Confirmed Password" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="address"   name="address" placeholder="Enter Address" required>
                        </div>
                    </div>
                   {{--  <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                            <label class="form-check-label" for="invalidCheck2">
                                Agree to terms and conditions
                            </label>
                        </div>
                    </div> --}}
                    <br>
                    <button class="btn btn-success float-left" type="submit">Submit</button>
                    <br>
                    <p class="text-muted text-center mt-3 mb-0">
                        Are you Admin? <a class="external" href="{{route('login')}}"> Click Here.</a>
                    </p>
                    <p class="text-muted text-center mt-3 mb-0">

                        Login? <a class="external" href="{{route('vendor.login')}}"> Click Here.</a>
                    </p>
                </form>
            </div>
            
        </div>
    </div>
</div>
@include("admin.temp.footer-script")
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>


<script>
    $('.product_category').select2({
     placeholder: "Select Product Category",
     allowClear: true
 });
    $(":input").inputmask();
</script>
