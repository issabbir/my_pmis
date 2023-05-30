<?php


namespace App\Entities\Payroll;

use Illuminate\Database\Eloquent\Model;

class PrSalaryHeads extends Model
{
    protected $table = "pr_salary_heads";
    protected $primaryKey = 'salary_head_id';
    protected $appends = ['text', 'value'];

    protected function getTextAttribute() {
        return $this->salary_head;
    }

    protected function getValueAttribute() {
        return $this->salary_head_id;
    }
}
