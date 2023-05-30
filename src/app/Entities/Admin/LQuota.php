<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LQuota extends Model
{
    protected $table = "l_quota";
    protected $primaryKey = "quota_id";

    protected $appends = ['text', 'value'];


    protected function getTextAttribute() {
        return $this->quota_name;
    }

    protected function getValueAttribute() {
        return $this->quota_id;
    }
}
