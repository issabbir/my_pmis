<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class DbBackupManager
{
    public function getData()
    {
        $sql = "Select
                x.BACKUP_DB_ID,
                x.BACKUP_SART_TIME,
                x.BACKUP_END_TIME,
                x.BACKUP_TYPE,
                x.BACKUP_TYPE_ID,
                x.SUCESSFUL_YN,
                x.BACKUP_FILE_DESCRIPTION from(
                        Select * from CPA_DB_BACKUP.backup_db b where b.SUCESSFUL_YN ='Y' order by b.generate_sys_date desc
                    ) x
            where rownum <=5";
       return DB::select($sql);
    }
}
