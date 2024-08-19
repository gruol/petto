@extends("vendor.template", ["pageTitle"=>$pageTitle])
@section('content')
<style type="text/css" media="screen">
/*/////////////////////////////////*/
/*/////////  chat styles  /////////*/
/*/////////////////////////////////*/
.chat
{
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li
{
    margin-bottom: 40px;
    padding-bottom: 5px;
    /* border-bottom: 1px dotted #B3A9A9; */
    margin-top: 10px;
    width: 80%;
}


.chat li .chat-body p
{
    margin: 0;
    /* color: #777777; */
}


.chat-care
{
    overflow-y: scroll;
    height: 350px;
}
.chat-care .chat-img
{
    width: 50px;
    height: 50px;
}
.chat-care .img-circle
{
    border-radius: 50%;
}
.chat-care .chat-img
{
    display: inline-block;
}
.chat-care .chat-body
{
    display: inline-block;
    max-width: 80%;
    background-color: #FFC195;
    border-radius: 12.5px;
    padding: 15px;
}
.chat-care .chat-body strong
{
  color: #0169DA;
}

.chat-care .admin
{
    text-align: right ;
    float: right;
}
.chat-care .admin p
{
    text-align: left ;
}
.chat-care .agent
{
    text-align: left ;
    float: left;
}
.chat-care .left
{
    float: left;
}
.chat-care .right
{
    float: right;
}

.clearfix {
  clear: both;
}




::-webkit-scrollbar-track
{
    box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}
</style>
<div class="body-content">
    @include('alerts')
    <div class="container">
        <h1>Product Name: {{ $product->product_name }}</h1>
        <p><strong>Description:</strong>{{ $product->description }}</p>
        <p><strong>Price:</strong> {{ $product->price }}</p>

        <hr>

        <h3>Comments & Replies</h3>

        @forelse ($product->comments as $comment)
        {{-- {{dd($comment)}} --}}
        <div style=" margin-top: 10px;background-color: #edbfac;border-radius: 12.5px;padding: 15px;">
            <strong>{{ $comment->customer->name }}</strong>: {{ $comment->body }}
            <br>
            <small>{{ $comment->created_at->diffForHumans() }}</small>

            {{-- Display Replies --}}
            @if($comment->replies->count())
            <div style="float: right;display: inline-block;max-width: 80%;background-color: #edbfac;border-radius: 12.5px;padding: 15px;">
                @include('vendor.product.partials_comment', ['comments' => $comment->replies])
            </div>
            @endif

            {{-- Reply Form --}}
            <form action="{{ route('vendor.comments.reply', $comment->id) }}" method="POST" style="margin-top: 10px;">
                @csrf
                <input type="text" name="body" class="form-control" placeholder="Write a reply..." required>
                <button type="submit" class="btn btn-success btn-sm" style="margin-top: 5px;">Reply</button>
            </form>
        </div>
        @empty
        <p>No comments yet. Be the first to comment!</p>
        @endforelse

        {{-- Comment Form --}}
      {{--   <form action="{{ route('vendor.comments.store') }}" method="POST" style="margin-top: 10px">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="text" name="content" class="form-control" placeholder="Write a comment..." required>
            <button type="submit" class="btn btn-success" style="margin-top: 10px;">Comment</button>
        </form> --}}
    </div>
</div>
@endsection
@section('footer-script')
<script>
    $(".img-zoom-m").ezPlus();
</script>
@endsection