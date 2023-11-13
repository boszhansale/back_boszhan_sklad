@extends('admin.layouts.index')

@section('content-header-title','Тары')
@section('content-header-right')
    <a href="{{route('admin.box.create')}}" class="btn btn-info btn-sm  ">создать</a>
@endsection
@section('content')
    @livewire('admin.box-index')
@endsection
