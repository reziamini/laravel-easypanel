<?php


namespace EasyPanel\Models;


use Illuminate\Database\Eloquent\Model;

class CRUD extends Model
{
    protected $guarded = [];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        
        $this->setConnection(config('easy_panel.database.connection'));
        $this->setTable(config('easy_panel.database.crud_table'));

        parent::__construct($attributes);
    }

    public function scopeActive($query)
    {
        return $query->where('built', true)->where('active', true)->get();
    }
}
