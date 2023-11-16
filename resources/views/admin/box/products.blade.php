<div class="card">
    <div class="card-header">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            добавить
        </button>

        <!-- Modal -->
        <div  wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control" wire:model="productId">
                                <option value="">выберите продукт</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->article}} {{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" wire:model="count" class="form-control" placeholder="количество">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="add()" class="btn btn-primary">добавить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <td>ID</td>
                <td>артикул</td>
                <td>продукт</td>
                <td>кол.</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($boxProducts as $BoxProduct)
                <tr>
                    <td>{{$BoxProduct->product_id}}</td>
                    <td>{{$BoxProduct->product->article}}</td>
                    <td>{{$BoxProduct->product->name}}</td>
                    <td>{{$BoxProduct->count}}</td>
                    <td class="project-actions text-right">
                        <button class="btn btn-info btn-sm" wire:click="plus({{$BoxProduct->id}})">
                            <i class="fas fa-plus"></i>
                        </button>
                        @if($BoxProduct->count > 1)
                            <button class="btn btn-info btn-sm" wire:click="minus({{$BoxProduct->id}})">
                                <i class="fas fa-minus"></i>
                            </button>
                        @endif
                        <button  class="btn btn-danger btn-sm"  wire:click="delete({{$BoxProduct->id}})"  onclick="return confirm('Удалить?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


