<table>
    <thead>
        <tr>
            @foreach ($all_columns as $column)
            @if (in_array($column['id'], $column_selections))
            <td>{{ $column['text'] }}</td>
            @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($delivery_orders as $delivery_order)
        <tr>
            @foreach ($all_columns as $column)
            @if(in_array($column['id'], $column_selections))
            @if($column['id'] == 'customer')
            <td>{{ $delivery_order->customer->name }}</td>
            @elseif($column['id'] == 'quotations')
            <td>{{ collect($delivery_order->quotations)->pluck('number')->implode(', ') }}</td>
            @elseif($column['id'] == 'sales_order')
            <td>{{ $delivery_order->salesOrder->number }}</td>
            @elseif($column['id'] == 'total_shipping')
            <td data-format="#,##0_-">
                {{ collect($delivery_order->quotations)->map(function($quotation) {
                return $quotation->pivot->amount;
                })->sum() }}
            </td>
            @else
            <td>{{ $delivery_order->{$column['id']} }}</td>
            @endif
            @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>