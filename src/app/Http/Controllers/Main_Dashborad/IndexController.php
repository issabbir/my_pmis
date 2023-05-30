<?php

namespace App\Http\Controllers\Main_Dashborad;

use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
use App\Managers\Dashboad\AccountManager;
use App\Managers\Dashboad\AppointmentManager;
use App\Managers\Dashboad\BoardDecisionManager;
use App\Managers\Dashboad\CaseManager;
use App\Managers\Dashboad\AuditManager;
use App\Managers\Dashboad\DbBackupManager;
use App\Managers\Dashboad\EquipmentManager;
use App\Managers\Dashboad\FinanceManager;
use App\Managers\Dashboad\HydrographyManager;
use App\Managers\Dashboad\IncidentManager;
use App\Managers\Dashboad\InventoryManager;
use App\Managers\Dashboad\MarineManager;
use App\Managers\Dashboad\OneStopManager;
use App\Managers\Dashboad\SalaryManager;
use App\Managers\Dashboad\TrainingManager;
use App\Managers\Dashboad\AuthorizedPositionManager;
use App\Managers\Dashboad\EmployeeManager;
use App\Managers\Dashboad\HouseAllotmentManager;
Use App\Managers\Dashboad\RecruitmentManager;
Use App\Managers\Dashboad\CivilEngineeringManager;
use App\Managers\Dashboad\VehicleManager;
use App\Managers\Dashboad\VesselBillingManager;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function index() {
        $access_menus = [44];
        $auth = auth();
        if ($auth->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = $auth->user()->getRoleMenus();
        }

        return view('main_dashboard.index', ['menus' => $menus ,'access_menus' => $access_menus]);
    }
    public function my_account(Guard $auth) {
        $access_menus = [44];
        if ($auth->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = $auth->user()->getRoleMenus();
        }
        return view('main_dashboard.index', ['menus' => $menus,'access_menus' => $access_menus]);
    }
    //
    public function dbMenues() {
        $auth = auth();
        if ($auth->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = $auth->user()->getRoleMenus();
        }
        return $menus;
    }

    public function chairmanDashboard() {
        return view('main_dashboard.chairman');
    }

    public function dashbaord(EmployeeManager $em) {
        $emp_data = $em->dashboardData();
        return view('main_dashboard.dashboard', ['emp_data' => $emp_data]);
    }

    public function payableAndReceivableSummery(FinanceManager $financeManager) {
        $accounts_receivable = $financeManager->accounts_receivable_summary();
        $accounts_payable = $financeManager->accounts_payable_summary();
        $fas_ar = view('main_dashboard.partials.fas_ar', [
            'ajax' => true,
            'accounts_receivable'=>$accounts_receivable,
        ])->render();

        $fas_ap = view('main_dashboard.partials.fas_ap', [
            'ajax' => true,
            'accounts_payable'=>$accounts_payable
        ])->render();

        return [
            'fas_ar' => $fas_ar,
            'fas_ap' => $fas_ap
        ];
    }

    /**
     * Case statistics data
     * @param CaseManager $caseManager
     * @return mixed
     */
    public function cases(CaseManager $caseManager) {
        $data = $caseManager->getData();
        $html = view('main_dashboard.partials.case', ['data' => $data, 'ajax' => true])->render();
        return [
          'html' => $html,
          'current_year' => (sizeof($data)>0)?$data[0]:[]
        ];
    }



    /**
     * HouseAllotment statistics data
     * @param HouseAllotmentManager $houseAllotmentManager
     * @return mixed
     */
    public function houseAllotment(HouseAllotmentManager $houseAllotmentManager) {
        $data = $houseAllotmentManager->getData();
        $html = view('main_dashboard.partials.ha', ['data' => $data, 'ajax' => true])->render();
        return [
            'html' => $html
        ];
    }

    public function getHouseAllotPopData($status, HouseAllotmentManager $houseAllotmentManager) {
        $data = $houseAllotmentManager->getPopData($status);
//        dd($data);
        $stringParts = explode("+", $status);

        $house_type  = $stringParts[0];
        $status = $stringParts[1];
        $html = view('main_dashboard.partials.ha-detail', ['data' => $data,'status'=>$status])->render();
        return  $html;
    }
    public function lyingDetailsPoup($date, OneStopManager $oneStopManager) {
        $data = $oneStopManager->getPopData($date);
        //dd($data);
        $html = view('main_dashboard.partials.lying-detail', ['data' => $data,'date' => $date])->render();
        return  $html;
    }
    /**
     * OneStop statistics data
     * @param OneStopManager $oneStopManager
     * @return mixed
     */
    public function onceStopSummery(OneStopManager $oneStopManager) {
        $data = $oneStopManager->getData();
         return [
            'data' => $data,
        ];
    }


    /**
     * OneStop statistics data
     * @param OneStopManager $oneStopManager
     * @return mixed
     */
    public function containerDetails(OneStopManager $oneStopManager, $type) {
        $data = $oneStopManager->getContainerDetails($type);
        $html = view('main_dashboard.partials.onestop-modal', ['data' => $data, 'ajax' => true])->render();
        return [
            'html' => $html,
             'data' => $data
        ];
    }

    public function getVesselHistory(OneStopManager $oneStopManager) {
        $data = $oneStopManager->getVesselHistory();
        return response()->json($data);
    }

    public function getVacantBerth(OneStopManager $oneStopManager) {
        $data = $oneStopManager->getVacantBerth();
        return response()->json($data);
    }

    public function getNotWorkingVesselOuter(OneStopManager $oneStopManager) {
        $data = $oneStopManager->getNotWorkingVesselOuter();
        return response()->json($data);
    }

    public function containerhandalingDetails(OneStopManager $oneStopManager, $date,$type) {
        $data = $oneStopManager->getContainerHandleList($date,$type);
        $html = view('main_dashboard.partials.onestop-hadaling-modal', ['data' => $data, 'ajax' => true])->render();
        return $html;
    }
    /**
     * Recruitment statistics data
     * @param RecruitmentManager $recruitmentManager
     * @return mixed
     */
    public function recruitment(RecruitmentManager $recruitmentManager) {
        $data = $recruitmentManager->getData();
        $html = view('main_dashboard.partials.recruitment', ['data' => $data, 'ajax' => true])->render();
        return [
            'html' => $html
        ];
    }

    /**
     * Civil Engineering  statistics data
     * @param CivilEngineeringManager $civilEngineeringManager
     * @return mixed
     */
    public function civilEngineering(CivilEngineeringManager $civilEngineeringManager) {
        $data = $civilEngineeringManager->getData();
        $html = view('main_dashboard.partials.ce', ['data' => $data, 'ajax' => true])->render();
        return [
            'html' => $html
        ];
    }

    public function audits(AuditManager $auditManager) {
        $internalAuditData = $auditManager->getInternalAuditData();
        $govAuditData = $auditManager->getGovAuditData();
        return json_encode(array('internal' => $internalAuditData, 'gov' => $govAuditData));
    }

    public function audit_details(AuditManager $auditManager, $status, $year){
        $data = $auditManager->detailInfo($status, $year);
        $view = view('main_dashboard.partials.audit-info', ['data' => $data])->render();
        return  $view;
    }

    public function salaries(SalaryManager $salaryManager){
        $salariesData = $salaryManager->employeeSalary();
        return json_encode(array('salaries'=>$salariesData));
    }

    public function trainings(TrainingManager $trainingManager){
        $trainings = $trainingManager->trainings();
        return json_encode(array('trainings'=>$trainings));
    }
    public function trainingDetailsPopup($type,TrainingManager $trainingManager){
        $data = $trainingManager->getPopupData($type);
        $html = view('main_dashboard.partials.training-detail', ['data' => $data])->render();
        return $html;
    }

    public function authorizedPosition(AuthorizedPositionManager $authorizedPositionManager){
        $position = $authorizedPositionManager->authorizedPosition();
        return json_encode($position);
    }

    public function assets(InventoryManager $inventoryManager){
        $assets = $inventoryManager->assets();
        return json_encode($assets);
    }

    public function genderWiseStafOfficer(EmployeeManager $em){
        $emp_data = $em->dashboardData();
        return json_encode($emp_data);
    }

    public function employee_details_data(EmployeeManager $employeeManager){
        $late_present = $employeeManager->late_present();
        $on_leave = $employeeManager->on_leave();
        $training = $employeeManager->training();
        $tour = $employeeManager->tour();
        return json_encode(array('0'=>$late_present, '1'=>$on_leave, '2' => $training, '3'=>$tour));
    }

    public function department_wise_employee_count(EmployeeManager $employeeManager, $data_for, $emp_type){
        $type_id = $emp_type == 'Officer'? 1 : 2;
        if($data_for == 'Late Present'){
            $data = $employeeManager->late_present_list_department($type_id);
        } elseif ($data_for == 'On Leave'){
            $data = $employeeManager->on_leave_list_department($type_id);
        } elseif ($data_for == 'Training'){
            $data = $employeeManager->training_list_department($type_id);
        } elseif ($data_for == 'Tour'){
            $data = $employeeManager->tour_list_department($type_id);
        }

        $view = view('main_dashboard.partials.department-wise-employee', ['data' =>$data,])->render();
        return  $view;
    }

    public function employee_details_list(EmployeeManager $employeeManager, $data_for, $emp_type, $department_id){
        $type_id = $emp_type == 'Officer'? 1 : 2;
        if($data_for == 'Late Present'){
            $data = $employeeManager->late_present_list($type_id, $department_id);
            $view = view('main_dashboard.partials.late_present', ['data' =>$data,])->render();
        } elseif ($data_for == 'On Leave'){
            $data = $employeeManager->on_leave_list($type_id, $department_id);
            $view = view('main_dashboard.partials.on_leave', ['data' =>$data,])->render();
        } elseif ($data_for == 'Training'){
            $data = $employeeManager->training_list($type_id, $department_id);
            $view = view('main_dashboard.partials.training_list', ['data' =>$data,])->render();
        } elseif ($data_for == 'Tour'){
            $data = $employeeManager->tour_list($type_id, $department_id);
            $view = view('main_dashboard.partials.tour', ['data' =>$data,])->render();
        }
        return  $view;
    }

    public function hydrographyData(HydrographyManager $hydrographyManager){
        $data = $hydrographyManager->getData();
        $data2 = $hydrographyManager->getSchData();

        return  response(
            [
                'survey_data' => $data,
                'schedule_data' => $data2,
            ]
        );
        return json_encode($data).json_encode($format_data);
    }

    public function vesselbills(VesselBillingManager $vesselBillingManager) {
        return $vesselBillingManager->getData();
    }

    public function vesselHandled(VesselBillingManager $vesselBillingManager){
        return $vesselBillingManager->getVesselHandled();
    }

    public function backupData(DbBackupManager $dbBackupManager) {
        return $dbBackupManager->getData();
    }

    public function incidents(IncidentManager $incidentManager) {
        return $incidentManager->getData();
    }

    public function vehicles(VehicleManager $vehicleManager) {
        return $vehicleManager->getData();
    }

    public function vehicleDetails($status,Request $request, VehicleManager $vehicleManager) {
        $data = $vehicleManager->detailInfo($status);

        $view = view('main_dashboard.partials.vehicle-detail-info', ['data' => $data])->render();
        return  $view;
    }

    public function vehicle_particulars(VehicleManager $vehicleManager) {
        $data = $vehicleManager->vehicleParticulars();
        return response()->json($data);
    }

    public function container_lying_position(VehicleManager $vehicleManager) {
        $data = $vehicleManager->containerLyingPosition();
        return response()->json($data);
    }

    public function equipments(EquipmentManager $equipmentManager) {
        return $equipmentManager->getData();
    }

    public function appointment_statistics_data(AppointmentManager $appointmentManager){
        $data=$appointmentManager->meeting_statistic();
        $view = view('main_dashboard.partials.appointment', [
            'data' =>$data,
        ])->render();
        return response()->json(['html' => $view]);
    }

    public function board_meeting_data(BoardDecisionManager $boardDecisionManager){
        $data=$boardDecisionManager->board_meeting_statistic();
        $view = view('main_dashboard.partials.board-decision', [
            'data' =>$data,
        ])->render();
        return response()->json(['html' => $view]);
    }

    /**
     * Accounts summery data
     *
     * @param AccountManager $accountManager
     * @return array
     */
    public function accountSummery(AccountManager $accountManager) {
        return  $accountManager->getData();
    }

    public function budgetPosition(FinanceManager $financeManager){
        $position = $financeManager->budgetPosition();
        return json_encode($position);
    }




    public function salaryGraph(SalaryManager $salaryManager, EmployeeManager $employeeManager){
//        $salariesData = $salaryManager->employeeSalary();
//        dd($salariesData);
        $salary = $employeeManager->late_present();
        $provident_fund = $employeeManager->on_leave();
        $overtime = $employeeManager->training();
        return json_encode(array('0'=>$salary, '1'=>$provident_fund, '2' => $overtime));
    }



    public function budgetStatistics(FinanceManager $financeManager){
        $budgetData = $financeManager->getBudgetStatistics();
        return json_encode(array('budgetStatistics'=>$budgetData));
    }

    public function marineDailyPilotageService(MarineManager $marineManager){
        $data = $marineManager->dailyPilotageService();
        return json_encode($data);
    }
    public function marineDailyDetails($type,MarineManager $marineManager){
        $data = $marineManager->dailyPilotageServiceDetials($type);
        $html = view('main_dashboard.partials.daily-marin-detail', ['data' => $data,'type' => $type])->render();
        return  $html;
    }

    public function marineMonthlyPilotageServiceLineChart(MarineManager $marineManager){
        $data=$marineManager->monthlyPilotageServcieLineChart();
        $inward_data_arr=array();
        foreach ($data['inward_data'] as $key=>$value){
            $inward_data_arr[]=$value->qty;
        }
        $shifting_data_arr=array();
        foreach ($data['shifting_data'] as $key=>$value){
            $shifting_data_arr[]=$value->qty;
        }
        $outward_data_arr=array();
        foreach ($data['outward_data'] as $key=>$value){
            $outward_data_arr[]=$value->qty;
        }
        $cur_mon_last_day= Carbon::parse(Carbon::now())->endOfMonth()->day;
        return ['inward_data'=>$inward_data_arr,
                'shifting_data'=>$shifting_data_arr,
                'outward_data'=>$outward_data_arr,
            'cur_mon_last_day'=>$cur_mon_last_day];
    }

    public function marineMonthlyPilotageService(MarineManager $marineManager){
        $data = $marineManager->monthlyPilotageService();
        return json_encode($data);
    }

    public function marineDailyMooringService(MarineManager $marineManager){
        $data = $marineManager->dailyMooringService();
        return json_encode($data);
    }

    public function marineMonthlyMooringService(MarineManager $marineManager)
    {
        $data = $marineManager->monthlyMooringService();
        $date = array();
        foreach ($data as $key => $value) {
            $date[] = Carbon::parse($value->collection_date)->format('d-m-Y');
        }
        $totalAmt = array();
        foreach ($data as $key => $value) {
            $totalAmt[] = $value->total_charge_amnt;
        }
        $cur_mon_last_day = Carbon::parse(Carbon::now())->endOfMonth()->day;
        return ['total_amount' => $totalAmt,
            'collection_date' => $date,
            'cur_mon_last_day' => $cur_mon_last_day];
    }

    public function marineDailyDuesCollection(MarineManager $marineManager)
    {
        $data = $marineManager->dailyDuesCollection();
        $river_dues = array();
        foreach ($data as $key => $value) {
            $river_dues[] = $value->total_river_dues_amount;
        }
        $license_bill = array();
        foreach ($data as $key => $value) {
            $license_bill[] = $value->total_license_bill_amount;
        }
        $other_dues = array();
        foreach ($data as $key => $value) {
            $other_dues[] = $value->total_other_dues_amount;
        }
        $lc_office = array();
        foreach ($data as $key => $value) {
            $lc_office[] = $value->office_name;
        }
        return ['lc_office' => $lc_office,
            'license_bill' => $license_bill,
            'other_dues' => $other_dues,
            'river_dues' => $river_dues];
    }

    public function marineMonthlyDuesCollection(MarineManager $marineManager)
    {
        $data = $marineManager->monthlyDuesCollection();
        $river_dues = array();
        foreach ($data as $key => $value) {
            $river_dues[] = $value->total_river_dues_amount;
        }
        $license_bill = array();
        foreach ($data as $key => $value) {
            $license_bill[] = $value->total_license_bill_amount;
        }
        $other_dues = array();
        foreach ($data as $key => $value) {
            $other_dues[] = $value->total_other_dues_amount;
        }
        $lc_office = array();
        foreach ($data as $key => $value) {
            $lc_office[] = $value->office_name;
        }
        return ['lc_office' => $lc_office,
            'license_bill' => $license_bill,
            'other_dues' => $other_dues,
            'river_dues' => $river_dues];
    }

    public function marineDailyFreshWaterSupply(IncidentManager $incidentManager) {
        return $incidentManager->getFreshWaterDailyData();
    }

    public function marineMonthlyFreshWaterSupply(IncidentManager $incidentManager) {
        return $incidentManager->getFreshWaterMonthlyData();
    }

    public function caseDetails($status,Request $request, CaseManager $caseManager) {
        $year =  $request->get('year');
        $data = $caseManager->detailInfo($year, $status);

        $view = view('main_dashboard.partials.case-detail-info', ['data' => $data])->render();
        return  $view;
    }

    public function dailyContHand(OneStopManager $oneStopManager) {
        return $oneStopManager->dailyContHand();
    }

    public function dailyTotalIncoming(OneStopManager $oneStopManager) {
        return $oneStopManager->dailyTotalIncoming();
    }

    public function dailyTotalDesp(OneStopManager $oneStopManager) {
        return $oneStopManager->dailyTotalDesp();
    }

    public function vesselMovement(OneStopManager $oneStopManager)
    {
        return $oneStopManager->getVesselMovementData();
    }
}
