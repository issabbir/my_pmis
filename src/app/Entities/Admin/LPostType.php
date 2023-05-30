<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LPostType extends Model
{
    protected $table = "l_post_type";
    protected $primaryKey = "post_type_id";

    protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        return $this->post_type;
    }

    public function getValueAttribute() {
        return $this->post_type_id;
    }
}
