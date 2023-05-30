<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class EmployeeManager
{

    /**
     * Get Employee Dashboard
     *
     * @return array
     */
    public function dashboardData() {
        return [
            'total' => $this->totalEmployee(),
            'statistics' => $this->getEmployeeStatistic(),
            'gender_employee' => $this->getGenderEmployees()
        ];
    }

    public function totalEmployee() {
        $sql = "select
              et.emp_type_name,
              count(e.emp_id) count
         from employee e
            left join l_emp_type et on (et.emp_type_id = e.emp_type_id)
            where EMP_STATUS_ID in (1,2,4,6,10,13)
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
        return $row;

    }
    /**
     * Get Employee statistics
     *
     * @return array
     */
    private function getEmployeeStatistic() {

        $data = [];
        $row = ["label" => "Employee"];
        $sql = "SELECT *
  FROM (SELECT et.emp_type_name,
               CASE
                   WHEN EA.EMP_CODE IS NOT NULL AND (EA.OFF_DAY_YN = 'N' OR EA.OFF_DAY_YN IS NULL)
                             AND (EA.HOLIDAY_YN = 'N' OR EA.HOLIDAY_YN IS NULL)
                             AND (EA.ONLEAVE_YN = 'N' OR EA.ONLEAVE_YN IS NULL)
                             AND (   EA.IN_TIME IS NOT NULL
                                  OR EA.OUT_TIME IS NOT NULL)
                   THEN
                       'Present'                       
                   ELSE
                       'Absent'
               END    AS status,
               ev.emp_code
          FROM employee ev, emp_attendance ea, l_emp_type et
         WHERE     ev.emp_id = ea.emp_id(+)
               AND ev.emp_type_id = et.emp_type_id
               AND ev.emp_status_id IN (1,2,4,6,10,13)
               AND TRUNC (ea.roster_date(+)) = (TRUNC (SYSDATE)))
       PIVOT (COUNT (emp_code)
             FOR emp_type_name
             IN ('OFFICER' officer, 'STAFF' staff))";
        $totalEmployee  = DB::select($sql);
        $row = ["label" => "Today Present"];
        $total = 0;
        foreach ($totalEmployee as $emp) {
            if($emp->status == 'Present'){
                $total = $emp->staff+$emp->officer;
                $row['total'] = $total;
                $row['staff'] = $emp->staff;
                $row['officer'] = $emp->officer;
            }
        }
        $data['attendance'] = $row;
        $row = ["label" => "Today Absent"];
        $total = 0;
        foreach ($totalEmployee as $emp) {
            if($emp->status == 'Absent'){
                $total = $emp->staff+$emp->officer;
                $row['total'] = $total;
                $row['staff'] = $emp->staff;
                $row['officer'] = $emp->officer;
            }

        }
        $data['absent'] = $row;

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
        $data['on_leave'] = $row;

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
        $data['on_tour'] = $row;

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
             where e.emp_status_id IN (1,2,4,6,10,13)
         group by  g.gender_name, et.emp_type_name order by g.gender_name asc";
        $genderEmployees = DB::select($sql2);

        $data = [];
        $row = [];

        //dd($genderEmployees);
        foreach ($genderEmployees as $emp) {
            if ($row && strtolower($row['label']) != strtolower($emp->gender_name)) {
                $data[$row['label']] = $row;
                $row = [];
            }
            $row['label'] = strtolower($emp->gender_name);
            $row[strtolower($emp->emp_type_name)] = $emp->count;
        }
        $data[$row['label']] = $row;

        return $data;
    }

    public function  late_present () {

        $sql = "SELECT ET.EMP_TYPE_NAME, COUNT (*) COUNT
    FROM EMP_ATTENDANCE A,
         EMPLOYEE      E,
         L_EMP_TYPE    ET,
         L_EMP_STATUS  ES
   WHERE  e.EMP_STATUS_ID = 1 and  E.EMP_ID = A.EMP_ID
         AND E.EMP_STATUS_ID = ES.EMP_STATUS_ID
         AND E.EMP_STATUS_ID = 1
         AND ET.EMP_TYPE_ID = E.EMP_TYPE_ID
         AND TRUNC (A.IN_TIME) = TRUNC (SYSDATE)
         AND TO_CHAR (A.IN_TIME, 'HH12:MI:SS AM') > '09:30:00 AM'
GROUP BY ET.EMP_TYPE_NAME";
        $data = DB::select($sql);
        return $data;
    }

    public function  late_present_list ($emp_type, $department_id) {
        $sql = "SELECT E.EMP_CODE,
        e.emp_id,
       E.EMP_NAME,
       E.EMP_PHOTO,
       DS.DESIGNATION,
       DPT.DEPARTMENT_NAME,
       ET.EMP_TYPE_NAME,
       A.ROSTER_DATE,
       A.IN_TIME,
       A.OUT_TIME,
       A.WORK_HOURS
  FROM EMP_ATTENDANCE A,
       EMPLOYEE E,
       L_DESIGNATION DS,
       L_DEPARTMENT DPT,
       L_EMP_TYPE ET,
       L_EMP_STATUS ES
 WHERE     E.EMP_STATUS_ID = 1
       AND E.EMP_ID = A.EMP_ID
       AND E.EMP_STATUS_ID = ES.EMP_STATUS_ID
       AND E.EMP_STATUS_ID = 1
       AND ET.EMP_TYPE_ID = E.EMP_TYPE_ID
       AND DS.DESIGNATION_ID = E.DESIGNATION_ID
       AND DPT.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
       AND TRUNC (A.IN_TIME) = TRUNC (SYSDATE)
       AND TO_CHAR (A.IN_TIME, 'HH12:MI:SS AM') > '09:30:00 AM'
       AND E.EMP_TYPE_ID = NVL ( :EMP_TYPE, E.EMP_TYPE_ID)
       AND DPT.DEPARTMENT_ID = NVL ( :DEPARTMENT_ID, DPT.DEPARTMENT_ID)";
        $data = DB::select($sql,['emp_type'=>$emp_type, 'department_id'=>$department_id]);
        return $data;
    }

    public function  late_present_list_department ($emp_type) {
        $sql = "SELECT ET.EMP_TYPE_NAME,
         DPT.DEPARTMENT_NAME,
         DPT.DEPARTMENT_ID,
         COUNT (E.EMP_ID) TOTAL,
         'Late Present' AS \"DATA_FOR\"
    FROM EMP_ATTENDANCE A,
         EMPLOYEE E,
         L_DESIGNATION DS,
         L_DEPARTMENT DPT,
         L_EMP_TYPE ET,
         L_EMP_STATUS ES
   WHERE     E.EMP_STATUS_ID = 1
         AND E.EMP_ID = A.EMP_ID
         AND E.EMP_STATUS_ID = ES.EMP_STATUS_ID
         AND E.EMP_STATUS_ID = 1
         AND ET.EMP_TYPE_ID = E.EMP_TYPE_ID
         AND DS.DESIGNATION_ID = E.DESIGNATION_ID
         AND DPT.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
         AND TRUNC (A.IN_TIME) = TRUNC (SYSDATE)
         AND TO_CHAR (A.IN_TIME, 'HH12:MI:SS AM') > '09:30:00 AM'
         AND E.EMP_TYPE_ID = NVL ( :EMP_TYPE, E.EMP_TYPE_ID)
GROUP BY ET.EMP_TYPE_NAME, DPT.DEPARTMENT_NAME, DPT.DEPARTMENT_ID";
        $data = DB::select($sql,['emp_type'=>$emp_type]);
        return $data;
    }




    public function  on_leave (){
        $sql= "SELECT et.emp_type_name, COUNT (*) COUNT
    FROM emp_leave l
         INNER JOIN employee e ON (e.emp_id = l.emp_id)
         INNER JOIN l_emp_type et ON (et.emp_type_id = e.emp_type_id)
   WHERE TRUNC (SYSDATE) BETWEEN TRUNC (l.leave_start_date)
                             AND TRUNC (l.leave_end_date)

GROUP BY et.emp_type_name";
        $data=DB::select($sql);
        return $data;
    }

    public function  on_leave_list ($emp_type, $department_id){

        $sql= "SELECT e.emp_code,
e.emp_id,
       e.emp_name,
       e.emp_photo,
       ds.designation,
       DPT.DEPARTMENT_NAME,
       et.EMP_TYPE_NAME,
       lt.LEAVE_TYPE,
       l.APPLICATION_DATE,
       l.LEAVE_START_DATE,
       l.LEAVE_END_DATE,
       l.LEAVE_DAYS,
       l.EMERGENCY_NUM
  FROM emp_leave l
       JOIN l_leave_type lt ON (lt.leave_type_id = l.leave_type_id)
       JOIN employee e ON (e.emp_id = l.emp_id)
       join l_designation ds on (DS.DESIGNATION_ID = E.DESIGNATION_ID)
       join l_department dpt on (DPT.DEPARTMENT_ID = e.dpt_DEPARTMENT_ID)
       JOIN l_emp_type et ON (et.emp_type_id = e.emp_type_id)
 WHERE     TRUNC (SYSDATE) BETWEEN TRUNC (l.leave_start_date)
                               AND TRUNC (l.leave_end_date)
       AND e.emp_type_id = NVL ( :emp_type, e.emp_type_id)
       and dpt.department_id = nvl (:department_id, dpt.department_id)";
        $data=DB::select($sql,['emp_type'=>$emp_type, 'department_id'=>$department_id]);
        return $data;
    }

    public function  on_leave_list_department ($emp_type){

        $sql= "SELECT ET.EMP_TYPE_NAME,
         DPT.DEPARTMENT_NAME,
         DPT.DEPARTMENT_ID,
         COUNT (E.EMP_ID) total, 'On Leave' as \"DATA_FOR\"
  FROM emp_leave l
       JOIN l_leave_type lt ON (lt.leave_type_id = l.leave_type_id)
       JOIN employee e ON (e.emp_id = l.emp_id)
       join l_designation ds on (DS.DESIGNATION_ID = E.DESIGNATION_ID)
       join l_department dpt on (DPT.DEPARTMENT_ID = e.dpt_DEPARTMENT_ID)
       JOIN l_emp_type et ON (et.emp_type_id = e.emp_type_id)
 WHERE     TRUNC (SYSDATE) BETWEEN TRUNC (l.leave_start_date)
                               AND TRUNC (l.leave_end_date)
       AND e.emp_type_id = NVL ( :emp_type, e.emp_type_id)       
       GROUP BY ET.EMP_TYPE_NAME, DPT.DEPARTMENT_NAME, DPT.DEPARTMENT_ID";
        $data=DB::select($sql,['emp_type'=>$emp_type]);
        return $data;
    }


    public function  training (){
        $sql= "
  SELECT et.emp_type_name, COUNT (*) COUNT
    FROM EMP_TRAINING Tr
         INNER JOIN employee e ON (e.emp_id = tr.emp_id)
         INNER JOIN l_emp_type et ON (et.emp_type_id = e.emp_type_id)
   WHERE TRUNC (SYSDATE) BETWEEN TRUNC (tr.TRAINING_START_DATE)
                             AND TRUNC (tr.TRAINING_COMPLETION_DATE)
                             and e.EMP_STATUS_ID = 1
GROUP BY et.emp_type_name";
        $data=DB::select($sql);
        return $data;
    }

    public function  training_list ($emp_type, $department_id){
        $sql= "
  SELECT e.emp_code,
       e.emp_id,
       e.emp_name,
       e.emp_photo,
       ds.designation,
       DPT.DEPARTMENT_NAME,
       et.EMP_TYPE_NAME,
       tr.TRAINING_NAME,
       tr.TRAINING_INSTITUTE,
       tr.TRAINING_COMPLETION_DATE,
       tr.TRAINING_START_DATE
  FROM EMP_TRAINING Tr
       JOIN employee e ON (e.emp_id = tr.emp_id)
       join l_designation ds on (DS.DESIGNATION_ID = E.DESIGNATION_ID)
       join l_department dpt on (DPT.DEPARTMENT_ID = e.dpt_DEPARTMENT_ID)
       JOIN l_emp_type et ON (et.emp_type_id = e.emp_type_id)
 WHERE     TRUNC (SYSDATE) BETWEEN TRUNC (tr.TRAINING_START_DATE)
                               AND TRUNC (tr.TRAINING_COMPLETION_DATE)
       AND e.EMP_STATUS_ID = 1
       AND e.emp_type_id = NVL ( :emp_type, e.emp_type_id)
       and dpt.department_id = nvl (:department_id, dpt.department_id)";
        $data=DB::select($sql,['emp_type'=>$emp_type, 'department_id'=>$department_id]);
        return $data;
    }

    public function  training_list_department ($emp_type){
        $sql= "
  SELECT ET.EMP_TYPE_NAME,
         DPT.DEPARTMENT_NAME,
         DPT.DEPARTMENT_ID,
         COUNT (E.EMP_ID) total, 'Training' as \"DATA_FOR\"
    FROM EMP_TRAINING TR
         JOIN EMPLOYEE E ON (E.EMP_ID = TR.EMP_ID)
         JOIN L_DEPARTMENT DPT ON (DPT.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID)
         JOIN L_EMP_TYPE ET ON (ET.EMP_TYPE_ID = E.EMP_TYPE_ID)
   WHERE     TRUNC (SYSDATE) BETWEEN TRUNC (TR.TRAINING_START_DATE)
                                 AND TRUNC (TR.TRAINING_COMPLETION_DATE)
         AND E.EMP_STATUS_ID = 1
         AND E.EMP_TYPE_ID = NVL ( :EMP_TYPE, E.EMP_TYPE_ID)
GROUP BY ET.EMP_TYPE_NAME, DPT.DEPARTMENT_NAME, DPT.DEPARTMENT_ID";
        $data=DB::select($sql,['emp_type'=>$emp_type]);
        return $data;
    }

    public function  tour (){
        $sql= "SELECT et.emp_type_name, COUNT (*) COUNT
    FROM emp_tours t, employee e, l_emp_type et
   WHERE     e.emp_id = t.emp_id
         AND et.emp_type_id = e.emp_type_id
         AND TRUNC (SYSDATE) BETWEEN TRUNC (t.travel_date)
                                 AND TRUNC (t.return_date)
GROUP BY et.emp_type_name";
        $data=DB::select($sql);
        return $data;
    }

    public function  tour_list ($emp_type, $department_id){
        $sql= "select e.emp_code,
e.emp_id,
       e.emp_name,
       e.emp_photo,
       ds.designation,
       DPT.DEPARTMENT_NAME,
       et.emp_type_name,
       t.tour_name,
       tt.tour_type,
       t.travel_date,
       t.return_date,
       t.tour_duration,
       c.country
  from emp_tours t,
       employee e,
       l_designation ds,
       l_department dpt,
       l_emp_type et,
       l_tour_type tt,
       l_geo_country c
 where     e.emp_id = t.emp_id
       and et.emp_type_id = e.emp_type_id
       and DS.DESIGNATION_ID = E.DESIGNATION_ID
       and DPT.DEPARTMENT_ID = e.dpt_DEPARTMENT_ID
       and t.tour_type_id = tt.tour_type_id
       and c.country_id = t.country_id
       and e.emp_type_id = nvl ( :emp_type, e.emp_type_id)
       and trunc (sysdate) between trunc (t.travel_date)
                               and trunc (t.return_date)
                               and dpt.department_id = nvl (:department_id, dpt.department_id)";
        $data=DB::select($sql,['emp_type'=> $emp_type, 'department_id'=>$department_id]);
        return $data;
    }

    public function  tour_list_department ($emp_type){
        $sql= "SELECT ET.EMP_TYPE_NAME,
         DPT.DEPARTMENT_NAME,
         DPT.DEPARTMENT_ID,
         COUNT (E.EMP_ID) TOTAL,
         'Tour' AS \"DATA_FOR\"
    FROM EMP_TOURS T,
         EMPLOYEE E,
         L_DESIGNATION DS,
         L_DEPARTMENT DPT,
         L_EMP_TYPE ET,
         L_TOUR_TYPE TT,
         L_GEO_COUNTRY C
   WHERE     E.EMP_ID = T.EMP_ID
         AND ET.EMP_TYPE_ID = E.EMP_TYPE_ID
         AND DS.DESIGNATION_ID = E.DESIGNATION_ID
         AND DPT.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
         AND T.TOUR_TYPE_ID = TT.TOUR_TYPE_ID
         AND C.COUNTRY_ID = T.COUNTRY_ID
         AND E.EMP_TYPE_ID = NVL ( :EMP_TYPE, E.EMP_TYPE_ID)
         AND TRUNC (SYSDATE) BETWEEN TRUNC (T.TRAVEL_DATE)
                                 AND TRUNC (T.RETURN_DATE)
GROUP BY ET.EMP_TYPE_NAME, DPT.DEPARTMENT_NAME, DPT.DEPARTMENT_ID";
        $data=DB::select($sql,['emp_type'=> $emp_type]);
        return $data;
    }

}
