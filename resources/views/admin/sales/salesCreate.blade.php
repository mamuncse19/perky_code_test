@extends('admin.index')
@section('title')
Admin Dashboard
@endsection
@section('dashboardTitle')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Sales</h1>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="content mt-3">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card ml-5 mr-5">
        <div class="card-body card-block">
            {!! Form::open(['route'=>'salesStore','method'=>'post','enctype'=>'multipart/form-data', 'class'=>'form-horizontal']) !!}
            {{csrf_field()}}
            <div class="row form-group ml-5">
                <div class="col col-md-2">
                    <label for="customer_name" class=" form-control-label">Customer Name</label>
                </div>
                <div class="col-12 col-md-6">
                    {!! Form::text('customer_name',null,['id'=>'customer_name','placeholder'=>'Enter Customer Name','class'=>'form-control'])!!}
                </div>
            </div>
            <table class="table table-bordered" id="products_table">
                <thead>
                    <tr>

                        <th scope="col">Product Name</th>
                        <th scope="col"></th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id = 'a' . uniqid();
                    ?>
                    <tr id="product0">
                        <td>
                            {!! Form::select('name['.$id.']',$productList,null,['id'=>'productId_'.$id,'class'=>'form-control'])!!}
                        </td>

                        <td>
                            <button  id="addRow" class="btn add-row btn-success"><i class="fa fa-plus-square"></i></button>

                        </td>
                    </tr>
<!--                    <tr id="product1"></tr>-->

                </tbody>
                <tbody id="newBody"></tbody>
            </table>
            <div class="row form-group ml-5">
                <div class="col col-md-2">

                </div>
                <div class="col col-md-6">
                    <button type="submit" class="btn btn-primary btn-sm">
                        {{__('lang.SUBMIT')}}
                    </button>
                    <a href="{{route('sales')}}" class="btn btn-secondary btn-sm">
                        {{__('lang.CANCEL')}}
                    </a>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let row_number = 1;
        $(document).on('click', "#add_r", function (e) {
            e.preventDefault();
            let new_row_number = row_number - 1;
            $('#product' + row_number).html($('#product' + new_row_number).html()).parent("tr").find('td:first');
            $('#products_table').append('<tr id="product' + (row_number + 1) + '"></tr>');
            row_number++;
        });
        
        $(document).on("click", ".add-row", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null,
            };


            $.ajax({
                url: "{{URL::to('sales/row')}}",
                type: "POST",
                dataType: 'json', // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                success: function (res) {
                    $("#newBody").prepend(res.html);
//                    $(".tooltips").tooltip();
//                    rearrangeSL('contact');
                },
            });
        });
        
        $(document).on('click', '.remove-row', function () {
            $(this).parent().parent().remove();
//            rearrangeSL('contact');
//            return false;
        });
    });
</script>
@endsection




