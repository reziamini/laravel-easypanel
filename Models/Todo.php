<?php

namespace AdminPanel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'checked'];

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

}
