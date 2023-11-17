<div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>продукт</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($formulas as $formula)
                    <tr >
                        <th>{{$formula->id}}</th>
                        <th>
                            {{$formula->product->name}}
                        </th>
                        <td class="project-actions text-right">
                            <a class="btn btn-info btn-sm" href="{{route('admin.formula.edit',$formula->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
                            <a  class="btn btn-danger btn-sm" href="{{route('admin.formula.delete',$formula->id)}}" onclick="return confirm('Удалить?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{$formulas->links()}}
</div>
