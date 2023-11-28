@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.product.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label for="">ID 1C</label>
                    <input type="text" class="form-control" name="id_1c">
                </div>
                <div class="form-group">
                    <label for="">Артикул</label>
                    <input type="text" class="form-control" name="article" required>
                </div>
                <div class="form-group ">
                    <label for="">Мерка</label>
                    <select name="measure"  class="form-control">
                        <option  value="1">штука(1)</option>
                        <option  value="2">кг(2)</option>
                    </select>
                </div>
                <div class="form-group ">
                    <label for="">Категория</label>
                    <select name="category_id"  class="form-control">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->brand->name}} - {{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">barcode</label>
                    <input type="text" class="form-control" name="barcode" >
                </div>


                <div class="form-group">
                    <label for="">остаток</label>
                    <input type="number" class="form-control" name="remainder" >
                </div>
                <div class="form-group">
                    <label for="">Скидка %</label>
                    <input type="number" class="form-control" name="discount" value="0">
                </div>


            </div>
            <div class="col-md-4">
                @foreach($priceTypes as $k => $priceType)
                    <div>
                        <label for="">
                            {{$priceType->name}}
                            <small>{{$priceType->description}}</small>
                        </label>
                        <input type="hidden" name="price_types[{{$k}}][price_type_id]" value="{{$priceType->id}}">
                        <input class="form-control" type="number" name="price_types[{{$k}}][price]" value="0">
                    </div>
                @endforeach
            </div>

        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
