@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.box.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">номер</label>
                    <input type="text" class="form-control" value="{{$number}}" name="number" required>
                </div>
                <div class="form-group">
                    <select name="warehouse_id" class="form-control">
                        @foreach($warehouses as $warehouse)
                            <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="col-md-6">
                <div class="visible-print text-center">
{{--                    {!! QrCode::size(400)->generate($number); !!}--}}
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(400)->generate($number)) !!} ">
                </div>
            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
