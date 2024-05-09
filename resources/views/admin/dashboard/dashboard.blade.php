@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet"> --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style>
  .dropdown-toggle::after {
    border: none !important;
  }
  .counter {
    background-color:#f5f5f5;
    padding: 20px 0;
    border-radius: 5px;
  }

  .count-title {
    font-size: 40px;
    font-weight: normal;
    margin-top: 10px;
    margin-bottom: 0;
    text-align: center;
  }

  .count-text {
    font-size: 13px;
    font-weight: normal;
    margin-top: 10px;
    margin-bottom: 0;
    text-align: center;
  }

  .fa-2x {
    margin: 0 auto;
    float: none;
    display: table;
    color: #825049;
  }
</style>
<div class="body-content">
 {{--  <form action="" id="reportForm">
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
   <!-- The Modal -->
   <div class="modal" id="send-email-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header" style="background-color:#41a942">
          <h6 class="modal-title text-white">Send Email</h6>
          <button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
          <form  method="POST" id="sendEmail"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_number" id="order_number" value="">
            <input type="hidden" name="clientId" id="clientId" value="">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label text-dark-gray" for="email">Sent to Email</label>
                <input type="email" id="clientEmail" name="email" class="form-control font-12 form-control-lg" value="">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-dark-gray" for="subject">Subject</label>
                <input type="text" name="subject" class="form-control font-12 form-control-lg require" value="">

              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-dark-gray" for="subject">Attachment</label>
                <input type="file" name="attachment" id="attachment" class="form-control font-12 form-control-lg require" value="">

              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-dark-gray" for="description">Message</label>
                <textarea name="description"  class="form-control font-12 form-control-lg require" ></textarea>
              </div>
            </div>


            <button type="submit" class="btn btn-success" id="save-button">Submit</button>
          </form>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button class="btn btn-default close-modal" type="button">close</button>
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
{{--  <div class="col-md-3">
  <label>Brand</label>
  <select type="text" name="brand_id" id="brand_id" class="form-control select-one" value="" >
   <option value="">--select--</option>
   @foreach ($brands as $id=>$brand)
   <option value="{{ $brand->id }}">{{ $brand->name }}</option>
   @endforeach
 </select>
</div> --}}
{{-- <div class="col-md-3 mb-3">
 <button class="btn btn-success" style="margin-top: 31px;width:150px;float:right" id="search-button">Search</button>
</div>
</div>
</form>  --}}
<div class="row">
  <div class="col-lg-12">
   <div class="card mb-4">
    <div class="card-header">
     <div class="d-flex justify-content-between align-items-center">
      <div>
        <h6 class="fs-17 font-weight-600 mb-0">Dashboard</h6>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="col-md-12">
      @if (Session::has('success'))
      <div class="alert alert-success">
        {{ Session::get('success') }}
      </div>
      @endif
    </div>
    <div class="container">
      <div class="row">
        <br/>
        <div class="col text-center">
          <h2> Registered Pets</h2><br>
          {{-- <p>counter to count up to a target number</p> --}}
        </div>
      </div>
      <div class="row text-center">
        <div class="col">
          <div class="counter">
            <i class="fa fa-paw fa-2x"></i>
            <h2 class="timer count-title count-number" data-to="100" data-speed="1500"></h2>
            <p class="count-text ">Total Pets Registered</p>
            <h1>{{$registeredPets['totaRegisteredPets']}}</h1>

          </div>
        </div>
        <div class="col">
         <div class="counter">
          <i class="fas fa-dog fa-2x"></i>
          <h2 class="timer count-title count-number" data-to="1700" data-speed="1500"></h2>
          <p class="count-text ">Dogs</p>
          <h1>{{$registeredPets['DogCount']}}</h1>
        </div>
      </div>
      <div class="col">
        <div class="counter">
          <i class="fas fa-cat fa-2x"></i>
          <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
          <p class="count-text ">Cats</p>
          <h1>{{$registeredPets['CatCount']}}</h1>
        </div></div>
        <div class="col">
          <div class="counter">
            <i class="fas fa-feather-alt fa-2x"></i>
            <h2 class="timer count-title count-number" data-to="157" data-speed="1500"></h2>
            <p class="count-text ">Birds</p>
            <h1>{{$registeredPets['BirdCount']}}</h1>
          </div>
        </div>
      </div>
      <br>
       <div class="row">
        <br/>
        <div class="col text-center">
          <h2> Pet Shipment</h2><br>
          {{-- <p>counter to count up to a target number</p> --}}
        </div>
      </div>
      <div class="row text-center">
        <div class="col">
          <div class="counter">
            {{-- <i class="fa fa-paw fa-2x"></i> --}}
            <img width="10%" height="10%" src="{{asset('assets/images/question_1_-removebg-preview.png')}}">
            <h2 class="timer count-title count-number" data-to="100" data-speed="1500"></h2>
            <p class="count-text ">Inquiry Pending</p>
            <h1>{{$registeredPets['totaRegisteredPets']}}</h1>

          </div>
        </div>
        <div class="col">
         <div class="counter">
          {{-- <i class="fas fa-dog fa-2x"></i> --}}
            <img width="10%" height="10%" src="{{asset('assets/images/paper-removebg-preview.png')}}">

          <h2 class="timer count-title count-number" data-to="1700" data-speed="1500"></h2>
          <p class="count-text ">Inquiry Responded</p>
          <h1>{{$registeredPets['DogCount']}}</h1>
        </div>
      </div>
      <div class="col">
        <div class="counter">
          {{-- <i class="fas fa-cat fa-2x"></i> --}}

            <img width="10%" height="10%" src="{{asset('assets/images/plane-removebg-preview.png')}}">
          <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
          <p class="count-text ">Shipment Confirmed</p>
          <h1>{{$registeredPets['CatCount']}}</h1>
        </div></div>
        <div class="col">
          <div class="counter">
            {{-- <i class="fas fa-feather-alt fa-2x"></i> --}}
            <img width="10%" height="10%" src="{{asset('assets/images/delivered-removebg-preview.png')}}">
            <h2 class="timer count-title count-number" data-to="157" data-speed="1500"></h2>
            <p class="count-text ">Shipment Delivered</p>
            <h1>{{$registeredPets['BirdCount']}}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
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
      {
        extend: 'csvHtml5',
        text: '<i class="fa fa-file-text-o"></i>&nbsp; CSV',
        title: 'ClientsReport-' + getDateTime(),
        action: newexportaction
      },
      {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o"></i>&nbsp; Excel',
        title: 'ClientsReport-' + getDateTime(),
        action: newexportaction,
        exportOptions: {
          modifier: {
            // DataTables core
            order: 'index',  // 'current', 'applied', 'index',  'original'
            page: 'all',      // 'all',    'current'
            search: 'applied'     // 'none',    'applied', 'removed'
          }
        }
      }
      ],
      ajax: {
        'url': '{!! route('admin.shipment.ajax_data') !!}',
        'data': function (d) {
          d.date_from = $("input[name='date_from']").val();
          d.date_to = $("input[name='date_to']").val();
          d.brand_id = $("select[name='brand_id']").val();
          return d;
        }
      },
      columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},

      {data: 'date', name: 'date'},
      {data: 'customer_name', name: 'customer_name'},
      {data: 'category', name: 'category'},
      {data: 'book_shipment', name: 'book_shipment'},
      {data: 'query_status', name: 'query_status'},
      {data: 'payment_status', name: 'payment_status'},
      {data: 'origin', name: 'origin'},
      {data: 'destination', name: 'destination'},

      {data: 'actions', name: 'actions'}
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
</script>
@endsection

