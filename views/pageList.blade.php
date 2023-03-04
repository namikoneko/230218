@extends("layout")

@section("content")

<form class="ins-form mt-2" action="/230218/pageInsExe" method="post">

    <div class="row">

        <div class="col-1">
                          <label class="" for="title">
                            page title
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


    <div class="bg-white">

    <div class="mt-2 px-3 py-2 row border-bottom">

        <div class="col-1">id</div>
        <div class="col-1">dummy</div>
        <div class="col-3">title</div>
        <div class="col-5 p-0">url</div>
        <div class="col-2">update</div>

    </div>

    <div class="mt-2 px-3 py-2 row">

  @foreach($rows as $row)

    <div class="col-1">
        {{$row["id"]}}
    </div>

    <div class="col-1">
        dummy
    </div>

    <div class="col-3">
        {{$row["title"]}}
    </div>

    <div class="col-5 text-break p-0">
        {{$row["url"]}}
    </div>

    <div class="col-2">

        <a class="text-decoration-none" href='pageUpd?id={{$row["id"]}}'>update</a>

    </div>

  @endforeach

</div>

</div>

<!--
        sort: <input type="text" class="inputText form-control" name="sort">

-->


@endsection
