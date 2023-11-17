@extends('admin.layouts.index')

@section('content-header-title','Тары')
@section('content-header-right')
    <a href="{{route('admin.formula.create')}}" class="btn btn-info btn-sm  ">создать</a>
@endsection
@section('content')
    @livewire('admin.formula-index')
@endsection
