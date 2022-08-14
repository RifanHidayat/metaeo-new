<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectBudget extends Model
{
    use HasFactory;
      public function projectBudgetTransactios(){
        return $this->hasMany(ProjectBudgetTransaction::class);
    }
      public function transactions(){
        return $this->hasMany(ProjectBudgetTransaction::class);
    }
}
