<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'entities';
    protected $fillable = ['entity_code', 'sum_of_loans'];
}
