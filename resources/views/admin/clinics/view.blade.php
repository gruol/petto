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
                        <div class="row align-items-center">
                          <div class="col">  
                            <h6 class="mb-0 font-weight-600">Clinic Address</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$clinic->address}}</a>
                        </div>
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
                        <h6 class="fs-17 font-weight-600 mb-0">Doctor Details</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
               @if(!$clinic->doctors->isEmpty())
               @foreach($clinic->doctors as $i => $doctor)
               <div>

                <b>{{$i+1}} ) </b> 



                <br>
            </div>
            <br>
            <div class="row">
               <div class="col-md-3 pr-md-1">
                <div class="form-group">
                    <label class="font-weight-600">Doctor Name</label>
                    <input type="text" class="form-control" disabled="" value="{{$doctor->name}}">
                </div>
            </div>
            <div class="col-md-3 pr-md-1">
                <div class="form-group">
                    <label class="font-weight-600">Contact No</label>
                    <input type="text" class="form-control" disabled="" value="{{$doctor->contact}}">
                </div>
            </div>
            <div class="col-md-3 pr-md-1">
                <div class="form-group">
                    <label class="font-weight-600">Email</label>
                    <input type="text" class="form-control" disabled="" value="{{$doctor->email}}">
                </div>
            </div>

            <div class="col-md-3 pr-md-1">
                <div class="form-group">
                    <label class="font-weight-600">Education</label>
                    <input type="text" class="form-control" disabled="" value="{{$doctor->education}}">
                </div>
            </div>

            <div class="col-md-3 pr-md-1">
                <div class="form-group">
                    <label class="font-weight-600">Experience</label>
                    <input type="text" class="form-control" disabled="" value="{{$doctor->experience}}">
                </div>
            </div>

            <div class="col-md-3 pr-md-1">
                <div class="form-group">
                    <label class="font-weight-600">Expertise</label>
                    <input type="text" class="form-control" disabled="" value="{{$doctor->expertise}}">
                </div>
            </div>
           {{--  <div class="col-md-3 pr-md-1">
                <div class="form-group">
                    <label class="font-weight-600">Doctor Status</label>
                    <input type="text" class="form-control" disabled="" value="@if($doctor->is_approved == 0  )
                    Pending
                    @elseif($doctor->is_approved == 1)
                    Approved
                    @else
                    Rejected
                    @endif">
                </div>
            </div> --}}
            <div class="col-md-3 pr-md-1">
                <div class="form-group">
                    <label class="font-weight-600">Charges</label>
                    <input type="text" class="form-control" disabled="" value="{{$doctor->charges}}">
                </div>
            </div>
            <div class="col-md-3 pr-md-1">
                <div class="form-group">
                    <label class="font-weight-600">Update Status</label>

                    <div class="form-check">
                        <input  type="checkbox" {{($doctor->is_approved == 1 ? "checked" : '')}} value="1" data-doc_id="{{$doctor->id}}" name="is_approved" id="UpdateStatus" class="UpdateStatus" >
                      <label class="form-check-label" for="UpdateStatus">Mark Approved</label>
                  </div>
                  <div class="form-check">
                      <input {{($doctor->is_approved == 2 ? "checked" : '')}}  type="checkbox" value="2" name="is_approved" data-doc_id="{{$doctor->id}}" class="UpdateStatus" id="UpdateStatus" >
                      <label class="form-check-label" for="UpdateStatus">Mark Rejected</label>
                  </div>
              </div>
          </div>
          <div class="col-md-12 pr-md-1">
            <div class="form-group">
                <label class="font-weight-600">Appointment Dates & Timings</label>
                @if(!empty($doctor->AppointmentTime))
                @foreach($doctor->AppointmentTime as $key => $appointmentTime)
                <div>

                    <b> {{($appointmentTime->time ?? $appointmentTime->time)}} - 
                        {{isset($doctor->AppointmentDay[$key]->day) ? $doctor->AppointmentDay[$key]->day : '-'}} - 
                        {{isset($doctor->AppointmentDate[$key]->dates) ? $doctor->AppointmentDate[$key]->dates : '-'}} 
                    </b>  
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="col-md-3 pr-md-1">
            <div class="form-group">
                <p style="cursor: pointer;font-weight: bold;" class=" images" title="{{asset('storage/uploads/clinic/doctor/'.Auth::user()->id.'/'.$doctor->picture)}}">Click to View Profile Picture</p>
            </div>
        </div>

    </div>
    <hr>
    @endforeach
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

        $("input[name='is_approved']").on("change", function (e) {
          
            var r = confirm("Do you want to Update Doctor Status?");

            if (r == true) {
                let url = "{{ route('admin.appointment.status.update') }}";
                  $.ajax({
                  url: url, 
                  type: "GET",
                  data: {
                    status: this.value,
                    doctor_id: $(this).data("doc_id")
                  },
                  success: function(data) {
                    location.reload();

                  }
                });
            } else {
                // He refused the confirmation
            }
        });

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