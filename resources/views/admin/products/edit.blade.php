{{-- resources/views/admin/products/edit.blade.php --}}
@extends('layouts.admin')
@section('title','Edit Product')
@section('page-title','Edit Product')
 
@section('content')
@include('admin.products.create') {{-- Reuse same form, $product is set --}}
@endsection
 
