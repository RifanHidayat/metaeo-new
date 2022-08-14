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
        @foreach($sales_orders as $sales_order)
        <tr>
            @foreach ($all_columns as $column)
            @if(in_array($column['id'], $column_selections))
            @if($column['id'] == 'customer')
            <td>{{ $sales_order->customer->name }}</td>
            @elseif($column['id'] == 'quotations')
            <td>{{ collect($sales_order->quotations)->pluck('number')->implode(', ') }}</td>
            @else
            <td>{{ $sales_order->{$column['id']} }}</td>
            @endif
            @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>