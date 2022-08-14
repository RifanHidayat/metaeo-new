<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    public function company()
    {

        return $this->setConnection('mysql')->belongsTo(Company::class, 'company_id');
    }

    public function journal()
    {

        return $this->setConnection('mysql2')->hasOne(Company::class, 'journal_id');
    }
}
