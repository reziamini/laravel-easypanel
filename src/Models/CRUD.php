<?php


namespace EasyPanel\Models;


use Illuminate\Database\Eloquent\Model;

class CRUD extends Model
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('easy_panel.database.connection') ?: config('database.default');
        $table = config('easy_panel.database.crud_table') ?: 'cruds';

        $this->setConnection($connection);

        $this->setTable($table);

        parent::__construct($attributes);
    }

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('built', true)->where('active', true)->get();
    }
}
