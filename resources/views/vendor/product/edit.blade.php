@extends("vendor.template", ["pageTitle"=>$pageTitle])
@section('content')
<style type="text/css">
/* Style the Image Used to Trigger the Modal */
img {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

img:hover {opacity: 0.7;}

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
<br>
<div class="col-md-12">
  <div class="card mb-4">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="fs-17 font-weight-600 mb-0">Product Edit</h6>
        </div>
        <div class="text-right">

        </div>
      </div>
    </div>
    <div class="card-body">
      <form  method="POST" action="{{ route('vendor.updateProduct',['id'=> $product->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="row images">
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Product Name</label>
            <input type="text" name="product_name" class="form-control font-12 form-control-lg require" value="{{$product->product_name}}">     
          </div>

          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Product Category</label>
            <select name="category_id" id="category_id" class="form-control require select-one >
              <option value="">--select--</option>
              @foreach ($categories as $category)
              <option value="{{ $category->ProductCategory->id }}" @if($product->category_id == $category->ProductCategory->id) {{"selected"}} @endif>{{$category->ProductCategory->name}}</option>
              @endforeach
            </select>
            {!! $errors->first('code', '<p class="text-danger">:message</p>') !!} 

          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for=""> Brand</label>
            <input type="text" name="brand" class="form-control font-12 form-control-lg require" value="{{$product->brand}}">     
          </div>

          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for=""> Price</label>
            <input  name="price" type="number" step="0.01" class="form-control font-12 form-control-lg require" value="{{$product->price}}">     
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for=""> Quantity</label>
            <input type="number" step="0.01" name="quantity" class="form-control font-12 form-control-lg require" value="{{$product->quantity}}">     
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for=""> SKU</label>
            <input type="text" name="sku" class="form-control font-12 form-control-lg require" value="{{$product->sku}}">     
          </div>
            <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for=""> Colors</label>
            <input type="text" name="colors" class="form-control font-12 form-control-lg require" value="{{$product->colors}}"> 
          </div>

          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for=""> weight</label>
            <input  type="number" step="0.01" name="weight" class="form-control font-12 form-control-lg require" value="{{$product->weight}}"> 
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Image 1</label>
            <a class="float-right " href="{{$product->image1}}">Click to view </a>
            <input type="file" name="image1" accept="image/*" class="form-control font-12 form-control-lg Image 1" value="{{$product->image1}}">
            <i>Select an image if you want to update it.</i> 

          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Image 2</label>
            <a class="float-right " href="{{$product->image2}}">Click to view </a>
            <input type="file" name="image2" accept="image/*" class="form-control font-12 form-control-lg Image 1" value="{{$product->image2}}"> 
            <i>Select an image if you want to update it.</i>     
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Image 3</label>
            <a class="float-right " href="{{$product->image3}}">Click to view </a>
            <input type="file" name="image3" accept="image/*" class="form-control font-12 form-control-lg Image 1" value="{{$product->image3}}"> 
            <i>Select an image if you want to update it.</i>         
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Image 4</label>
            <a class="float-right " href="{{$product->image4}}">Click to view </a>
            <input type="file" name="image4" accept="image/*" class="form-control font-12 form-control-lg Image 1" value="{{$product->image4}}"> 
            <i>Select an image if you want to update it.</i>         
          </div>

          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Dimensions</label>
            <input type="text" name="dimensions" class="form-control font-12 form-control-lg require" value="{{$product->dimensions}}"> 
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Shipping Cost</label>
            <input type="number" step="0.01" name="shipping_cost" class="form-control font-12 form-control-lg require" value="{{$product->shipping_cost}}"> 
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Shipping Time Days</label>
            <input type="text" name="shipping_time_days" class="form-control font-12 form-control-lg require" value="{{$product->shipping_time_days}}"> 
          </div>


          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Key Features</label>
            <textarea class="form-control"  name="key_features"  >{{$product->key_features}}</textarea>
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Ingredients</label>
            <textarea class="form-control"  name="ingredients"  >{{$product->ingredients}}</textarea>
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Usage Instructions</label>
            <textarea class="form-control"  name="usage_instructions"  >{{$product->usage_instructions}}</textarea>
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Description</label>
            <textarea class="form-control"  name="description" id="summernotes" >{{$product->description}}</textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-success" id="save-button">Submit</button>
      </form>
    </div>
  </div>
</div>
<div id="image-viewer">
  <span class="close">&times;</span>
  <img class="modal-content" id="full-image">
</div>
@endsection
@section('footer-script')
<script>
  $(document).ready(function(){
    function required(){

      let validated       = true;
      var alertMessages       = "";
      var alertValidated      = false;

      $(".error-details").empty();

      $(".require").each(function(key, value){

        var value       = $(this).val();

        if(value == "" || value == null){

          $(this).addClass('has-error');
          validated   = false;
        }else{
          $(this).removeClass('has-error');   
        }
      });
      if(alertValidated){
        alert(alertMessages);
      }
      return validated;
    }
    $(document).on("click", "#save-button", function(event) {
      var validate = required();
      if (validate) {
        return true;
      }else{
        event.preventDefault();
      }
    });
  });
  $(".images a").click(function(e){
    e.preventDefault();
    $("#full-image").attr("src", $(this).attr("href"));
    $('#image-viewer').show();
  });

  $("#image-viewer .close").click(function(){
    $('#image-viewer').hide();
  });
</script>

@endsection

