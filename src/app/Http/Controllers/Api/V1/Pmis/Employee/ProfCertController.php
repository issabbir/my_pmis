<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Contracts\Admin\AdminContract;
use App\Entities\Pmis\Employee\EmpProfCertificateTemp;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class ProfCertController extends Controller
{
    protected $adminManager;
    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getData();
    }
     public function specific(Request $request, $id)
    {
        $certificate = new EmpProfCertificateTemp();
        $certificates = $certificate
            ->select('certificate_name', 'certificate_country_id', 'certificate_institute', 'certificate_date', 'certificate_expire_date', 'certificate_id')
            ->where('emp_id', $id)
            ->orderBy('certificate_id', 'desc')->get();

        return [
            'countries' => $this->geoCountry(),
            'certificates' => $certificates
        ];
    }

    public function view(Request $request, $id)
    {
        $preofessionalCertificate = new EmpProfCertificateTemp();
        return $preofessionalCertificate->find($id);
    }

    public function store(Request $request)
    {
        return $this->employees_create_new_pro_cert($request);
    }

    public function update(Request $request)
    {
        //TODO: Default template for action.
    }
    public function remove(Request $request,$id)
    {
        return $this->employees_delete_new_pro_cert($id);
    }

    public function employees_create_new_pro_cert(Request $request)
    {
        try {
            $certificate_id = $request->get("certificate_id");
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $certificate_date = $request->get('certificate_date') ? date("Y-m-d", strtotime($request->get('certificate_date'))) : '';
            $certificate_expire_date = $request->get('certificate_expire_date') ? date("Y-m-d", strtotime($request->get('certificate_expire_date'))) : '';

            $params = [
                "certificate_id"=>[
                    "value" => &$certificate_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "emp_id" =>  $request->get('emp_id'),
                "certificate_name" => $request->get("certificate_name"),
                "certificate_country_id" => $request->get("certificate_country_id"),
                "certificate_description" => $request->get("certificate_description"),
                "certificate_institute" => $request->get("certificate_institute"),
                "certificate_date" => $certificate_date,
                "certificate_expire_date" => $certificate_expire_date,
                "certificate_document"=> [
                    'value' => $request->get("certificate_document"),
                    'type' => SQLT_CLOB,
                ],
                'certificate_document_name' => $request->get("certificate_document_name"),
                'certificate_document_type' => $request->get("certificate_document_type"),
                "insert_by" => auth()->id(),
                "update_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure("EMPLOYEES.CREATE_NEW_PRO_CERT", $params);
        }
        catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function employees_delete_new_pro_cert($id)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "certificate_id" =>$id,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("EMPLOYEES.DELETE_NEW_PRO_CERT", $params);
        }
        catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function getData(){
        $certificate = new EmpProfCertificateTemp();

        return [
            'countries' => $this->geoCountry()
        ];
    }

    /**
     * @return array
     * look up table
     */
    private function geoCountry() {
        $country = [];
        $country[] = ["value" => null, 'text' => 'Select Country'];
        foreach ($this->adminManager->findGeoCountries() as $item) {
            $country[] = ["text" => $item->country, 'value' => $item->country_id];
        }
        return $country;
    }
}
