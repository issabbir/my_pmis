<?php


namespace App\Entities\Payroll;

use Illuminate\Database\Eloquent\Model;

class PrProcess extends Model
{
    protected $table = "pr_process";
    protected $primaryKey = 'pr_process_id';
    protected $appends = ['text', 'value'];

    protected function getTextAttribute() {
        return $this->salary_head;
    }

    protected function getValueAttribute() {
        return $this->salary_head_id;
    }

}
