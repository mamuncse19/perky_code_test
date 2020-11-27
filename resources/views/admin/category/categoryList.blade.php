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
            <strong class="card-title">Category List</strong>
            <span class="float-right">
                <a href="{{route('categoryCreate')}}" class="btn btn-warning">{{__('lang.ADDNEW')}}</a>
            </span>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="align-middle text-center">#</th>
                        <th scope="col" class="align-middle">Name</th>
                        <th scope="col" class="align-middle">Status</th>
                        <th scope="col" class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$categories->isEmpty())
                    <?php $i = 1; ?>
                    @foreach($categories as $category)
                    <tr>
                        <td class="align-middle text-center">{{$i}}</td>
                        <td class="align-middle">{{$category->name ?? ''}}</td>
                        <td class="align-middle text-center">
                            @if($category->status==1)
                            <span class="btn btn-success"><small>{{__('lang.ACTIVE')}}</small></span>
                            @else
                            <span class="btn btn-secondary"><small>{{__('lang.INACTIVE')}}</small></span>
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <a href="{{route('categoryEdit',$category->id)}}" class="btn btn-info">{{__('lang.EDIT')}}</a>
                            <a href="{{route('categoryDelete',$category->id)}}" onclick="return confirm('Are You Sure!')" class="btn btn-danger">{{__('lang.DELETE')}}</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                    @else
                    <td colspan="4">
                        <p>@lang('lang.NO_DATA_FOUND')</p>
                    </td>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

