@extends("vendor.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.dropdown-toggle::after {
  border: none !important;
}
</style>
<div class="body-content">
  {{-- <form action="" id="reportForm">
    <div class="row mb-4">
     <div class="col-md-3 mb-3">
       <div class="form-group">
        <label>Date From: </label>&nbsp;&nbsp;&nbsp;
        <div class="input-group date">
         <input type="text" name="date_from" class="form-control bg-light flatpickr" value="" required="" id="date_from">
         <div class="input-group-addon input-group-append">
           <div class="input-group-text">
             <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
           </div>
         </div>
       </div>
     </div>
   </div>

   <div class="col-md-3 mb-3">
     <div class="form-group">
      <label>Date To: </label>&nbsp;&nbsp;&nbsp;
      <div class="input-group date">
       <input type="text" name="date_to" class="form-control bg-light flatpickr" value="" required="" id="date_to">
       <div class="input-group-addon input-group-append">
         <div class="input-group-text">
           <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
         </div>
       </div>
     </div>
   </div>
 </div>
 <div class="col-md-3">
  <label>Brand</label>
  <select type="text" name="brand_id" id="brand_id" class="form-control select-one" value="" >
   <option value="">--select--</option>
   @foreach ($brands as $id=>$brand)
   <option value="{{ $brand->id }}">{{ $brand->name }}</option>
   @endforeach
 </select>
</div>
<div class="col-md-3 mb-3">
 <button class="btn btn-success" style="margin-top: 31px;width:150px;float:right" id="search-button">Search</button>
</div>
</div>
</form> --}}
<div class="row">
  <div class="col-lg-12">
   <div class="card mb-4">
    <div class="card-header">
     <div class="d-flex justify-content-between align-items-center">
      <div>
       <h6 class="fs-17 font-weight-600 mb-0">Orders List</h6>
     </div>
     <div class="text-right">
      {{-- <a class="" href="{{ route('vendor.addProduct') }}"><i class="far fa fa-plus"></i> Add Product</a> --}}
    </div>
    </div>
</div>
<div class="card-body">
    @include('alerts')
  <div class="table-responsive">
    <table class="table table-borderless">
     <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
    <tbody>
    </tbody>
  </table>
</div>
</div>
</div>
</div>
<div class="variant-template">

</div>
</div>
</div>
<template id="orderStatus">{{ json_encode($orderStatus) }} </template>

@endsection
@section('footer-script')
{{-- <script src="{{ asset('js/chosen.jquery.min.js') }}"></script> --}}
<script type="text/javascript">

  function confirmDeleteOperation() {
    if (confirm('Do you want to delete this?'))
      return true;
    else
      return false;
  }
  function getDateTime() {
    var now = new Date();
    var year = now.getFullYear();
    var month = now.getMonth() + 1;
    var day = now.getDate();
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    if (month.toString().length == 1) {
      month = '0' + month;
    }
    if (day.toString().length == 1) {
      day = '0' + day;
    }
    if (hour.toString().length == 1) {
      hour = '0' + hour;
    }
    if (minute.toString().length == 1) {
      minute = '0' + minute;
    }
    if (second.toString().length == 1) {
      second = '0' + second;
    }
    var dateTime = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
    return dateTime;
  }

  var table = $('table').DataTable({
    processing: false,
    serverSide: true,
    searching: false,
    stateSave: false,
    pagingType: "full_numbers",
    pageLength: 10,
      //order: [[ "2" , "DESC" ]],
      dom: 'Bfrtip',
      buttons: [
      // {
      //   extend: 'csvHtml5',
      //   text: '<i class="fa fa-file-text-o"></i>&nbsp; CSV',
      //   title: 'ClientsReport-' + getDateTime(),
      //   action: newexportaction
      // },
      // {
      //   extend: 'excelHtml5',
      //   text: '<i class="fa fa-file-excel-o"></i>&nbsp; Excel',
      //   title: 'ClientsReport-' + getDateTime(),
      //   action: newexportaction,
      //   exportOptions: {
      //     modifier: {
      //       // DataTables core
      //       order: 'index',  // 'current', 'applied', 'index',  'original'
      //       page: 'all',      // 'all',    'current'
      //       search: 'applied'     // 'none',    'applied', 'removed'
      //     }
      //   }
      // }
      ],
      ajax: {
        'url': '{!! route('vendor.orders') !!}',
        'data': function (d) {
          d.date_from = $("input[name='date_from']").val();
          d.date_to = $("input[name='date_to']").val();
          d.brand_id = $("select[name='brand_id']").val();
          return d;
        }
      },

   

     columns: [
                    {data: 'id', name: 'id'},
                    {data: 'customer.name', name: 'customer.name'},
                    {data: 'total_amount', name: 'total_amount'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
      columnDefs: [ {
        'orderable': false, /* true or false */
      }]
    });
  function newexportaction(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
  // Just this once, load all data from the server...
  data.start = 0;
  data.length = 2147483647;
  dt.one('preDraw', function (e, settings) {
      // Call the original action function
      if (button[0].className.indexOf('buttons-copy') >= 0) {
        $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
      } else if (button[0].className.indexOf('buttons-excel') >= 0) {

        $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
        $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
        $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
      } else if (button[0].className.indexOf('buttons-csv') >= 0) {

        $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
        $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
        $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
      } else if (button[0].className.indexOf('buttons-pdf') >= 0) {

        $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
        $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
      } else if (button[0].className.indexOf('buttons-print') >= 0) {

        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
      }
      dt.one('preXhr', function (e, s, data) {
        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
        // Set the property to what it was before exporting.
        settings._iDisplayStart = oldStart;
        data.start = oldStart;
      });
    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
    setTimeout(dt.ajax.reload, 0);
    // Prevent rendering of the full data to the DOM
    return false;
  });
}


);
  // Requery the server with the new one-time export settings
  dt.ajax.reload();
};

table.ajax.reload();

$("#search-button").click(function (e) {
  e.preventDefault();
  table.ajax.reload();

});
  function confirmDeleteOperation() {
    if (confirm('Do you want to delete this?'))
      return true;
    else
      return false;
  }
  $(document).on('click', '.delete-product', function(e){
  e.preventDefault();
  
  if(confirmDeleteOperation()){
    var product_id        = $(this).data('prduct_id');
    console.log(product_id);
    if(product_id != ""){
      $.ajax({
        url: '{{ route("vendor.delectProduct") }}',
        type: "GET",
        data: {
          product_id: product_id
        },
        success: function(data) {
          alert("Product Deleted Successfully!")
          if (data == 1) {}
             table.ajax.reload();
        }
      });
    }
  }

});
  $(document).on("click", ".btn-change-orderStatus", function(event){
  event.preventDefault();
  var statuses      = $('#orderStatus').html();
  var statuses_arr    = JSON.parse(statuses);
        // console.log(statuses_arr);
        var status        = $(this).attr("data-status");
        var id          = $(this).attr("data-id");
        $.confirm({
          title : "Change Order Status",
          content:function(){
            var html = "";
            $.each(statuses_arr, function(index, value){
              console.log(value);
              if(value==status){
                html+="<label><input type='radio' name='status' value='"+value+"' checked> "+ value.charAt(0).toUpperCase() + value.slice(1)  +"</label><br>";
              }else{
                html+="<label><input type='radio' name='status' value='"+value+"'> "+value.charAt(0).toUpperCase() + value.slice(1) +"</label><br>";
              }
            });

            return html;
          },
          buttons:{
            ok:{
              text:"Save",
              btnClass:"btn btn-success confirmed",
              action:function(){
                var v = this.$content.find("input[type='radio']:checked").val();
                let url = "{{ route('vendor.order.status.update') }}";
                save_status(v, id,url);
                alert('Order Status has been updated successfully!');
            // window.location.reload();
            table.ajax.reload();
          }
        },
        no:{
          text:"Cancel"
        }
      }
    });
        return false;
      }); 

function save_status(status, id,url){

  $.ajax({
    url: url, 
    type: "GET",
    data: {
      status: status,
      id: id
    },
    success: function(data) {

      data = JSON.parse(data);

      console.log(data.status);
      if(data.status == true){
        console.log(data.message);
        return data.message;
      }
    }
  });
}
</script>
@endsection

