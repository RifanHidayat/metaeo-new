<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
       public function eventQuotations()
    {
        return $this->belongsToMany(EventQuotation::class)->withPivot('event_quotation_id', 'sales_order_id', 'project_id');
    }

        public function v2SalesOrders()
    {
        return $this->belongsToMany(V2SalesOrder::class)->withPivot('v2_sales_order_id', 'project_id');
    }
    public function members(){
        return $this->hasMany(ProjectMember::class);
    }
    public function budgets(){
        return $this->hasOne(ProjectBudget::class);
    }
    public function tasks(){
        return $this->hasMany(ProjectTask::class);
    }
}
