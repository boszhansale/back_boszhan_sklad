@extends('admin.layouts.index')

@section('content-header-title','Перемещение')
@section('content-header-right')
@endsection
@section('content')
    @livewire('admin.moving-index',['userId' => $userId,'storeId' => $storeId,'storageId'=> $storageId])
@endsection
