@extends('admin.layouts.index')

@section('content-header-title','Заявка №'.$order->id)

@section('content')

    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Обшая информация</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td>{{$order->id}}</td>
                        </tr>
                        <tr>
                            <th>Продавец</th>
                            <td>
                                <a href="{{route('admin.user.show',$order->user_id)}}">{{$order->user->name}}</a>
                            </td>
                        </tr>

                        <tr>
                            <th>Торговый точка</th>
                            <td><a href="{{route('admin.store.show',$order->store_id)}}">{{$order->store->name}}</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Тип оплаты</th>
                            <td>{{$order->paymentTypeInfo()}}</td>
                        </tr>

                        <tr>
                            <th>Дата создании</th>
                            <td>{{$order->created_at}}</td>
                        </tr>
                        <tr>
                            <th>Сумма</th>
                            <td>{{$order->total_price}}</td>
                        </tr>
                        <tr>
                            <th>Сдача</th>
                            <td>{{$order->give_price}}</td>
                        </tr>
                        <tr>
                            <th>сумма скидки</th>
                            <td>{{$order->total_discount_price}}</td>
                        </tr>
                        <tr>
                            <th>Дисконт карта</th>
                            <td>{{$order->discount_phone}}</td>
                        </tr>

                        <tr>
                            <th>Чек</th>
                            <td>
                                @if($order->ticket_print_url)
                                    <a href="{{$order->ticket_print_url}}">{{$order->check_number}}</a>
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Покупки на сумму {{$order->products()->sum('all_price')}}</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Продукт</th>
                            <th>артикул</th>
                            <th>шт/кг</th>
                            <th>Цена</th>
                            <th>скидка</th>
                            <th>Количество</th>
                            <th>итог</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->products()->get() as $basket)
                            <tr>
                                <td>{{$basket->product->id}}</td>
                                <td>{{$basket->product->name}}</td>
                                <td>{{$basket->product->article}}</td>
                                <td>{{$basket->product->measureDescription()}}</td>
                                <td>{{$basket->price}}</td>
                                <td>{{$basket->discount_price}}</td>
                                <td>{{$basket->count}}</td>
                                <td>{{$basket->all_price}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
