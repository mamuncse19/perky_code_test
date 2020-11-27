@if(!empty($productInfo))
<tr class="newRow_{{$productInfo->id}}" id="selecId_{{$productInfo->id}}">
	<td class="sl align-middle text-center"></td>
	<td class="align-middle">{!! $productInfo->product_code ?? '' !!}</td>
	<td class="align-middle">{!! $productInfo->product_name ?? '' !!}</td>
	<td class="align-middle">{!! $productInfo->unit ?? '' !!}</td>
	<td class="align-middle">{!! Form::text('qty',null,['class' => 'form-control text-right product','id'=>'qty_'.$productInfo->id,'data-key' => $productInfo->id]) !!}</td>
	<td class="align-middle">{!! Form::text('price',null,['class' => 'form-control text-right product','data-key' => $productInfo->id,'id' => 'price_'.$productInfo->id]) !!}</td>
	<td class="align-middle">{!! Form::text('total',null,['class' => 'form-control text-right sub-total item-total-'.$productInfo->id,'readonly','data-key' => $productInfo->id]) !!}
	</td>
	<td class="align-middle text-center"><button class="btn btn-danger remove-product" data-key="{{$productInfo->id}}"><i class="fa fa-times"></i></button></td>
</tr>
@endif