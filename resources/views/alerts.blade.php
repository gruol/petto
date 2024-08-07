{{-- <div class="card-body" style="padding:0 !important;">
    <div class="form-group"> --}}
        @if (Session::has('info'))
        <div class="clearfix"></div>
        <div class="alert alert-info" role="alert">
            <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
            {!! Session::get('info') !!}
        </div>
        @endif

        @if (Session::has('success'))
        <div class="clearfix"></div>
        <div class="alert alert-success" role="alert">
            <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
            {!! Session::get('success') !!}
        </div>
        @endif
         @if (Session::has('message'))
        <div class="clearfix"></div>
        <div class="alert alert-success" role="alert">
            <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
            {!! Session::get('message') !!}
        </div>
        @endif
        @if (Session::has('warning'))
        <div class="clearfix"></div>
        <div class="alert alert-warning" role="alert">
            <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
            {!! Session::get('warning') !!}
        </div>
        @endif

        @if (Session::has('error'))
        <div class="clearfix"></div>
        <div class="alert alert-danger" role="alert">
            <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
            {!! Session::get('error') !!}
        </div>
        @endif

        @if($errors->count() > 0)
            <div class="clearfix"></div>
            <div class="alert alert-danger" id="errors" role="alert" style="display: none;">
                <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="alert_message_margins">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    {{-- </div>
</div> --}}


<script>
    $(document).ready(function(){
    $('#errors').show('slow');
    });
</script>