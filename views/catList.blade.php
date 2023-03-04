@extends("layout")

@section("content")

    <div class="bg-white">

    <div class="mt-2 px-3 py-2 row">

  @foreach($rows as $row)

    <div class="col-1">
        id: {{$row["id"]}}
    </div>

    <div class="col-3">
        title: {{$row["title"]}}
    </div>

    <div class="col-4 text-break">
        url: {{$row["url"]}}
    </div>

    <div class="col-2">

        <a class="text-decoration-none" href='catUpd?id={{$row["id"]}}'>update</a>

    </div>

    <div class="col-2">

        <a class="text-decoration-none" href='catDel/{{$row["id"]}}'>delete</a>

    </div>

  @endforeach

</div>

</div>

<!--
        sort: <input type="text" class="inputText form-control" name="sort">

-->


@endsection
