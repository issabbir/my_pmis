<?php


namespace App\Http\Controllers\Api\V2;

use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Get Employee Dashboard
     *
     * @return array
     */
    public function dashboardData() {
        return [
            'employee' => $this->getEmployeeStatistic(),
            'gender_employee' => $this->getGenderEmployees()
        ];
    }

    /**
     * Get Employee statistics
     *
     * @return array
     */
    private function getEmployeeStatistic() {
        $sql = "select
              et.emp_type_name,
              count(e.emp_id) count
         from employee e
            inner join l_emp_type et on (et.emp_type_id = e.emp_type_id)
         group by  et.emp_type_name";




        $toTalEmployees = DB::select($sql);
        $data = [];
        $row = ["label" => "Employee"];
        $total = 0;
        foreach ($toTalEmployees as $emp) {
            $total += $emp->count;
            $row['total'] = $total;
            $row[strtolower($emp->emp_type_name)] = $emp->count;
        }
        $data[] = $row;

        //Today Attendance
        $sql = "select et.emp_type_name, count(*) count from emp_attendance a
        inner join employee e on (e.emp_id = a.emp_id)
        inner join l_emp_type et on (et.emp_type_id = e.emp_type_id)
        where trunc(a.roster_date) = trunc(sysdate) group by  et.emp_type_name";
        $totalPresent  = DB::select($sql);

        $row = ["label" => "Today Present"];
        $total = 0;
        foreach ($totalPresent as $emp) {
            $total += $emp->count;
            $row['total'] = $total;
            $row[strtolower($emp->emp_type_name)] = $emp->count;
        }
        $data[] = $row;

        //On tour
        $sql = "select et.emp_type_name,count(*) count from emp_leave l
        inner join employee e on (e.emp_id = l.emp_id)
        inner join l_emp_type et on (et.emp_type_id = e.emp_type_id)
        where  trunc(sysdate) between trunc(l.leave_start_date) and trunc(l.leave_end_date)  group by  et.emp_type_name";

        $totalPresent  = DB::select($sql);
        $row = ["label" => "On Leave"];
        $total = 0;
        foreach ($totalPresent as $emp) {
            $total += $emp->count;
            $row['total'] = $total;
            $row[strtolower($emp->emp_type_name)] = $emp->count;
        }
        $data[] = $row;

        $sql = "select et.emp_type_name,count(*) count from emp_tours t
        inner join employee e on (e.emp_id = t.emp_id)
         inner join l_emp_type et on (et.emp_type_id = e.emp_type_id)
          where  trunc(sysdate) between trunc(t.travel_date) and trunc(t.return_date)  group by  et.emp_type_name";

        $totalPresent  = DB::select($sql);
        $row = ["label" => "Tour"];
        $total = 0;
        foreach ($totalPresent as $emp) {
            $total += $emp->count;
            $row['total'] = $total;
            $row[strtolower($emp->emp_type_name)] = $emp->count;
        }
        $data[] = $row;

        return $data;
    }

    /**
     * Get Gender Employees
     */
    private function getGenderEmployees() {
        $sql2 = "select
              g.gender_name,
              et.emp_type_name,
              count(e.emp_id) count
         from employee e
             inner join l_emp_type et on (et.emp_type_id = e.emp_type_id)
             inner join l_gender g on (g.gender_id = e.emp_gender_id)
         group by  g.gender_name, et.emp_type_name order by g.gender_name asc";
        $genderEmployees = DB::select($sql2);

        $data = [];
        $row = [];
        foreach ($genderEmployees as $emp) {
            if ($row && $row['label'] != strtolower($emp->gender_name)) {
                $data[] = $row;
                $row = [];
            }
            $row['label'] = strtolower($emp->gender_name);
            $row[strtolower($emp->emp_type_name)] = $emp->count;
        }

        //Todo: Training..
        return $data;
    }
}
