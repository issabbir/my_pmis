<?php
namespace App\Contracts\Pmis\Employee;

use Illuminate\Http\Request;

interface BasicInfoContract
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function addBasicInInfo(Request $request);
    public function updateProfile(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateGpfSubscription($request);

}