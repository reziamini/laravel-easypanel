<?php


namespace EasyPanel\Models;


use Illuminate\Database\Eloquent\Model;

class PanelAdmin extends Model
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
        $this->setTable(config('easy_panel.database.panel_admin_table'));

        parent::__construct($attributes);
    }

    public function user()
    {
        return $this->belongsTo(config('easy_panel.user_model'));
    }
}
