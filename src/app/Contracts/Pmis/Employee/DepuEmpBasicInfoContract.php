<?php
namespace App\Contracts\Pmis\Employee;

use Illuminate\Http\Request;

interface DepuEmpBasicInfoContract
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function addBasicInInfo(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateGpfSubscription($request);

    public function getDeputationEmpInfo($id);

}
