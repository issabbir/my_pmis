import Dashboard from '../components/pension/Dashboard';
import PrlApplication from '../components/pension/PrlApplication';
import PrlApplicationApproval from '../components/pension/PrlApplicationApproval';
import PensionApplication from '../components/pension/PensionApplication';
import AllPensionApplication from '../components/pension/AllPensionApplication';
import PensionApplicationProcess from '../components/pension/PensionApplicationProcess';
import PensionSettlement from '../components/pension/PensionSettlement';
import MonthlyPensionProcess from '../components/pension/MonthlyPensionProcess';
import PensionBonusProcess from '../components/pension/PensionBonusProcess';
import SearchEmployeePensionBonuses from '../components/pension/SearchEmployeePensionBonuses';
import PrlSearchEmployee from '../components/pension/PrlSearchEmployee';
import PrlPersonalRecord from '../components/pension/PrlPersonalRecord';
import PrlEmployeeNotice from '../components/pension/PrlEmployeeNotice';
import PensionReport from '../components/report/pension/PensionReport';
import PensionHead from '../components/pension/PensionHead';
import PrlNotification from '../components/pension/PrlNotification';
import PrlLeaveEncashment from '../components/pension/PrlLeaveEncashment';
import PrlEncashmentApproval from '../components/pension/PrlEncashmentApproval';
import Clearance from '../components/pension/Clearance';
import NOCDepartmentSetup from '../components/pension/NOCDepartmentSetup';
import DeathRegistration from "../components/pension/DeathRegistration";
import DeathRegistrationApproval from "../components/pension/DeathRegistrationApproval";
import PensionIncrementProcess from "../components/pension/PensionIncrementProcess";
import PensionAttendance from "../components/pension/PensionAttendance";
import Nominee from "../components/pension/Nominee";
import NomineePensionApplication from "../components/pension/NomineePensionApplication";
import PensionContinuationApplication from "../components/pension/PensionContinuationApplication";
import EmployeeModification from "../components/pension/EmployeeModification";

const data = [
    {path: '/', component: Dashboard},
    {path:'/prl-application', component:PrlApplication, name:'prl-application'},
    {path:'/prl-application-approval', component:PrlApplicationApproval, name:'prl-application-approval'},
    {path:'/pension-application', component:PensionApplication, name:'pension-application'},
    {path:'/pension-application-status', component:AllPensionApplication, name:'pension-application-status'},
    {path:'/pension-app-process', component:PensionApplicationProcess, name:'pension-app-process'},
    {path:'/pension-settlement', component:PensionSettlement, name:'pension-settlement'},
    {path:'/monthly-pension-process', component:MonthlyPensionProcess, name:'monthly-pension-process'},
    {path:'/pension-bonus-process', component:PensionBonusProcess, name:'pension-bonus-process'},
    {path:'/pension-bonuses', component:SearchEmployeePensionBonuses, name:'pension-bonuses'},
    {path:'/prl-search-employee', component:PrlSearchEmployee, name:'prl-search-employee'},
    {path:'/prl-personal-record/:emp_id', component:PrlPersonalRecord, props: true, name:'prl-personal-record'},
    {path:'/prl-employee-notice', component:PrlEmployeeNotice, name:'prl-employee-notice'},
    {path:'/pension-report', component:PensionReport, name:'pension-report'},
    {path:'/pension-head', component:PensionHead, name:'pension-head'},
    {path:'/prl-notification', component:PrlNotification, name:'prl-notification'},
    {path:'/prl-leave-encashment', component:PrlLeaveEncashment, name:'prl-leave-encashment'},
    {path:'/prl-encashment-approval', component:PrlEncashmentApproval, name:'prl-encashment-approval'},
    {path:'/clearance', component:Clearance, name:'clearance'},
    {path:'/noc-dept-set', component:NOCDepartmentSetup, name:'noc-dept-set'},
    {path:'/death-registration', component:DeathRegistration, name:'death-registration'},
    {path:'/death-registration-approval', component:DeathRegistrationApproval, name:'death-registration-approval'},
    {path:'/pension-increment-process', component:PensionIncrementProcess, name:'pension-increment-process'},
    {path:'/pension-attendance', component:PensionAttendance, name:'pension-attendance'},
    {path:'/pension-nominee', component:Nominee, name:'pension-nominee'},
    {path:'/nominee-pension-application', component:NomineePensionApplication, name:'nominee-pension-application'},
    {path:'/pension-recontinue', component:PensionContinuationApplication, name:'pension-recontinue'},
    {path:'/employee-modification', component:EmployeeModification, name:'employee-modification'},
];

export default data;
