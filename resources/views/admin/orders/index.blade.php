@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.dropdown-toggle::after {
	border: none !important;
}

</style>
<div class="body-content">
	<form action="" id="reportForm">
		<div class="row mb-4">
			<div class="col-md-2 mb-3" style="margin-right: 10px;">
				<div class="form-group">
					<label>Client: </label>&nbsp;&nbsp;&nbsp;
					<select type="text" name="client_id" id="client_id" class="form-control select-one" value="" >
						<option value="">--select--</option>
						@foreach ($clients as $client)
						<option value="{{ $client->id }}">{{ $client->company_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
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
			<div class="col-md-2">
				<label>Status</label>
				<select type="text" name="status_id" id="order_type" class="form-control require required-online" value="" >
					<option value="">--select--</option>
					@foreach ($statuses_arr as $id=>$status)
					@php
					$status  	= json_decode($status, true);
					@endphp
					<option value="{{ $status['id'] }}">{{ $status['name'] }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-12 mb-3">
				<button class="btn btn-success" style="margin-top: 31px;width:150px;float:right" id="search-button">Search</button>
			</div>
		</div>
	</form>
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
	<div class="row">
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Orders List</h6>
						</div>
						@can('order-create')
						<div class="text-right">
							<a class="" href="{{ route('admin.order.create') }}"><i class="far fa fa-plus"></i> Add Order</a>
						</div>
						@endcan
					</div>
				</div>
				<div class="card-body">
					@if (Session::has('resp'))
					@php
					$resp = session()->get("resp");
					$msg = session()->get("msg");
					@endphp
					<div class="col-md-12">
						@if ($resp=="success")
						<div class="alert alert-success">
							{!!$msg!!}
						</div>
						@endif
					</div>
					@endif
					@if(Session::has('success'))
					<div class="alert alert-success" role="alert">
						{{ Session::get('success') }}
					</div>
					@endif
					<div class="table-responsive">
						<table class="table table-borderless">
							<thead>
								<tr>
									<th width="250px">Sr.</th>
									<th width="250px">PO #</th>
									<th width="250px">Assignee</th>
									<th width="250px">Job Name</th>
									<th width="250px">Company Name</th>
									<th width="250px">Quantity of Pieces</th>
									<th width="250px">Due Date</th>
									<th width="250px">Event</th>
									<th width="250px">Status</th>
									<th width="250px">Quote Approval</th>
									<th width="250px">Blank</th>
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
		<template>
			{{ json_encode($statuses_arr) }}
		</template>
             <template id="quote_approval">{{json_encode($quote_approval_arr)}}</template>
             <template id="blank">{{json_encode($blank_arr)}}</template>

		<div class="job-template">

		</div>
	</div>
</div>
@endsection
@section('footer-script')
<script type="text/javascript">
	// $('select').select2();
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
			extend: 'colvis'
		}
		],
		ajax: {
			'url': '{!! route('admin.orders.ajaxdata') !!}',
			'data': function (d) {
				d.client_id = $("select[name='client_id']").val();
				d.date_from = $("input[name='date_from']").val();
				d.date_to = $("input[name='date_to']").val();
				d.status_id = $("select[name='status_id']").val();
				return d;
			}
		},
		columns: [
		{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},
		{data: 'order_number', name: 'order_number', width:"250px"},
		{data: 'created_by_name', name: 'created_by_name', width:"250px"},
		{data: 'job_name', name: 'job_name', width:"250px"},
		{data: 'company_name', name: 'company_name', width:"250px"},
		{data: 'projected_units', name: 'projected_units', width:"250px"},
		{data: 'due_date', name: 'due_date', width:"250px"},
		{data: 'event', name: 'event', width:"250px"},
		{data: 'status', name: 'status', width:"250px"},
		{data: 'quote_approval', name: 'quote_approval', width:"250px"},
		{data: 'blank', name: 'blank', width:"250px"},
		{data: 'actions', name: 'actions'}
		]
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


	// $("#tarcking_status").select2();
	$(document).on('click', '._deld', function(){
		var f = window.confirm("Do you want to delete record?");
		if(f){
			window.location = $(this).attr("href");
		}
		return false;
	});
	$(document).on("click", ".btn-change-status", function(event){
		event.preventDefault();
		var statuses 			= $('template').html();
		var statuses_arr		= JSON.parse(statuses);
				console.log(statuses_arr);
		var status 				= $(this).attr("data-status");
		var id 					= $(this).attr("data-id");
		
		$.confirm({
			title : "Change Status",
			content:function(){
				var html = "";
				$.each(statuses_arr, function(index, value){
					console.log(value);
					if(value.id==status){
						html+="<label><input type='radio' name='status' value='"+value.id+"' checked> "+value.name+"</label><br>";
					}else{
						html+="<label><input type='radio' name='status' value='"+value.id+"'> "+value.name+"</label><br>";
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
						let url = "{{ route('admin.order.status_update') }}";
						save_status(v, id,url);
						alert('Status has been updated successfully!');
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
		$(document).on("click", ".btn-change-quote_approval", function(event){
		event.preventDefault();
	
		 let quote_approval_arr       = JSON.parse($("#quote_approval").html());
		 console.log(quote_approval_arr);
		var status 				= $(this).attr("data-quote_approval");
		var id 					= $(this).attr("data-id");
		
		$.confirm({
			title : "Change Status",
			content:function(){
				var html = "";
				// console.log(statuses_arr);
				$.each(quote_approval_arr, function(index, value){
					console.log(value);
					if(value.id==status){
						html+="<label><input type='radio' name='status' value='"+value.id+"' checked> "+value.name+"</label><br>";
					}else{
						html+="<label><input type='radio' name='status' value='"+value.id+"'> "+value.name+"</label><br>";
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
						let url = "{{ route('admin.order.quote_update') }}";
						save_status(v, id,url);
						alert('Quote has been updated successfully!');
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
	$(document).on("click", ".btn-change-blank", function(event){
		event.preventDefault();
	
		 let blank_arr       = JSON.parse($("#blank").html());
		 console.log(blank_arr);
		var status 				= $(this).attr("data-blank");
		var id 					= $(this).attr("data-id");
		
		$.confirm({
			title : "Change Status",
			content:function(){
				var html = "";
				// console.log(statuses_arr);
				$.each(blank_arr, function(index, value){
					console.log(value);
					if(value.id==status){
						html+="<label><input type='radio' name='status' value='"+value.id+"' checked> "+value.name+"</label><br>";
					}else{
						html+="<label><input type='radio' name='status' value='"+value.id+"'> "+value.name+"</label><br>";
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
						let url = "{{ route('admin.order.blank_update') }}";
						save_status(v, id,url);
						alert('Blank has been updated successfully!');
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
	function save_status(status_id, order_id,url){

		$.ajax({
			url: url, 
			type: "GET",
			data: {
				status_id: status_id,
				order_id: order_id
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

	$(document).on('click', '.close-modal', function(e){
		$('#job-modal').hide();
	});

	$("form#formElement").submit(function(){
		var formData = new FormData($(this)[0]);
	});
	$(document).on('click', '#save-form', function(e){
		var messages 	= "";
		
		var oneDay = 24 * 60 * 60 * 1000;
		$('.enddate').each(function(index, value){
			var endDate 	= new Date($(this).val());
			var startDate 	= new Date($(this).closest('.row').find('.startdate').val());
			
			var diffDays =(endDate.getTime() - startDate.getTime()) / (oneDay);
			var exct_diff = Math.ceil(diffDays);

			if (exct_diff < 0){
				var row = index++;
				messages 	+="Completion date must be smaller than Start Date at Row "+index+"\n";
			}
		});
		alert(messages);
		return false;
		if(messages == ""){
			$.ajax({
				{{-- url: "{{ route('admin.job.assign_job') }}", --}}
				type: "GET",
				data: $('#job-form').serialize(),
				success: function(data) {
					data = JSON.parse(data);
					if(data.status == true){
						alert(data.message);
					}
					window.location.reload();
				}
			});
		}else{
			alert(messages);
			return false;
		}
		
		
	});
	$(document).on('click', '.get-job-popup', function(e){

		e.preventDefault();
		$('.job-template').empty();
		var order_id 				= $(this).attr('data-order-id');
		$.ajax({
			{{-- url: '{{ route("admin.order.job_template") }}', --}}
			type: "GET",
			data: {
				order_id: order_id
			},
			success: function(data) {
				
				$('.job-template').html(data);
				$('.select-tailor').select2();
				$('#job-modal').show();

				$('.flatpickr-jobs').flatpickr({
					enableTime: true,
					minDate: 'today',
					dateFormat: "m-d-Y H:i",
				});
			}
		});
	});
	$("#search-button").click(function (e) {
		e.preventDefault();
		table.ajax.reload();

	});
	$(document).on('click', '.send-email-modal', function(e){
		e.preventDefault();
		var order_id 		  = $(this).attr('data-id');
		var client_id 		  = $(this).attr('data-client_id');
		var email 		  = $(this).attr('data-email');

		$('#order_number').val(order_id);
		$('#clientId').val(client_id);
		$('#clientEmail').val(email);

	});
	 
	$(document).ready(function (e) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$('#sendEmail').submit(function(e) {
			e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type:'POST',
				url: "{{ route('admin.sendEmail')}}",
				data: formData,
				cache:false,
				contentType: false,
				processData: false,
				success: (data) => {
					$('#send-email-modal').modal('hide');
					$('#sendEmail').trigger('reset');
					console.log(data);
					$.confirm({
						title : "Alert",
						content:function(){

							return data;
						},
						buttons:{
							ok:{
								text:"Ok",
								btnClass:"btn btn-success confirmed"
							}

						}
					});
				},
				error: function(data){
					console.log(data);
				}
			});
		});
	});
</script>
@endsection