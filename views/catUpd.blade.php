@extends("layout")

@section("content")

    <form class="ins-form" action='./catUpdExe' method='post'>

    <input type='hidden' name='id' value="{{$row['id']}}">

    <label for="ins-title">title:</label>
    <input type="text" class="inputText form-control" name="title" id="ins-title" value="{{$row['title']}}">

    <label for="ins-sort">sort:</label>
    <input type="text" class="inputText form-control" name="sort" id="ins-sort" value="{{$row['sort']}}">

    <input class="btn btn-light mt-2" type='submit' value='send'>

    </form>

<div class="my-3">
    <a  class="d-inline text-decoration-none px-2 py-1 rounded data-item-a border border-primary" href='../catDel/"{{$row['id']}}"'>delete</a>
</div>

<!--
    <a class="d-inline text-decoration-none px-2 py-1 ms-2 rounded data-item-a border border-primary" href='{{$baseUrl}}catUp/"{{$row['id']}}"'>up</a>
-->

@endsection
