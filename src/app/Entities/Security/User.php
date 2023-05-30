<?php

namespace App\Entities\Security;

use App\Entities\Admin\LBank;
use App\Entities\Admin\LBranch;
use App\Entities\Admin\SecIpAllowed;
use App\Entities\Admin\SecUser;
use App\Entities\Pmis\Employee\Employee;
use App\Traits\Security\HasGrantAccess;
use App\Traits\Security\HasPermission;
use App\Traits\Security\HasReport;
use App\Traits\Security\HasUserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasUserRole, HasGrantAccess,HasPermission, HasReport;

    protected $primaryKey = "user_id";
    protected $table = "cpa_security.sec_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pass', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function allowedIPs()
    {
        return $this->hasMany(SecIpAllowed::class, 'user_id');
    }

    public function bank()
    {
        return $this->belongsTo(LBank::class, 'bank_id');
    }

    public function branch()
    {
        return $this->belongsTo(LBranch::class, 'branch_id');
    }

    /**
     * Get uer menu
     *
     * @return mixed
     */
    public function getRoleMenus()
    {
        $_roles = $this->getRoles();
//        return \Cache::remember(
//            'acl.getMenuById_' . $this->user_id,
//            now()->addSeconds(env('ACL_CACHE_SECONDS',6)), function () use ($_roles) {
            $menus = [];
            $subMenus = [];
            foreach ($_roles as $role) {
                $roleMenus = $role->menus;
                foreach ($roleMenus as $menu) {
                    $index = $menu->menu_order_no;
                    $subMenus[$index] = isset($subMenus[$index]) ? array_merge($subMenus[$index], json_decode($menu->pivot->submenus)) : json_decode($menu->pivot->submenus);
                    $menu->role_submenus = $subMenus[$index];
                    $menus[$index] = $menu;
                }
            }
            ksort($menus);
            return $menus;
       // });
    }

    public function getReports()
    {
        $roles = $this->getRoles();
        $reports = [];

        if($roles) {
            foreach($roles as $role) {
                $reps = $role->reports;
                foreach($reps as $rep) {
                    $reports[] = $rep;
                }
            }
        }

        return $reports;
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}
