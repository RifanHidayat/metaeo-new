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
        @foreach($transactions as $transaction)
        <tr>
            @foreach ($all_columns as $column)
            @if(in_array($column['id'], $column_selections))
            @if($column['id'] == 'customer')
            <td>{{ $transaction->customer->name }}</td>
            @elseif($column['id'] == 'invoices')
            <td>{{ collect($transaction->invoices)->pluck('number')->implode(', ') }}</td>
            @else
            @if($column['id'] == 'total')
            <td data-format="#,##0_-">{{ $transaction->{$column['id']} }}</td>
            @else
            <td>{{ $transaction->{$column['id']} }}</td>
            @endif
            @endif
            @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>