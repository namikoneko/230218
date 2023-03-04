@extends("layout")

@section("content")

    <form class="ins-form" action='./dataUpdExe' method='post'>

    <input type='hidden' name='id' value="{{$row['id']}}">

    <label for="ins-parent">parent:</label>
    <input type="text" class="inputText form-control" name="parent" id="ins-parent" value="{{$row['parent']}}">

    <label for="ins-title">title:</label>
    <input type="text" class="inputText form-control" name="title" id="ins-title" value="{{$row['title']}}">

    <label for="ins-url">url:</label>
    <input type="text" class="inputText form-control" name="url" id="ins-url" value="{{$row['url']}}">

    <label for="ins-sort">sort:</label>
    <input type="text" class="inputText form-control" name="sort" id="ins-sort" value="{{$row['sort']}}">

    <input class="btn btn-light mt-2" type='submit' value='send'>

    </form>

<div class="my-3 d-flex justify-content-end">
    <a  class="d-inline text-decoration-none px-2 py-1 rounded data-item-a border border-primary" href='../dataDel/"{{$row['id']}}"'>delete</a>
</div>

<!--
    <a class="d-inline text-decoration-none px-2 py-1 ms-2 rounded data-item-a border border-primary" href='{{$baseUrl}}dataUp/"{{$row['id']}}"'>up</a>

-->

@endsection
