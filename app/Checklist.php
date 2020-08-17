<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{

    protected $fillable = [
        'title', 'status', 'todo_id'
    ];

    public function todo()
    {
        return $this->belongsTo('App\Todo', 'todo_id');
    }
}
