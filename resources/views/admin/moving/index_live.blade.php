<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <small>дата</small>
                    <input wire:model="start_created_at" type="date" required class="form-control">
                    <input wire:model="end_created_at" type="date" required class="form-control">
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th></th>
                    <th>Дата</th>
                </tr>
                </thead>
                <tbody>
                @foreach($movings as $moving)
                        <tr>
                            <td>{{$moving->id}}</td>
                            <td class="project-actions text-left">
                                <a class="btn btn-primary btn-sm" href="{{route('admin.moving.show',$moving->id)}}">
                                    <i class="fas fa-folder">
                                    </i>
                                </a>
                            </td>
                            <td>{{$moving->created_at}}</td>
                        </tr>
                        @endforeach
                </tbody>
            </table>

        </div>

    </div>
    {{$movings->links()}}
</div>
