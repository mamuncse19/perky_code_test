<?php
$id = 'a' . uniqid();
?>

<tr>
    <td>
        {!! Form::select('name['.$id.']',$productList,null,['id'=>'productId_'.$id,'class'=>'form-control'])!!}
    </td>
    <td>
        <button  class="btn btn-danger remove-row"><i class="fa fa-minus-square"></i></button>
    </td>
</tr>