<?php


namespace App\Managers\Dashboad;
use Illuminate\Support\Facades\DB;

class TrainingManager
{
    public function trainings(){
       /* $sql = " SELECT TO_CHAR (ti.form_date, 'FMMONTH-YYYY')     AS from_month,
         tt.training_type_name,
         COUNT (ti.training_id)                     AS total
    FROM tims.training_info ti, tims.l_training_type tt
   WHERE ti.training_type_id = tt.training_type_id
GROUP BY TO_CHAR (ti.form_date, 'FMMONTH-YYYY'), tt.training_type_name";*/
        $sql = "SELECT TRAINING_TYPE_ID,
         (SELECT LTT.TRAINING_TYPE_NAME
            FROM TIMS.L_TRAINING_TYPE LTT
           WHERE LTT.TRAINING_TYPE_ID = TI.TRAINING_TYPE_ID)
            TYPE_NAME,
         COUNT (TI.TRAINING_ID) \"Total_Training\",
         DECODE (TSM.SCHEDULE_STATUS_ID, 4, 'Closed') STATUS
    FROM TIMS.TRAINING_INFO TI, TIMS.TRAINING_SCHEDULE_MST TSM
   WHERE TI.TRAINING_ID = TSM.TRAINING_ID AND TSM.SCHEDULE_STATUS_ID = 4
GROUP BY TRAINING_TYPE_ID, TSM.SCHEDULE_STATUS_ID";

        $trainings = DB::select($sql);

        /*$data = [];
        $columns = [];
        foreach ($trainings as $training) {
            $columns[] = strtolower($training->from_month);
            $data[strtolower($training->training_type_name)][strtolower($training->from_month)]= $training->total;
            $data[strtolower($training->training_type_name)]['training_type_name']= $training->training_type_name;
        }
        return ['columns' => array_unique($columns), 'data' => $data ];*/
        return $trainings;
    }

    public function getPopupData($type){
        $sql = "SELECT ROWNUM,TI.TRAINING_ID,TI.TRAINING_TITLE,
TI.TRAINING_TYPE_ID TRAINING_TYPE,
       (SELECT LTT.TRAINING_TYPE_NAME
          FROM TIMS.L_TRAINING_TYPE LTT
         WHERE LTT.TRAINING_TYPE_ID = TI.TRAINING_TYPE_ID)
          TYPE_NAME,
       TSM.BATCH_ID,
       (SELECT T.TRAINER_NAME
          FROM TIMS.L_TRAINER T
         WHERE T.TRAINER_ID = TSD.TRAINER_ID)
          TRAINER_NAME,
       TRUNC (TRAINING_START_DATE) START_DATE,
       TRUNC (TRAINING_END_DATE) END_DATE,
       DECODE (TSM.SCHEDULE_STATUS_ID, 4, 'Closed') STATUS
  FROM TIMS.TRAINING_INFO TI,
       TIMS.TRAINING_SCHEDULE_MST TSM,
       TIMS.TRAINING_SCHEDULE_DTL TSD
 WHERE     TI.TRAINING_ID = TSM.TRAINING_ID
       AND TSM.SCHEDULE_STATUS_ID = 4
       AND TSM.SCHEDULE_ID = TSD.SCHEDULE_ID
       AND TI.TRAINING_ID=TSM.TRAINING_ID
       AND TI.TRAINING_TYPE_ID=:type_id";
        return DB::select($sql,['type_id'=>$type]);
    }
}
