@extends("layout")

@section("content")

    <div class="bg-white">

    <div class="mt-2 px-3 py-2 row border-bottom">

        <div class="col-1">id</div>
        <div class="col-3">title</div>
        <div class="col-4">url</div>
        <div class="col-2">update</div>
        <div class="col-2">delete</div>

    </div>

    <div class="mt-2 px-3 py-2 row">

  @foreach($rows as $row)

    <div class="col-1">
        {{$row["id"]}}
    </div>

    <div class="col-3">
        {{$row["title"]}}
    </div>

    <div class="col-4 text-break">
        {{$row["url"]}}
    </div>

    <div class="col-2">

        <a class="text-decoration-none" href='dataUpd?id={{$row["id"]}}'>update</a>

    </div>

    <div class="col-2">

        <a class="text-decoration-none" href='dataDel/{{$row["id"]}}'>delete</a>

    </div>

  @endforeach

</div>

</div>

<!--
        sort: <input type="text" class="inputText form-control" name="sort">

-->


@endsection
