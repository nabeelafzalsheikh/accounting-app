<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transaction_group_id',
        'account_id',
        'description',
        'amount',
        'type',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function group()
    {
        return $this->belongsTo(Transaction::class, 'transaction_group_id');
    }

    public function groupedTransactions()
    {
        return $this->hasMany(Transaction::class, 'transaction_group_id');
    }
}