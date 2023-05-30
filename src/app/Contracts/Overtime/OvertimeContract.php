<?php

namespace App\Contracts\Overtime;


interface OvertimeContract
{
    public function findOtMonths($id = null);
    public function findOtYears($id = null);
 }
