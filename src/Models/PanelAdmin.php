<?php


namespace EasyPanel\Models;


use Illuminate\Database\Eloquent\Model;

class PanelAdmin extends Model
{

    /**
    * Create a new Eloquent model instance.
    *
    * @param array $attributes
    */
    public function __construct(array $attributes = [])
    {
        $connection = config('easy_panel.database.connection') ?: config('database.default');
        $table = config('easy_panel.database.panel_admin_table') ?: 'panel_admins';

        $this->setConnection($connection);

        $this->setTable($table);

        parent::__construct($attributes);
    }

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(config('easy_panel.user_model'));
    }
}
