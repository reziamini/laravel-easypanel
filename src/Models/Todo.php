<?php

namespace AdminPanel\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'checked'];

    public function admin()
    {
        return $this->belongsTo(config('admin_panel.user_model'));
    }

}
