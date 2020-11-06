<?php

namespace EasyPanel\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'checked'];

    public function admin()
    {
        return $this->belongsTo(config('easy_panel.user_model'));
    }

}
