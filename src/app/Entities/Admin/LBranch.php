<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LBranch extends Model
{
    protected $table = "L_BRANCH";
    protected $primaryKey = "branch_id";
    public $sequence = "id_factory";
    protected  $fillable = [
        'branch_name',
        'branch_name_bng',
        'bank_id',
        'routing_no',
        'branch_address',
        'geo_district_id',
        'geo_district',
        'geo_thana_id',
        'geo_thana',
        'post_code',
        'insert_date',
        'insert_by',
        'update_date',
        'update_by'
    ];
    protected $appends = ['text', 'value','bank_name'];

    public $timestamps = false;

    public function bank(){
        return $this->belongsTo(LBank::class,'bank_id','bank_id');
    }


    protected function getBankNameAttribute() {
        return isset($this->bank) ? $this->bank->bank_name : '';
    }
    protected function getTextAttribute() {
        return $this->branch_name;
    }

    protected function getValueAttribute() {
        return $this->branch_id;
    }
}
