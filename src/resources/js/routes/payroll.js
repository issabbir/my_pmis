import MonthlySalaryProcess from '../components/payroll/MonthlySalaryProcess';
import MonthlyBonusProcess from '../components/payroll/MonthlyBonusProcess';
import DepuEmpBonusProcess from '../components/payroll/DepuEmpBonusProcess';
import Period from '../components/payroll/Period';
import SalaryProcessUpdate from '../components/payroll/SalaryProcessUpdate';
import EmployeeSalaries from '../components/payroll/EmployeeSalaries';
import DepuEmployeeSalaries from '../components/payroll/DepuEmployeeSalaries';
import EmployeeBonuses from '../components/payroll/EmployeeBonuses';
import DepuEmployeeBonuses from '../components/payroll/DepuEmployeeBonuses';
import EmployeeSalary from '../components/payroll/setup/EmployeeSalary';
import SearchEmployeeSalaryAllocation from '../components/payroll/setup/SearchEmployeeSalaryAllocation';

import BillerCode from "../components/payroll/setup/BillerCode";
import Biller from "../components/payroll/setup/Biller";
import payrollSummery from "../components/report/payroll/PayrollSummery"
import MonthlyHeadSetup from '../components/payroll/setup/MonthlyHeadSetup';
import BonusProcessSetup from '../components/payroll/setup/BonusProcessSetup';
import BillUpdates from '../components/payroll/BillUpdates';
import FinancialYear from '../components/payroll/setup/FinancialYear';
import SearchDeputationEmployee from '../components/payroll/setup/SearchDeputationEmployee';
import DepuEmployeeSalaryHeadAllocation from '../components/payroll/setup/DepuEmployeeSalaryHeadAllocation';
import ArrearBillGenerate from '../components/payroll/arrear_bill/ArrearBillGenerate';
import ArrearBillSettlement from "../components/payroll/arrear_bill_settlement/ArrearBillSettlement";
import OtherAllowance from "../components/payroll/OtherAllowance";

const routes = [
    { path: '/salary-process', component: MonthlySalaryProcess, name:'monthly-salary-process'},
    { path: '/bonus-process', component: MonthlyBonusProcess, name:'monthly-bonus-process'},
    { path: '/setup-bonus-process', component: BonusProcessSetup, name:'setup-bonus-process'},
    { path: '/depu-employee-bonus-process', component: DepuEmpBonusProcess, name:'depu-employee-bonus-process'},
    { path: '/period', component: Period, name:'period'},
    { path: '/process-update',component:SalaryProcessUpdate, name:'process-update'},
    { path:'/employee-salaries',component:EmployeeSalaries, name:'employee-salaries'},
    { path:'/depu-employee-salaries',component:DepuEmployeeSalaries, name:'depu-employee-salaries'},
    { path:'/employee-bonuses',component:EmployeeBonuses, name:'employee-bonuses'},
    { path:'/depu-employee-bonuses',component:DepuEmployeeBonuses, name:'depu-employee-bonuses'},
    { path:'/salary-setup/employee-salary',component:EmployeeSalary, name:'salary-setup-employee-salary'},
    { path:'/salary-setup/deputation-employee-search',component:SearchDeputationEmployee, name:'deputation-employee-salary-search'},
    { path:'/salary-setup/deputation-employee-salary/:id',component:DepuEmployeeSalaryHeadAllocation,props: true, name:'deputation-employee-salary-search'},
    { path:'/salary-setup/monthly-salary-head',component:MonthlyHeadSetup, name:'salary-setup-monthly-salary-head'},
    { path:'/salary-setup/search-employeewise-salary-allocation',component:SearchEmployeeSalaryAllocation, name:'salary-setup-search-employeewise-salary-allocation'},
    { path: '/biller/biller-code', component: BillerCode, name:'biller-biller-code'},
    { path: '/biller/biller-setup', component: Biller, name:'biller-biller-setup'},
    { path:'/report/payroll',component:payrollSummery, name:'report-payroll'},
    { path: '/bill-updates', component:BillUpdates, name: 'bill-updates'},
    { path: '/financial-year', component:FinancialYear, name: 'financial-year'},
    { path: '/arrear-bill', component:ArrearBillGenerate, name: 'arrear-bill'},
    { path: '/arrear-bill-settlement', component: ArrearBillSettlement, name: 'arrear-bill-settlement' },
    { path: '/other-allowance', component: OtherAllowance, name: 'other-allowance' }
];

export default routes;
