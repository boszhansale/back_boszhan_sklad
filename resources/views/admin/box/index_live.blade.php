<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <select wire:model="warehouseId" class="form-control">
                            <option value="">все склады</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>номер</th>
                    <th>склад</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($boxes as $box)
                    <tr >
                        <th>{{$box->id}}</th>
                        <th>
                            <a href="{{route('admin.box.show',$box->id)}}">
                                {{$box->number}}
                            </a>
                        </th>
                        <th>
                            {{$box->warehouse->name}}
                        </th>

                        <td class="project-actions text-right">
                            <a class="btn btn-info btn-sm" href="{{route('admin.box.edit',$box->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
                            <a  class="btn btn-danger btn-sm" href="{{route('admin.box.delete',$box->id)}}" onclick="return confirm('Удалить?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{$boxes->links()}}
</div>
