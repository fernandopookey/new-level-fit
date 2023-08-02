<?php

namespace App\Models\Trainer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerTransactionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_name'
    ];
}
