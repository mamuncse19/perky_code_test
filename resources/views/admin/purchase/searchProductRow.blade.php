@if(!$productArr->isEmpty())
@foreach($productArr as $productInfo)
<tr>
	<td class="align-middle text-center">{!! $loop->index+1 !!}</td>
	<td class="align-middle">{!! $productInfo->product_code ?? '' !!}</td>
	<td class="align-middle">{!! $productInfo->product_name ?? '' !!}</td>
	<td class="align-middle">{!! $productInfo->unit ?? '' !!}</td>
	<td class="align-middle text-center">
		<button type="button" class="btn btn-info select-product" data-key="{{ $productInfo->id}}">@lang('lang.SELECT')</button>
	</td>
</tr>
@endforeach
@else
<tr>
	<td colspan="5"><p>@lang('lang.NO_DATA_FOUND')</p></td>
</tr>
@endif