<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = ['id'];


    // course user many to many relationship
    public function users()
    {
        return $this->belongsToMany(User::class, 'course_users');
    }
}
