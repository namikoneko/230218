@extends("layout")

@section("content")

<h3 class="bg-white px-2">{{$pageRow["title"]}}</h3>

    <div class="bg-white">

    <div class="mt-2 px-3 py-2 row border-bottom">

        <div class="col-1">id</div>
        <div class="col-1">parent</div>
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
        {{$row["parent"]}}
    </div>

    <div class="col-3">
        {{$row["title"]}}
    </div>

    <div class="col-5 text-break p-0">
        {{$row["url"]}}
    </div>

    <div class="col-2">

        <a class="text-decoration-none" href='dataUpd?id={{$row["id"]}}'>update</a>

    </div>


  @endforeach

</div>

</div>

<!--
    <div class="col-2">

        <a class="text-decoration-none" href='dataDel/{{$row["id"]}}'>delete</a>

    </div>

-->


@endsection
