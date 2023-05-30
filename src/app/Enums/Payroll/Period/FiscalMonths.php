<?php
/**
 * Created by PhpStorm.
 * User: ashraf
 * Date: 12/7/19
 * Time: 11:38 AM
 */

namespace App\Enums\Payroll\Period;


class FiscalMonths
{
    public static function getFiscalMonths()
    {
        return [
            '1' => ['pr_month' => '1', 'text' => 'July'],
            '2' => ['pr_month' => '2', 'text' => 'August'],
            '3' => ['pr_month' => '3', 'text' => 'September'],
            '4' => ['pr_month' => '4', 'text' => 'October'],
            '5' => ['pr_month' => '5', 'text' => 'November'],
            '6' => ['pr_month' => '6', 'text' => 'December'],
            '7' => ['pr_month' => '7', 'text' => 'January'],
            '8' => ['pr_month' => '8', 'text' => 'February'],
            '9' => ['pr_month' => '9', 'text' => 'March'],
            '10' => ['pr_month' => '10', 'text' => 'April'],
            '11' => ['pr_month' => '11', 'text' => 'May'],
            '12' => ['pr_month' => '12', 'text' => 'June'],
        ];
    }

    public static function getFicalMonthNameById($id)
    {
        try {
            $fiscalMonths = self::getFiscalMonths();
            $fiscalMonth = $fiscalMonths[$id]['text'];
            if($fiscalMonth) {
                return $fiscalMonth;
            }
        } catch(\Exception $e) {
            return '';
        }


        return '';
    }

    public static function getStatuses()
    {
        return [
            'N' => ['pr_month' => 'N', 'text' => 'Not Open'],
            'O' => ['pr_month' => 'O', 'text' => 'Open'],
            'C' => ['pr_month' => 'C', 'text' => 'Close'],
        ];
    }

    public static function getStatusById($id)
    {
        try {
            $statuses = self::getStatuses();
            $status = $statuses[$id]['text'];
            if($status) {
                return $status;
            }
        } catch(\Exception $e) {
            return '';
        }


        return '';
    }

    public static function getCurrentMonthStatuses()
    {
        return [
            'Y' => ['current_yn' => 'Y', 'text' => 'Yes'],
            'N' => ['current_yn' => 'N', 'text' => 'No'],
        ];
    }

    public static function getCurrentMonthStatusById($id)
    {
        try {
            $currentMonthStatuses = self::getCurrentMonthStatuses();
            $currentMonthStatus = $currentMonthStatuses[$id]['text'];

            if($currentMonthStatus) {
                return $currentMonthStatus;
            }
        } catch(\Exception $e) {
            return '';
        }


        return '';
    }
}