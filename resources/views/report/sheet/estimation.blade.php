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
        @foreach($estimations as $estimation)
        <tr>
            @foreach ($all_columns as $column)
            @if(in_array($column['id'], $column_selections))
            @if($column['id'] == 'customer')
            <td>{{ $estimation->customer->name }}</td>
            @else
            @if($column['id'] == 'quantity' || $column['id'] == 'production' || $column['id'] == 'hpp' || $column['id'] == 'hpp_per_unit' || $column['id'] == 'price_per_unit' || $column['id'] == 'margin' || $column['id'] == 'total_price' || $column['id'] == 'ppn' || $column['id'] == 'pph' || $column['id'] == 'total_bill')
            <td data-format="#,##0_-">{{ $estimation->{$column['id']} }}</td>
            @else
            <td>{{ $estimation->{$column['id']} }}</td>
            @endif
            @endif
            @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>