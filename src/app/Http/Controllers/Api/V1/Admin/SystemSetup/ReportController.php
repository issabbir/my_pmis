<?php

namespace App\Http\Controllers\Api\V1\Admin\SystemSetup;

use App\Contracts\Admin\AdminContract;
use App\Entities\Security\Report;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use DB;
use PDO;

class ReportController extends Controller {

    /** @var AdminContract|AdminManager  */
    private $adminManager;

    /**
     * ReportController constructor.
     *
     * @param AdminManager|AdminContract $adminManager
     */
    public function __construct(AdminManager $adminManager) {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request) {
        return $this->loadData();
    }

    public function view(Request $request, $id) {
        $report = Report::find($id);
        return $report;
    }

    public function store(Request $request) {
        return $this->createNewReport($request);
    }

    public function update(Request $request, $id) {
        if ($id > 0) {
            return $this->createNewReport($request, $id);
        } else {
            return ["exception" => false, 'o_status_code' => 99, 'o_status_message' => 'Not updated!'];
        }
    }

    public function remove(Request $request, $id) {
        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $report_id = $id;

            $params = [
                'p_REPORT_ID' => [
                    'value' => &$report_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];

            DB::executeProcedure('cpa_security.authorization.sec_report_del', $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, 'o_status_code' => 99, 'o_status_message' => $e->getMessage()];
        }
    }

    private function loadData() {
          return [
              'modules' => $this->adminManager->findSecuriyModules(),
              'reports' => $this->adminManager->findSecurityReports()
        ];
    }

    private function createNewReport(Request $request, $id = '')
    {
       // dd($request->all());
        DB::beginTransaction();
        try {
            $reports = [];
            $statusCode = sprintf('%4000s', '');
            $statusMessage = sprintf('%4000s', '');
            $reportId = isset($id) ? $id : null;
             $params = [
                'p_REPORT_ID' => [
                      "value" => &$reportId,
                      "type" => PDO::PARAM_INPUT_OUTPUT,
                      "length" => 255
                  ],
                'p_REPORT_NAME' => $request->get('report_name'),
                'p_REPORT_XDO_PATH' =>  $request->get('report_xdo_path'),
                'p_REPORT_RTF_PATH' => $request->get('report_rtf_path'),
                'p_ACTIVE_YN' => 'Y',
                'p_MODULE_ID' => $request->get('module_id'),
                'p_INSERT_BY' => auth()->id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];

            DB::executeProcedure('cpa_security.authorization.sec_reports_entry', $params);
             //dd($params);
            if ($params['o_status_code'] == 1) {
                if($reportId){
                    $this->removeParams($reportId);
                }
                $reportsStatusCode = sprintf('%4000s', '');
                $reportsStatusMessage = sprintf('%4000s', '');
                foreach($request->get('report_params') as $reportParam) {
                    //$reports = $reportParam['reports'];
                    $reports = [
                        'p_PARAM_NAME' =>  isset($reportParam['param_name']) ? $reportParam['param_name'] : '',
                        'p_PARAM_LABEL' =>  isset($reportParam['param_label']) ? $reportParam['param_label'] : '',
                        'p_REQUIED_YN' => isset($reportParam['requied_yn']) ? $reportParam['requied_yn'] : 'N',
                        'p_TYPE' => 'text',
                        'p_REPORT_ID' => $params['p_REPORT_ID']['value'],
                        'p_DEFAULT_VALUE' => isset($reportParam['default_value']) ? $reportParam['default_value'] : '',
                        'p_COMPONENT' => isset($reportParam['component']) ? $reportParam['component'] : '',
                        'p_ORDER_NO' => isset($reportParam['order_no']) ? $reportParam['order_no'] : '',
                        'p_INSERT_BY' => auth()->id(),
                        'o_status_code' => &$reportsStatusCode,
                        'o_status_message' => &$reportsStatusMessage
                    ];
                     // dd($reports);
                DB::executeProcedure('cpa_security.authorization.sec_report_param_entry', $reports);
             }
            }
            DB::commit();
            if($reportId){
                $message = 'Report Updated successfully';
            }else{
                $message = 'Report Inserted successfully';
            }
            return ['data' => ['reports' => $params,'params' => $reports],'o_status_code' => 1, 'o_status_message' =>$message];
         } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 400);
        }
    }
    public function removeParams($reportId){
         $paramStatusCode = sprintf('%4000s', '');
         $paramStatusMessage = sprintf('%4000s', '');
         $reports = [
                        'p_REPORT_ID' =>  $reportId,
                        'p_INSERT_BY' => auth()->id(),
                        'o_status_code' => &$paramStatusCode,
                        'o_status_message' => &$paramStatusMessage
                    ];
                     //dd($reports);
         DB::executeProcedure('cpa_security.authorization.sec_report_param_del', $reports);
}
}
