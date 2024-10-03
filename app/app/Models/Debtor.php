<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Debtor extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'debtors';
    protected $fillable = ['identification_number', 'situation', 'sum_of_loans', 'entity_code'];
}
