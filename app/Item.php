<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','storage_id'
    ];
    protected $dates = ['deleted_at'];

    public function storage()
    {
        return $this->belongsTo('App\Storage', 'storage_id', 'id');
    }

}
