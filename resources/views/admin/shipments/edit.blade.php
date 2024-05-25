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
.upload__box {
    padding: 20px 0px;
}
.upload__btn-box {
    margin-bottom: 10px;
}
.upload__btn {
    display: inline-block;
    font-weight: 600;
    color: #fff;
    text-align: center;
    min-width: 116px;
    /* padding: 5px; */
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid;
    background-color: #4045ba;
    border-color: #4045ba;
    border-radius: 10px;
    line-height: 26px;
    font-size: 14px;
}
.upload__inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}
.upload__img-wrap {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -10px;
}
.upload__img-box {
    width: 200px;
    padding: 0 10px;
    margin-bottom: 12px;
}
element.style {
}
.upload__btn:hover {
    background-color: unset;
    color: #4045ba;
    transition: all 0.3s ease;
}
.upload__img-close {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: rgba(0, 0, 0, 0.5);
    position: absolute;
    top: 10px;
    right: 10px;
    text-align: center;
    line-height: 24px;
    z-index: 1;
    cursor: pointer;
}
.upload__img-close:after {
    content: '\2716';
    font-size: 14px;
    color: white;
}
.img-bg {
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    position: relative;
    padding-bottom: 100%;
}
</style>
<div class="body-content">

    <div class="row  mb-4">
        {{-- @if(isset($shipment->pet_photo1)) --}}
        <img  src="{{asset('storage/uploads/pet/'.$shipment->id.'/'.$shipment->pet_photo1)}}" title="Pet’s 1st Photo  inside the cage & outside the cage is missing" style="object-fit: cover;" width="200" height="150" class="img-thumbnail images"/>  
      
        {{-- @endif --}}

        {{-- @if(isset($shipment->pet_photo2)) --}}
        <img  src="{{asset('storage/uploads/pet/'.$shipment->id.'/'.$shipment->pet_photo2)}}" title="Pet’s 2nd Photo  inside the cage & outside the cage is missing" style="object-fit: cover;" width="200" height="150" class="img-thumbnail images"/> 
        {{-- @endif --}}
        {{-- @if(isset($shipment->pet_passport)) --}}
        <img  src="{{asset('storage/uploads/pet/'.$shipment->id.'/'.$shipment->pet_passport)}}" title="Pet’s Passport is missing" style="object-fit: cover;" width="200" height="150" class="img-thumbnail images"/>
        {{-- @endif             --}}
        {{-- @if(isset($shipment->health_certificate)) --}}
        <img  src="{{asset('storage/uploads/pet/'.$shipment->id.'/'.$shipment->health_certificate)}}" title="Pet Health Certificate (Disclaimer - must be approved by Private Vet)  is missing" style="object-fit: cover;" width="200" height="150" class="img-thumbnail images"/>
        {{-- @endif             --}}
        {{-- @if(isset($shipment->import_permit)) --}}
        <img  src="{{asset('storage/uploads/pet/'.$shipment->id.'/'.$shipment->import_permit)}}" title="Pet Import Permit (Subject to Destination e.g. UAE issued from moccae.gov.ae) is missing" style="object-fit: cover;" width="200" height="150" class="img-thumbnail images"/>
        {{-- @endif  --}}
        {{-- @if(isset($shipment->titer_report)) --}}
        <img  src="{{asset('storage/uploads/pet/'.$shipment->id.'/'.$shipment->titer_report)}}" title="Rabies titer Report (Disclaimer - for UAE, CA, issued from UVAS LAHORE & for U.K Europe EU Approved Laborites Destination authorities) is missing" style="object-fit: cover;" width="200" height="150" class="img-thumbnail images"/>
        {{-- @endif  --}}
        {{-- @if(isset($shipment->passport_copy)) --}}
        <img  src="{{asset('storage/uploads/pet/'.$shipment->id.'/'.$shipment->passport_copy)}}" title="Passport Copy Disclaimer - (Bio Page)  is missing" style="object-fit: cover;" width="200" height="150" class="img-thumbnail images"/>
        {{-- @endif  --}}
        {{-- @if(isset($shipment->cnic_copy)) --}}
        <img  src="{{asset('storage/uploads/pet/'.$shipment->id.'/'.$shipment->cnic_copy)}}" title="CNIC Copy is missing" style="object-fit: cover;" width="200" height="150" class="img-thumbnail images"/>
        {{-- @endif  --}}
        {{-- @if(isset($shipment->ticket_copy)) --}}
        <img  src="{{asset('storage/uploads/pet/'.$shipment->id.'/'.$shipment->ticket_copy)}}" title="Ticket Copy is missing" style="object-fit: cover;" width="200" height="150" class="img-thumbnail images"/>
        {{-- @endif  --}}
        {{-- @if(isset($shipment->visa_copy)) --}}
        <img  src="{{asset('storage/uploads/pet/'.$shipment->id.'/'.$shipment->visa_copy)}}" title="Visa Copy is missing" style="object-fit: cover;" width="200" height="150" class="img-thumbnail images"/>
        {{-- @endif  --}}
    </div>
    
   
    <div class="row mb-4 text-center">
    <form  method="POST"  action="{{route('admin.shipment.update')}}"  enctype="multipart/form-data" novalidate>
    @csrf
    <input type="hidden" name="shipment_id" value="{{$shipment->id}}">
        <div class="row ">
            <div class="col-md-6 mt-4">  
                <label> Pet’s 2nd Photo  inside the cage & outside the cage</label>
            </div>
            <div class="col-md-6">  
                <div class="upload__box">
                  <div class="upload__btn-box">
                    <label class="upload__btn">
                      <p>Click to Update </p>
                      <input type="file" name="pet_photo1"  data-max_length="20" class="upload__inputfile">
                    </label>
                  </div>
                  <div class="upload__img-wrap"></div>
                </div>
            </div>
            </div>
            <div class="row ">
            <div class="col-md-6 mt-4">  
                <label> Pet’s 2nd Photo  inside the cage & outside the cage</label>
            </div>
            <div class="col-md-6">  
                <div class="upload__box">
                  <div class="upload__btn-box">
                    <label class="upload__btn">
                      <p>Click to Update </p>
                      <input type="file" name="pet_photo2"  data-max_length="20" class="upload__inputfile">
                    </label>
                  </div>
                  <div class="upload__img-wrap"></div>
                </div>
            </div>
            </div>
               <div class="row ">
            <div class="col-md-6 mt-4">  
                <label>Pet’s Passport </label>
            </div>
            <div class="col-md-6">  
                <div class="upload__box">
                  <div class="upload__btn-box">
                    <label class="upload__btn">
                      <p>Click to Update </p>
                      <input type="file" name="pet_passport"  data-max_length="20" class="upload__inputfile">
                    </label>
                  </div>
                  <div class="upload__img-wrap"></div>
                </div>
            </div>
            </div>
              <div class="row ">
            <div class="col-md-6 mt-4">  
                <label>Pet Health Certificate (Disclaimer - must be approved by Private Vet) </label>
            </div>
            <div class="col-md-6">  
                <div class="upload__box">
                  <div class="upload__btn-box">
                    <label class="upload__btn">
                      <p>Click to Update </p>
                      <input type="file" name="health_certificate"  data-max_length="20" class="upload__inputfile">
                    </label>
                  </div>
                  <div class="upload__img-wrap"></div>
                </div>
            </div>
            </div>
            <div class="row ">
            <div class="col-md-6 mt-4">  
                <label>Pet Import Permit (Subject to Destination e.g. UAE issued from moccae.gov.ae) </label>
            </div>
            <div class="col-md-6">  
                <div class="upload__box">
                  <div class="upload__btn-box">
                    <label class="upload__btn">
                      <p>Click to Update </p>
                      <input type="file" name="import_permit"  data-max_length="20" class="upload__inputfile">
                    </label>
                  </div>
                  <div class="upload__img-wrap"></div>
                </div>
            </div>
            </div>
                <div class="row ">
            <div class="col-md-6 mt-4">  
                <label>Rabies titer Report (Disclaimer - for UAE, CA, issued from UVAS LAHORE & for U.K Europe EU Approved Laborites Destination authorities) </label>
            </div>
            <div class="col-md-6">  
                <div class="upload__box">
                  <div class="upload__btn-box">
                    <label class="upload__btn">
                      <p>Click to Update </p>
                      <input type="file" name="titer_report"  data-max_length="20" class="upload__inputfile">
                    </label>
                  </div>
                  <div class="upload__img-wrap"></div>
                </div>
            </div>
            </div>
             <div class="row ">
            <div class="col-md-6 mt-4">  
                <label>Passport Copy Disclaimer - (Bio Page) </label>
            </div>
            <div class="col-md-6">  
                <div class="upload__box">
                  <div class="upload__btn-box">
                    <label class="upload__btn">
                      <p>Click to Update </p>
                      <input type="file" name="passport_copy"  data-max_length="20" class="upload__inputfile">
                    </label>
                  </div>
                  <div class="upload__img-wrap"></div>
                </div>
            </div>
            </div>
                  <div class="row ">
            <div class="col-md-6 mt-4">  
                <label>CNIC Copy</label>
            </div>
            <div class="col-md-6">  
                <div class="upload__box">
                  <div class="upload__btn-box">
                    <label class="upload__btn">
                      <p>Click to Update </p>
                      <input type="file" name="cnic_copy"  data-max_length="20" class="upload__inputfile">
                    </label>
                  </div>
                  <div class="upload__img-wrap"></div>
                </div>
            </div>
            </div>
            <div class="row ">
            <div class="col-md-6 mt-4">  
                <label>Ticket Copy</label>
            </div>
            <div class="col-md-6">  
                <div class="upload__box">
                  <div class="upload__btn-box">
                    <label class="upload__btn">
                      <p>Click to Update </p>
                      <input type="file" name="ticket_copy"  data-max_length="20" class="upload__inputfile">
                    </label>
                  </div>
                  <div class="upload__img-wrap"></div>
                </div>
            </div>
            </div>
               <div class="row ">
            <div class="col-md-6 mt-4">  
                <label>Visa Copy</label>
            </div>
            <div class="col-md-6">  
                <div class="upload__box">
                  <div class="upload__btn-box">
                    <label class="upload__btn">
                      <p>Click to Update </p>
                      <input type="file" name="visa_copy"  data-max_length="20" class="upload__inputfile">
                    </label>
                  </div>
                  <div class="upload__img-wrap"></div>
                </div>
            </div>
            </div>
        <button type="submit" class="btn btn-success">Submit</button>
         
    </form>
    </div>
   

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Customer Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Name</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$shipment->ShipmentBy->name}}</a>
                        </div>
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Contact No</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$shipment->ShipmentBy->contact_no}}</a>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div> 
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Email</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$shipment->ShipmentBy->email}}</a>
                        </div>
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Date Of Birth</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$shipment->ShipmentBy->dob}}</a>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div> 
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Country</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$shipment->ShipmentBy->country}}</a>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div> 
                    <hr>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Shipment Detail</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <h6 class="fs-17 font-weight-600 mb-0">Pet Details</h6>
                    <br>
                    <div class="row">
                        @if(isset($shipment->ShipmentPet) && !empty($shipment->ShipmentPet))
                        @foreach($shipment->ShipmentPet as $ShipmentPet)

                        <div class="col-md-3 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Category</label>
                                <input type="text" class="form-control" disabled="" value="{{$ShipmentPet->Pets->category}}">
                            </div>
                        </div>
                        <div class="col-md-3 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Name</label>
                                <input type="text" class="form-control" disabled="" value="{{$ShipmentPet->Pets->name}}">
                            </div>
                        </div>
                        <div class="col-md-3 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Breed</label>
                                <input type="text" class="form-control" disabled="" value="{{$ShipmentPet->Pets->breed}}">
                            </div>
                        </div>
                        <div class="col-md-3 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Age</label>
                                <input type="text" class="form-control" disabled="" value="{{$ShipmentPet->Pets->age}}">
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <hr class="mt-2 mb-3"/>

                    <div class="row">
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Category</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->category}}">
                            </div>
                        </div>

                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Gross Weight (KG)</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->gross_weight}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Pet Dimensions</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->pet_dimensions}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Do you have a cage as per IATA standard</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->have_cage}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Cage Dimensions</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->cage_dimensions}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Want Booking</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->want_booking}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Shipper Name</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->shipper_name}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Shipper Address</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->shipper_address}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Shipper CNIC</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->shipper_cnic}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Shipper Contact</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->shipper_contact}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Shipper Email</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->shipper_email}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Consignee Name</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->consignee_name}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Consignee Address</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->consignee_address}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Consignee Contact</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->consignee_contact}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Consignee Email</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->consignee_email}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Consignee Email</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->consignee_email}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Microchip</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->microchip}}">
                            </div>
                        </div>
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label class="font-weight-600">Microchip No</label>
                                <input type="text" class="form-control" disabled="" value="{{$shipment->microchip_no}}">
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label text-dark-gray" for=""><b>Remarks History</b></label>
                            <div>
                                @if(isset($shipment->remarks) && $shipment->remarks != '')
                                {!!$shipment->remarks !!} 
                                @else
                                N/A
                                @endif
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
  function ImgUpload() {
          var imgWrap = "";
          var imgArray = [];

          $('.upload__inputfile').each(function () {
            $(this).on('change', function (e) {
              imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
              var maxLength = $(this).attr('data-max_length');

              var files = e.target.files;
              var filesArr = Array.prototype.slice.call(files);
              var iterator = 0;
              filesArr.forEach(function (f, index) {

                if (!f.type.match('image.*')) {
                  return;
                }

                if (imgArray.length > maxLength) {
                  return false
                } else {
                  var len = 0;
                  for (var i = 0; i < imgArray.length; i++) {
                    if (imgArray[i] !== undefined) {
                      len++;
                    }
                  }
                  if (len > maxLength) {
                    return false;
                  } else {
                    imgArray.push(f);

                    var reader = new FileReader();
                    reader.onload = function (e) {
                      var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                      imgWrap.append(html);
                      iterator++;
                    }
                    reader.readAsDataURL(f);
                  }
                }
              });
            });
          });

          $('body').on('click', ".upload__img-close", function (e) {
            var file = $(this).parent().data("file");
            for (var i = 0; i < imgArray.length; i++) {
              if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
              }
            }
            $(this).parent().parent().remove();
          });
      }  

      ImgUpload();
  // $(".img-zoom-m").ezPlus();
</script>
@endsection