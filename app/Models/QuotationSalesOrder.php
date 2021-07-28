<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class QuotationSalesOrder extends Pivot
{
    public function estimation()
    {
        return $this->belongsTo(Estimation::class);
    }
}
