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
        @foreach($job_orders as $job_order)
        <tr>
            @foreach ($all_columns as $column)
            @if(in_array($column['id'], $column_selections))
            @if($column['id'] == 'customer')
            <td>{{ $job_order->customer->name }}</td>
            @elseif($column['id'] == 'quotations')
            <td>{{ collect($job_order->quotations)->pluck('number')->implode(', ') }}</td>
            @elseif($column['id'] == 'sales_order')
            <td>{{ $job_order->salesOrder->number }}</td>
            @elseif($column['id'] == 'total_production')
            <td data-format="#,##0_-">
                {{ collect($job_order->quotations)->map(function($quotation) {
                return $quotation->pivot->produced;
                })->sum() }}
            </td>
            @else
            <td>{{ $job_order->{$column['id']} }}</td>
            @endif
            @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>