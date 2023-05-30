import Dashboard from '../components/overtime/Dashboard';
import OvertimeApproval from '../components/overtime/overtime-approval/OvertimeApproval';
import Overtime from '../components/overtime/overtime-register/OvertimeRegister';
import groupOtBooking from '../components/overtime/overtime-group-register/OvertimeGroupRegister';
import OvertimeProcess from '../components/overtime/overtime-process/OvertimeProcess';
import OvertimeProcessApproval from '../components/overtime/ovetime-process-approval/OvertimeProcessApproval';
import RosterMonthMst from '../components/overtime/setup/RosterMonthMst';
import overtimeOtRule from '../components/overtime/setup/OvertimeOtRule';

import OtMonthsDetails from '../components/overtime/setup/OtMonthsDetails';
import EmpOtRule from '../components/overtime/setup/EmpOtRule';
import OTRosterDetails from '../components/overtime/setup/RosterDetails';
import OtRosterGroup from '../components/overtime/setup/OtRosterGroup';
import OtRosterGroupApproval from '../components/overtime/setup/OtRosterGroupApproval';
import SearchRosterMonth from '../components/overtime/setup/SearchRosterMonth';
import ActualOvertimeSetup from '../components/overtime/ActualOvertimeSetup';
import EmpWiseActualOvertimeSetup from '../components/overtime/EmpWiseActualOvertimeSetup';
import OvertimeProcessApprovalReport from '../components/overtime/ovetime-process-approval/OvertimeProcessApprovalReport';
import IrregularOvertime from '../components/overtime/IrregularOvertime';
import UnregOtApproval from '../components/overtime/unreg-ot-approval/UnregOtApproval';
import OvertimeRegisterDetail from '../components/overtime/overtime-register/OvertimeRegisterDetail';
import OtDisbursement from '../components/overtime/OtDisbursement';
import OvertimeReport from '../components/report/overtime/Automation';

const routes = [
    { path: '/', component: Dashboard},
    { path: '/overtime', component: Overtime,name:'overtime'},
    { path: '/group-ot-booking', component: groupOtBooking,name:'group-ot-booking'},
    { path: '/overtime-ot-rule', component: overtimeOtRule,name:'overtime-ot-rule'},
    { path: '/overtime-emp-ot-rule', component: EmpOtRule,name:'overtime-emp-ot-rule'},
    { path: '/overtime-process', component: OvertimeProcess,name:'overtime-process'},
    { path: '/overtime-process-approval', component: OvertimeProcessApproval,name:'overtime-process-approval'},
    { path: '/overtime-process-approval/:dep/:sec/:fromdate/:todate/:dptName/:monthName', component: OvertimeProcessApproval, props: true,name:'overtime-process-approval'},
    { path: '/overtime-approval', component: OvertimeApproval,name:'overtime-approval'},
    { path: '/roster-month-setup', component: RosterMonthMst,name:'search-roster-month'},
    { path: '/ot-months-details', component: OtMonthsDetails,name:'ot-months-details'},
    { path: '/roster-details', component: OTRosterDetails,name:'roster-details'},
    { path: '/ot-roster-group', component: OtRosterGroup,name:'ot-roster-group'},
    { path: '/ot-roster-group-appv', component: OtRosterGroupApproval,name:'ot-roster-group-appv'},
    { path: '/search-roster-month', component: SearchRosterMonth,name:'search-roster-month'},
    { path: '/over-time-actual', component: ActualOvertimeSetup,name:'over-time-actual'},
    { path: '/emp-wise-actual-time/:id', component: EmpWiseActualOvertimeSetup,props: true,name:'over-time-actual'},
    { path: '/overtime-process-approval-report', component: OvertimeProcessApprovalReport,name:'overtime-process-approval-report'},
    { path: '/irregular-Overtime', component: IrregularOvertime,name:'irregular-Overtime'},
    { path: '/un-reg-approval', component: UnregOtApproval,name:'un-reg-approval'},
    { path: '/ot-disbursement', component: OtDisbursement,name:'ot-disbursement'},
    { path: '/overtime/:id', component: OvertimeRegisterDetail,props: true,name:'overtime'},
    { path: '/reports', component: OvertimeReport,name:'overtime-reports'}
];

export default routes;

