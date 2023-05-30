<?php

namespace App\Entities\Payroll;

use Illuminate\Database\Eloquent\Model;

class PrFiscalYear extends Model
{
    protected $table = 'pr_fiscal_year';
    protected $primaryKey = 'fy_id';
    protected $appends = ['text', 'value'];

    /*public $with = ['pr_months'];*/

    protected function getTextAttribute() {
        return $this->fy_name;
    }

    protected function getValueAttribute() {
        return $this->fy_id;
    }
/*
    public function pr_months()
    {
        return $this->hasMany(PrMonths::class, 'fy_id');
    }*/
}
