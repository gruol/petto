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
                            <h6 class="fs-17 font-weight-600 mb-0">Customer & Pet Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Name</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$appointment->customer->name}}</a>
                        </div>
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Contact No</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$appointment->customer->contact_no}}</a>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div> 
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Email</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$appointment->customer->email}}</a>
                        </div>
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Country</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$appointment->customer->country}}</a>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div> 

                         <hr>
                    <div class="row align-items-center">
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Pet Name</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$appointment->pet->name}}</a>
                        </div>
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Pet Breed</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$appointment->pet->breed}}</a>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Appointment Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                   @if(isset($appointment))
                   <br>
                   <div class="row">
                       <div class="col-md-3 pr-md-1">
                        <div class="form-group">
                            <label class="font-weight-600">Appointment Date</label>
                            <input type="text" class="form-control" disabled="" value="{{$appointment->appointment_date}}">
                        </div>
                    </div>
                    <div class="col-md-3 pr-md-1">
                        <div class="form-group">
                            <label class="font-weight-600">Appointment Day</label>
                            <input type="text" class="form-control" disabled="" value="{{$appointment->appointment_day}}">
                        </div>
                    </div>
                    <div class="col-md-3 pr-md-1">
                        <div class="form-group">
                            <label class="font-weight-600">Appointment Time Slot</label>
                            <input type="text" class="form-control" disabled="" value="{{$appointment->appointment_timeslot}}">
                        </div>
                    </div>

                    <div class="col-md-3 pr-md-1">
                        <div class="form-group">
                            <label class="font-weight-600">Status</label>
                            <input type="text" class="form-control" disabled="" value="{{$appointment->status}}">
                        </div>
                    </div>

                    <div class="col-md-3 pr-md-1">
                        <div class="form-group">
                            <label class="font-weight-600">Is Confirmed</label>
                            <input type="text" class="form-control" disabled="" value="{{($appointment->is_confirmed = 1 ? "Yes" : "No" )}}">
                        </div>
                    </div>

                    <div class="col-md-3 pr-md-1">
                        <div class="form-group">
                            <label class="font-weight-600">Is Canceled</label>
                            <input type="text" class="form-control" disabled="" value="{{($appointment->is_canceled == 1 ? "Yes" : "No")}}">
                        </div>
                    </div>
                    <div class="col-md-3 pr-md-1">
                        <div class="form-group">
                            <label class="font-weight-600">Reason for Cancellation</label>
                            <input type="text" class="form-control" disabled="" value="{{$appointment->reason_for_cancellation}}">
                        </div>
                    </div>
                    <div class="col-md-3 pr-md-1">
                        <div class="form-group">
                            <label class="font-weight-600">Canceled By</label>
                            <input type="text" class="form-control" disabled="" value="{{$appointment->canceled_by}}">
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Doctor & Clinic Details</h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                   <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Doctor Name</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->name}}">
                    </div>
                </div>
                <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Contact</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->contact}}">
                    </div>
                </div>
                <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Email</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->email}}">
                    </div>
                </div>
                <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Education</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->education}}">
                    </div>
                </div>
                <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Experience</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->experience}}">
                    </div>
                </div>
                <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Charges</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->charges}}">
                    </div>
                </div>
                <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Clinic Name</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->clinic->clinic_name}}">
                    </div>
                </div>
                <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Clinic Manager Name</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->clinic->manager_name}}">
                    </div>
                </div>
                <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Clinic Email</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->clinic->email}}">
                    </div>
                </div>
                 <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Clinic Contact</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->clinic->contact}}">
                    </div>
                </div>
                 <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Clinic City</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->clinic->city}}">
                    </div>
                </div>
                 <div class="col-md-3 pr-md-1">
                    <div class="form-group">
                        <label class="font-weight-600">Clinic Address</label>
                        <input type="text" class="form-control" disabled="" value="{{$appointment->doctor->clinic->address}}">
                    </div>
                </div>
            </div>
            <hr>
            @endif
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
        var title = $('p').attr('title');
        $('img').before(title);
    });
    $(".images").click(function(){
        console.log('aaaaaa');
        var fileType = $(this).attr("title");
        console.log(fileType);
        // return false;
        var result = fileType.split(/[.;+_]/).pop();
        if (result == 'pdf') {
            $("#full-close").empty()
            $('#full-close').append('<iframe class="modal-content"  width="100%" height="500px" src="'+$(this).attr("title")+'"  id="full-image"> </iframe>')
        }else {
            $('#full-close').empty();
            $('#full-close').append('<img class="modal-content" width="100%" height="500px" src="'+$(this).attr("title")+'"  id="full-image">')

        }
        $('#image-viewer').show();
    });

    $("#image-viewer .close").click(function(){
      $('#image-viewer').hide();
  });

  // $(".img-zoom-m").ezPlus();
</script>
@endsection