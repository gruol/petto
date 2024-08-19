@extends("vendor.template", ["pageTitle"=>$pageTitle])
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
                            <h6 class="fs-17 font-weight-600 mb-0">Order Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600"> Name</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->name}}</a>
                        </div>
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600"> Contact No</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->contact_number}}</a>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div> 
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">email </h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->email}}</a>
                        </div>
                        <div class="col">  
                            <h6 class="mb-0 font-weight-600">Order Date</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->order_date}}</a>
                        </div>
                        
                    </div>
                    <hr>
                    <div class="row align-items-center">
                      <div class="col">  
                        <h6 class="mb-0 font-weight-600">Is Confirmed by Customer</h6>
                        <a href="#!" class="fs-13 font-weight-600 px-4">{{($order->is_confirmed_by_customer == 1 ? 'Yes' : 'No')}}</a>
                    </div>
                    <div class="col">  
                        <h6 class="mb-0 font-weight-600">Status </h6>
                        <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->status}}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                  <div class="col">  
                    <h6 class="mb-0 font-weight-600">Total Amount</h6>
                    <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->total_amount}}</a>
                </div>
                <div class="col">  
                    <h6 class="mb-0 font-weight-600">City</h6>
                    <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->city}}</a>
                </div>
            </div>
            <hr>
            <div class="row align-items-center">
              <div class="col">  
                <h6 class="mb-0 font-weight-600">Province</h6>
                <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->province}}</a>
            </div>
            <div class="col">  
                <h6 class="mb-0 font-weight-600">Country</h6>
                <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->country}}</a>
            </div>
        </div>
    </div> 
    <hr>
    <div class="row align-items-center">
      <div class="col">  
        <h6 class="mb-0 font-weight-600">Shipping Address</h6>
        <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->shipping_address}}</a>
    </div>
</div>
<hr>
<div class="row align-items-center">
  <div class="col">  
    <h6 class="mb-0 font-weight-600">Billing Address</h6>
    <a href="#!" class="fs-13 font-weight-600 px-4">{{$order->billing_address}}</a>
</div>
</div>
<br>
</div> 
</div>
<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Order Products Details</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
           @if(isset($order->items) &&  !$order->items->isEmpty())
           @foreach($order->items as $i => $item)
           <div>
            <b>{{$i+1}} ) </b> 
            <br>
        </div>
        <br>
        <div class="row">
           <div class="col-md-3 pr-md-1">
            <div class="form-group">
                <label class="font-weight-600">Product Name</label>
                <input type="text" class="form-control" disabled="" value="{{$item->orderProduct->product_name}}">
            </div>
        </div>
        <div class="col-md-3 pr-md-1">
            <div class="form-group">
                <label class="font-weight-600">Price</label>
                <input type="text" class="form-control" disabled="" value="{{$item->price}}">
            </div>
        </div>
        <div class="col-md-3 pr-md-1">
            <div class="form-group">
                <label class="font-weight-600">Quantity</label>
                <input type="text" class="form-control" disabled="" value="{{$item->quantity}}">
            </div>
        </div>
        <div class="col-md-3 pr-md-1">
            <div class="form-group">
                <label class="font-weight-600">Total</label>
                <input type="text" class="form-control" disabled="" value="{{$item->total}}">
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
                let url = "{{ route('admin.doctor.status.update') }}";
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