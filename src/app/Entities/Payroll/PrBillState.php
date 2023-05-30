<?php
namespace App\Entities\Payroll;

use App\Entities\Admin\LPrBillStatus;
use App\Entities\Security\User;
use Illuminate\Database\Eloquent\Model;

class PrBillState extends Model
{
    protected $table = "pr_bill_states";
    protected $primaryKey = 'bill_state_id';
    protected $with = ['comments', 'bill_status', 'user'];
    protected $appends = ['show_comments', 'comment_by'];

    public function comments()
    {
        return $this->hasMany(PrBillStateComment::class, 'bill_state_id');
    }

    public function bill_status()
    {
        return $this->belongsTo(LPrBillStatus::class, 'pr_bill_status_id');
    }

    public function getShowCommentsAttribute() {
        return false;
    }

    public function user() {
        return $this->hasOne(User::class, 'insert_by');
    }

    public function getCommentByAttribute() {
        return $user = $this->user;
        if ($user->employee) {
            return $user->employee;
        }
        return null;
    }
}
