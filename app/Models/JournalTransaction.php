<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalTransaction extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    public function journal()
    {

        return $this->setConnection('mysql2')->belongsTo(Journal::class, 'journal_id');
    }
    public function accounts()
    {
        return $this->setConnection('mysql')->belongsTo(Account::class);
    }
}
