<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class InventoryManager
{
    public function assets(){
        $sql = "select * from (select * from(select 'fixed_asset' as asset, fy_year, sum(updated_value) as amount
from FAMS.FA_LEDGER_SUMMARY
group by fy_year
order by fy_year desc)
where rownum <= 3)
pivot(
    sum(amount)
    for asset
    in('fixed_asset' as fixed_asset)
) pivot_table";

        $datas = DB::select($sql);
        $formatted_data = [];
        $row = [];
        foreach ($datas as $data){
            $row['fixed_asset']=$data->fixed_asset;
            $row['fixed_asset_format']=number_format($data->fixed_asset,2);
            $row['fy_year']= $data->fy_year;
            $row['heads'] = $this->getGroupHeads($data->fy_year);
            array_push($formatted_data, $row);
        }
        return $formatted_data;
    }

    public function getGroupHeads($fy_year) {
        $sql = "SELECT ASSET_GROUP_NAME,
         MAX (fy.financial_year_id) AS year_id,
         fy_year,
         to_char(SUM (updated_value), '9,99,99,999,999.99') AS amount
    FROM fams.fa_ledger_summary fs, fams.l_financial_year fy
   WHERE     fs.financial_year_id = fy.financial_year_id
          and fy_year =:fy
GROUP BY ASSET_GROUP_NAME, fy_year order by fy_year desc";
        return DB::select($sql, ['fy' => $fy_year]);
    }
}
