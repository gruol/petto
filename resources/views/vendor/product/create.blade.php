@extends("vendor.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.has-error{
  border: 1px solid red;
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
<br>
<div class="col-md-12">
  <div class="card mb-4">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="fs-17 font-weight-600 mb-0">Product Add</h6>
        </div>
        <div class="text-right">

        </div>
      </div>
    </div>
    <div class="card-body">
      <form  method="POST" action="{{ route('vendor.saveProduct') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Product Name</label>
            <input type="text" name="product_name" class="form-control font-12 form-control-lg require" value="{{old('product_name')}}">     
          </div>

          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for="">Product Category</label>
            <select name="category_id" id="category_id" class="form-control require select-one >
              <option value="">--select--</option>
              @foreach ($categories as $category)
              <option value="{{ $category->ProductCategory->id }}">{{$category->ProductCategory->name}}</option>
              @endforeach
            </select>
            {!! $errors->first('code', '<p class="text-danger">:message</p>') !!} 

          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label text-dark-gray" for=""> Brand</label>
            <input type="text" name="brand" class="form-control font-12 form-control-lg require" value="{{old('brand')}}">     
          </div>
         
         <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for=""> Price</label>
          <input  name="price" type="number" step="0.01" class="form-control font-12 form-control-lg require" value="{{old('price')}}">     
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for=""> Quantity</label>
          <input type="number" step="0.01" name="quantity" class="form-control font-12 form-control-lg require" value="{{old('quantity')}}">     
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for=""> SKU</label>
          <input type="text" name="sku" class="form-control font-12 form-control-lg require" value="{{old('sku')}}">     
        </div>
           <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for=""> Colors</label>
          <input type="text" name="colors" class="form-control font-12 form-control-lg require" value="{{old('colors')}}"> 
        </div>

        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for=""> weight</label>
          <input  type="number" step="0.01" name="weight" class="form-control font-12 form-control-lg require" value="{{old('weight')}}"> 
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Image 1</label>
          <input type="file" name="image1" accept="image/*" class="form-control font-12 form-control-lg require" value="{{old('image1')}}">     
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Image 2</label>
          <input type="file" name="image2" accept="image/*" class="form-control font-12 form-control-lg require" value="{{old('image2')}}">     
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Image 3</label>
          <input type="file" name="image3" accept="image/*" class="form-control font-12 form-control-lg require" value="{{old('image3')}}">     
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Image 4</label>
          <input type="file" name="image4" accept="image/*" class="form-control font-12 form-control-lg require" value="{{old('image4')}}">     
        </div>
     
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Dimensions</label>
          <input type="text" name="dimensions" class="form-control font-12 form-control-lg require" value="{{old('dimensions')}}"> 
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Shipping Cost</label>
          <input type="number" step="0.01" name="shipping_cost" class="form-control font-12 form-control-lg require" value="{{old('shipping_cost')}}"> 
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Shipping Time Days</label>
          <input type="text" name="shipping_time_days" class="form-control font-12 form-control-lg require" value="{{old('shipping_time_days')}}"> 
        </div>

       
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Key Features</label>
          <textarea class="form-control"  name="key_features"  ></textarea>
        </div>
         <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Ingredients</label>
          <textarea class="form-control"  name="ingredients"  ></textarea>
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Usage Instructions</label>
          <textarea class="form-control"  name="usage_instructions"  ></textarea>
        </div>
         <div class="col-md-3 mb-3">
          <label class="form-label text-dark-gray" for="">Description</label>
          <textarea class="form-control"  name="description" id="summernotes" ></textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-success" id="save-button">Submit</button>
    </form>
  </div>
</div>
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
</script>

@endsection

