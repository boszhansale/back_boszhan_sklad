@extends('admin.layouts.index')
@section('content')
    <form class="store-edit" action="{{route('admin.formula.update',$formula->id)}}" method="post"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">количество</label>
                    <input type="number" class="form-control" value="1" name="count" required>
                </div>
                <div class="form-group">
                    <select name="product_id" class="form-control">
                        @foreach($products as $product)
                            <option {{$formula->product_id == $product->id ? 'selected': ''}} value="{{$product->id}}">{{$product->article}} {{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                @livewire('admin.formula-products',['formulaId' => $formula->id])
            </div>

        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
