@extends('admin.index')
@section('title')
Category
@endsection

@section('content')
<div class="content mt-3">
    @if(session('status'))
    <div class="col-sm-12">
        <div class="alert  alert-success alert-dismissible fade show" role="alert">
            <span>{{session('status')}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <strong class="card-title">Product List</strong>
            <span class="float-right">
                <a href="{{route('productCreate')}}" class="btn btn-warning">{{__('lang.ADDNEW')}}</a>
            </span>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="align-middle text-center">#</th>
                        <th scope="col" class="align-middle">Product Code</th>
                        <th scope="col" class="align-middle">Product Name</th>
                        <th scope="col" class="align-middle">Category Name</th>
                        <th scope="col" class="align-middle">Unit</th>
                        <th scope="col" class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$products->isEmpty())
                    <?php $i = 1; ?>
                    @foreach($products as $product)
                    <tr>
                        <td class="align-middle text-center">{{$i}}</td>
                        <td class="align-middle">{{$product->product_code}}</td>
                        <td class="align-middle">{{$product->product_name}}</td>
                        <td class="align-middle">{{$product->Category->name}}</td>
                        <td class="align-middle">{!! $product->unit !!}</td>
                        <td class="align-middle text-center">
                            <a href="{{route('productEdit',$product->id)}}" class="btn btn-info">{{__('lang.EDIT')}}</a>
                            <a href="{{route('productDelete',$product->id)}}" onclick="return confirm('Are You Sure!')" class="btn btn-danger">{{__('lang.DELETE')}}</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                    @else
                    <td colspan="6">
                        <p>@lang('lang.NO_DATA_FOUND')</p>
                    </td>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

