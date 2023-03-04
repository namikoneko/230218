@extends("layout")

@section("content")

<h3 class="bg-white px-2">{{$pageRow["title"]}}</h3>

<form class="ins-form mt-2" action="/230218/catInsExe" method="post">

    <input type='hidden' name='page' value="{{$page}}">

    <div class="row">

        <div class="col-1">
                          <label class="" for="title">
                            cat title
                          </label>
        </div>

        <div class="col-3 d-flex align-items-end">
                <input type="text" class="inputText form-control" name="title" id="title">
        </div>

        <div class="col-1 d-flex align-items-end">

                <input class="btn btn-light mt-2" type='submit' value='insert'>
        </div>

    </div>

</form>




{!!$str!!}




<!--
        sort: <input type="text" class="inputText form-control" name="sort">

-->


@endsection
