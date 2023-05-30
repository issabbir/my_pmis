<?php


namespace App\Entities\Security;


use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    protected $table = 'CPA_SECURITY.sec_submenu';
    protected $primaryKey = 'submenu_id';
    public $timestamps = false;
    public $sequence = 'CPA_SECURITY.SEQ_SUBMENU_ID';

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }

    public function parent_submenu() {
        return $this->belongsTo(Submenu::class, 'parent_submenu_id', 'submenu_id');
    }

    public function submenus() {
        return $this->hasMany(Submenu::class, 'parent_submenu_id')->orderBy("menu_order_no", 'asc');
    }
}
