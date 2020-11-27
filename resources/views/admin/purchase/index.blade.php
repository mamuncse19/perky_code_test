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
        	<strong>@lang('lang.SEARCH_PRODUCT')</strong>
        </div>
        <div class="card-body">
        	{!! Form::search('search',null,['class' => 'form-control','placeholder' => 'Enter Product Code / Name','id' => 'searchId']) !!}
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th scope="col" class="align-middle text-center">#</th>
                        <th scope="col" class="align-middle">@lang('lang.PRODUCT_CODE')</th>
                        <th scope="col" class="align-middle">@lang('lang.PRODUCT_NAME')</th>
                        <th scope="col" class="align-middle">@lang('lang.UNIT')</th>
                        <th scope="col" class="align-middle text-center">@lang('lang.ACTION')</th>
                    </tr>
                </thead>
                <tbody id="searchProduct">

                </tbody>
            </table>
        </div>
    </div>
        <div class="card">
        <div class="card-header">
        	<strong>@lang('lang.SELECTED_PRODUCT')</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead id="selectedProduct">
                    <tr>
                        <th scope="col" class="align-middle text-center">#</th>
                        <th scope="col" class="align-middle">@lang('lang.PRODUCT_CODE')</th>
                        <th scope="col" class="align-middle">@lang('lang.PRODUCT_NAME')</th>
                        <th scope="col" class="align-middle">@lang('lang.UNIT')</th>
                        <th scope="col" class="align-middle">@lang('lang.QUANTITY')</th>
                        <th scope="col" class="align-middle">@lang('lang.PRICE')</th>
                        <th scope="col" class="align-middle">@lang('lang.ITEM_TOTAL')</th>
                        <th scope="col" class="align-middle text-center">@lang('lang.ACTION')</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="col-md-4" style="float: right;">
            <table class="table table-bordered" align="right">
            		<tr>
            			<td>@lang('lang.SUB_TOTAL')</td>
            			<td>{!! Form::text('sub_total',null,['class'=>'form-control text-right','id'=>'subTotal','readonly']) !!}</td>
            		</tr>
            		<tr>
            			<td>@lang('lang.TAX')(15%)</td>
            			<td>{!! Form::text('tax',null,['class'=>'form-control text-right','id'=>'tax','readonly']) !!}</td>
            		</tr>
            		<tr>
            			<td>@lang('lang.DISCOUNT')</td>
            			<td>{!! Form::text('discount',null,['class'=>'form-control text-right','id'=>'discount']) !!}</td>
            		</tr>
            		<tr>
            			<td>@lang('lang.GRAND_TOTAL')</td>
            			<td>{!! Form::text('grand_total',null,['class'=>'form-control text-right','id'=>'grandTotal','readonly']) !!}</td>
            		</tr>
            </table>
        </div>
    </div>
    </div>
</div>

<script>
	$(function(){
		$(document).on('keyup','#searchId',function(){
			var productId = $(this).val().trim();
			if(productId == ''){
				$("#searchProduct").html('');
				return false;
			}
			$.ajaxSetup({
    			headers: {
        			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   						 }
			});
			$.ajax({
				url: "{{ URL::to('purchase/getSearchProduct') }}",
				type: "POST",
				dataType: "json",
				data:{
					product_id:productId
				},
				success:function(res){
					$("#searchProduct").html(res.html);
				}
			});
		});

		$(document).on("click", ".select-product", function(){
			var dataId = $(this).attr('data-key');
			$.ajaxSetup({
    			headers: {
        			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   						 }
			});
			$.ajax({
				url: "{{ URL::to('purchase/getSelectedProduct') }}",
				type: "POST",
				dataType: "json",
				data:{
					data_id:dataId
				},
				success:function(res){
				$("#selectedProduct").append(res.html);
				slRearrange();
				}
			});
		});

		$(document).on("click", ".remove-product", function(){
			var dataId = $(this).attr('data-key');
			$("#selecId_"+dataId).remove();
			slRearrange();
			subTotal();
		});

		function slRearrange(){
			var count = 1;
			$('.sl').each(function(){
				$(this).text(count);
				count++;
			});
		}

		$(document).on('keyup','.product',function(){
			var dataId = $(this).attr('data-key');
			var price = $("#price_" + dataId).val();
			var qty = $('#qty_' + dataId).val();
			if(isNaN(price)){
				$('#price_'+dataId).val('');
				$('#price_'+dataId).focus();
				return false;
			}
			if(isNaN(qty)){
				$('#qty_'+dataId).val('');
				$('#qty_'+dataId).focus();
				return false;
			}
			if(price == ''){
				price = 1;
			}
			if(qty == ''){
				qty = 1;
			}
			
			var itemTotal = parseFloat(price)*parseFloat(qty);
			$('.item-total-'+dataId).val(itemTotal);
			setTimeout(function(){
			
			},500);
		subTotal();
		});

		function subTotal(){
			var subTotal = 0;
			
			if(!$("input").hasClass("sub-total")){
				$('#subTotal').val('');
				$("#tax").val('');
				$("#discount").val('')
				$("#grandTotal").val('');
				return false;
			}

			$('.sub-total').each(function(){
				var total = parseFloat($(this).val());
				if(isNaN(total)){
					total = 0;
				}
				subTotal += total;
				$('#subTotal').val(subTotal.toFixed(2));
			});
				taxCalculate();
		}

		function taxCalculate(){
			var subTotal = $('#subTotal').val();
			var tax = (parseFloat(subTotal) * 15) / 100;
			$("#tax").val(tax.toFixed(2));
			grandTotal();
		}

		function grandTotal(){
			var subTotal = parseFloat($('#subTotal').val());
			var tax = parseFloat($("#tax").val());
			var discount = parseFloat($("#discount").val());
			if(isNaN(discount)){
				discount = 0;
			}
			var total = subTotal+tax-discount;
			$("#grandTotal").val(total.toFixed(2));
		}

		$(document).on('keyup','#discount',function(){
			grandTotal();
		});
	});
</script>

@endsection



