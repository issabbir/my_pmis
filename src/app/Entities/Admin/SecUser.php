<?php

namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class SecUser extends Model
{
    protected $table = 'sec_user';
    protected $primaryKey = 'user_id';
}
