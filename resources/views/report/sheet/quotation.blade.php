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
        @foreach($quotations as $quotation)
        <tr>
            @foreach ($all_columns as $column)
            @if(in_array($column['id'], $column_selections))
            @if($column['id'] == 'customer')
            <td>{{ $quotation->customer->name }}</td>
            @elseif($column['id'] == 'up')
            <td>{{ $quotation->picPo->name }}</td>
            @elseif($column['id'] == 'paid')
            @if($quotation->paid == 1)
            <td>Lunas</td>
            @else
            <td>Belum Lunas</td>
            @endif
            @else
            @if($column['id'] == 'quantity' || $column['id'] == 'price_per_unit' || $column['id'] == 'ppn' || $column['id'] == 'pph' || $column['id'] == 'total_bill' || $column['id'] == 'produced' || $column['id'] == 'shipped')
            <td data-format="#,##0_-">{{ $quotation->{$column['id']} }}</td>
            @else
            <td>{{ $quotation->{$column['id']} }}</td>
            @endif
            @endif
            @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>