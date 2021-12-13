<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','user_id'
    ];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
