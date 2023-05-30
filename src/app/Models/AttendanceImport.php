<?php

namespace App\Models;
use App\Entities\Admin\DeviceAttendance;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AttendanceImport implements ToModel,WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $date = preg_replace('@\x{FFFD}@u', ' ', $row[3]);
        $attendance = new DeviceAttendance([
            'sl_no'         => $row[0],
            'emp_code'      => $row[1],
            'device_name'   => null,
            'access_mode'   => $row[2],
            'access_time'   => str_replace('�',' ',$date)
        ]);
        return $attendance;
    }

    public function startRow(): int
    {
        return 2;
    }
}
