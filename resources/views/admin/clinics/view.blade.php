@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style type="text/css">
    /* Style the Image Used to Trigger the Modal */
    .imgView {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        color: #FFB425 !important;
    }
    .imgView p{
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        color: #FFB425 !important;
    }
    .imgView:hover {opacity: 0.7;}
/* The Modal (background) */
#image-viewer {
    display: none;
    position: fixed;
    z-index: 100000;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.9);
}
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 600px;
}
.modal-content { 
    animation-name: zoom;
    animation-duration: 0.6s;
}
@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}
#image-viewer .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}
#image-viewer .close:hover,
#image-viewer .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}

</style>
<div class="body-content">

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Clinic Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Manager Name</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$clinic->manager_name}}</a>
                        </div>
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Contact No</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$clinic->contact}}</a>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div> 
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Email</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$clinic->email}}</a>
                        </div>
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Clinic Name</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$clinic->clinic_name}}</a>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div> 
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Shipment Detail</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <h6 class="fs-17 font-weight-600 mb-0">Clinic Details</h6>
                    <br>
                    <div class="row">
                           <div class="col-md-3 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Clinic Name</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->clinic_name}}">
                            </div>
                        </div>
                        <div class="col-md-3 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Manager Name</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->manager_name}}">
                            </div>
                        </div>
                        <div class="col-md-3 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Contact No</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->contact}}">
                            </div>
                        </div>
                     
                        <div class="col-md-3 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Email</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->email}}">
                            </div>
                        </div>
                      
                    </div>
                    <hr class="mt-2 mb-3"/>

                    <div class="row">
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Category</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->category}}">
                            </div>
                        </div>

                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Gross Weight (KG)</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->gross_weight}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Pet Dimensions</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->pet_dimensions}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Do you have a cage as per IATA standard</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->have_cage}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Cage Dimensions</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->cage_dimensions}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Want Booking</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->want_booking}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Shipper Name</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->shipper_name}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Shipper Address</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->shipper_address}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Shipper CNIC</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->shipper_cnic}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Shipper Contact</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->shipper_contact}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Shipper Email</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->shipper_email}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Consignee Name</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->consignee_name}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Consignee Address</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->consignee_address}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Consignee Contact</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->consignee_contact}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Consignee Email</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->consignee_email}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Consignee Email</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->consignee_email}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Microchip</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->microchip}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Microchip No</label>
                                <input type="text" class="form-control" disabled="" value="{{$clinic->microchip_no}}">
                            </div>
                        </div>
                    </div>
                
             </div>
         </div>
     </div>
 </div>
</div>
<div id="image-viewer">
    <span class="close">&times;</span>
    <span id="full-close"></span>
</div>
@endsection
@section('footer-script')
<script>
    $(document).ready(function(){
        var title = $('img').attr('title');
        $('img').before(title);
    });
    $(".images").click(function(){
        var fileType = $(this).attr("src");
        console.log(fileType);
        var result = fileType.split(/[.;+_]/).pop();
        if (result == 'pdf') {
            $("#full-close").empty()
            $('#full-close').append('<iframe class="modal-content"  width="100%" height="500px" src="'+$(this).attr("src")+'"  id="full-image"> </iframe>')
        }else {
            $('#full-close').empty();
            $('#full-close').append('<img class="modal-content" width="100%" height="500px" src="'+$(this).attr("src")+'"  id="full-image">')

        }
        $('#image-viewer').show();
    });

    $("#image-viewer .close").click(function(){
      $('#image-viewer').hide();
  });

  // $(".img-zoom-m").ezPlus();
</script>
@endsection