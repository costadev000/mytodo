<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Todo extends Model
{

    protected $fillable = [
        'title', 'user_id', 'description', 'status', 'creation_date',
        'done_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function checklists()
    {
        return $this->hasMany('App\Checklist', 'todo_id');
    }
}
