@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
  .dropdown-toggle::after {
      border: none !important;
  }
</style>
<div class="body-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Clients List</h6>
						</div>
            @can('clients-create')
            <div class="text-right">
              <a class="" href="{{ route('admin.clients.create') }}"><i class="far fa fa-plus"></i> Add Client</a>
            </div>
            @endcan
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
					<div class="table-responsive">
						<table class="table table-borderless">
							<thead>
								<tr>
                  <th width="50px">Sr.</th>
                  <th width="400px">Company Name</th>
                  <th width="400px">Company Office Phone Number</th>
                  <th width="400px">Company Website</th>
                  <th width="400px">Charge Tax</th>
                  <th width="400px">Resale Number</th>
                  <th width="400px">Action</th>
								</tr>
							</thead>
							<tbody>
									
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('footer-script')
<script src="{{ asset('js/chosen.jquery.min.js') }}"></script>
<script type="text/javascript">

  function confirmDeleteOperation() {
    if (confirm('Are you sure you want to delete this user?'))
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
          'url': '{!! route('admin.clients.ajax_data') !!}',
          'data': function (d) {
              d.date_from = $("input[name='date_from']").val();
              d.date_to = $("input[name='date_to']").val();
              d.brand_id = $("select[name='brand_id']").val();
              return d;
          }
      },
      columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},
      {data: 'company_name', name: 'company_name', orderable: false},
      {data: 'office_phone_number', name: 'office_phone_number', orderable: false},
      {data: 'website', name: 'website', orderable: false},
      {data: 'tax', name: 'tax', orderable: false},
      {data: 'resale_number', name: 'resale_number', orderable: false},
      {data: 'actions', name: 'actions', orderable: false}
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
  
</script>
@endsection

