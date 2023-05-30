<?php

namespace App\Http\Controllers\Api\V1\Admin\LocationSetup;

//use App\Entities\Admin\HrDepartment;
//use App\Entities\Admin\HrDivision;
use App\Entities\Admin\HrLocDivision;
use App\Entities\Admin\LGeoDivision;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\Admin\AdminContract;

class DivisionController extends Controller
{
    /**
     * @var AdminContract
     */
    private $adminLocDivision;

    public function __construct(AdminContract $adminLocDivision)
    {
        // Dependency injection
        $this->adminLocDivision = $adminLocDivision;
    }

    public function index(Request $request)
    {
        return LGeoDivision::all();
    }

    public function dropdown(Request $request)
    {
        $hrDivisions = LGeoDivision::all();
        $divisions = [];

        foreach($hrDivisions as $key => $division) {
            $divisions[$key]['value'] = $division->geo_division_id;
            $divisions[$key]['text'] = $division->geo_division_name;
        }

        array_unshift($divisions, ['value' => '', 'text' => 'Please select']);

        return $divisions;
    }

    public function view(Request $request, $id)
    {
        $division = $this->adminLocDivision->findLocDivision($id);

        return [
            'division' => [
                'division_id' => $division->division_id,
                'division_name' => $division->division_name,
                'description' => $division->description
            ]
        ];
    }

    public function store(Request $request)
    {
        $division = new LGeoDivision();
        $division->setConnection('cpa_pmis');
        $division->fill($request->all());
        $division->created_by = auth()->ID();
        //dd($request->all());die();
        $division->save();
        return $division->get();
        //TODO: Default template for action.
    }

    public function update(Request $request, $id)
    {
        $division = $this->adminLocDivision->findLocDivision($id);
        $division->setConnection('cpa_pmis');
        $division->fill($request->all());
        $division->created_by = auth()->ID();
        $division->update();
    }

    public function remove(Request $request, $id)
    {
        $department = $this->adminLocDivision->findLocDivision($id);
        $department->delete();
    }

}
