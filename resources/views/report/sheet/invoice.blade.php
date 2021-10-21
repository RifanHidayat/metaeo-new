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
        @foreach($invoices as $invoice)
        <tr>
            @foreach ($all_columns as $column)
            @if(in_array($column['id'], $column_selections))
            @if($column['id'] == 'customer')
            <td>{{ $invoice->customer->name }}</td>
            @elseif($column['id'] == 'quotations')
            <td>{{ collect($invoice->quotations)->pluck('number')->implode(', ') }}</td>
            @elseif($column['id'] == 'sales_order')
            <td>{{ $invoice->salesOrder->number }}</td>
            @else
            @if($column['id'] == 'netto' || $column['id'] == 'discount' || $column['id'] == 'ppn' || $column['id'] == 'pph' || $column['id'] == 'total' || $column['id'] == 'total_payment' || $column['id'] == 'unpaid')
            <td data-format="#,##0_-">{{ $invoice->{$column['id']} }}</td>
            @else
            <td>{{ $invoice->{$column['id']} }}</td>
            @endif
            @endif
            @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>