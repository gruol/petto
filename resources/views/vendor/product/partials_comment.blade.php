@foreach ($comments as $comment)
{{-- {{dd( $comment)}} --}}
    <div>
        {{-- <strong>{{ $comment->customer->name }}</strong>: {{ $comment->content }} --}}
        <strong>{{Auth::guard('vendor')->user()->vendor_name}}</strong>: {{ $comment->body }}
        <br>
        <small>{{ $comment->created_at->diffForHumans() }}</small>

        {{-- Recursive call to display nested replies --}}
        @if($comment->replies->count())
            <div style="margin-left: 20px; margin-top: 10px;">
                @include('vendor.comments.partials._comment', ['comments' => $comment->replies])
            </div>
        @endif
    </div>
@endforeach


