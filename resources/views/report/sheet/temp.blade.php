@if(in_array('number', $columnSelections))
<td>{{$quotation->number}}</td>
@endif
@if(in_array('date', $columnSelections))
<td>{{$quotation->date}}</td>
@endif
@if(in_array('customer', $columnSelections))
<td>{{$quotation->customer->name}}</td>
@endif
<td data-format="#,##0_-">{{$quotation->total_bill}}</td>