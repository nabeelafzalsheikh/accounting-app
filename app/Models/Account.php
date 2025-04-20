<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type_id',
        'color'
    ];

    public function type()
    {
        return $this->belongsTo(AccountType::class, 'type_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getBalanceAttribute()
    {
        $credits = $this->transactions()->where('type', 'credit')->sum('amount');
        $debits = $this->transactions()->where('type', 'debit')->sum('amount');
        return $credits - $debits;
    }



public function balance()
{
    $debits = $this->transactions()->where('type', 'debit')->sum('amount');
    $credits = $this->transactions()->where('type', 'credit')->sum('amount');
    
    return $debits - $credits;
}

public function balanceAsOf($date, $excludeId = null)
{
    $query = $this->transactions()
        ->where('date', '<=', $date);
    
    if ($excludeId) {
        $query->where('id', '<=', $excludeId);
    }
    
    $debits = $query->clone()->where('type', 'debit')->sum('amount');
    $credits = $query->clone()->where('type', 'credit')->sum('amount');
    
    return $debits - $credits;
}
}