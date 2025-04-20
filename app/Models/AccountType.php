<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'type_id');
    }
}