<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    protected $table = 'lists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task', 'list_id');
    }
}