import Dashboard from '../components/approval-service/Dashboard';

import ApproveCPF from '../components/approval-service/ApproveCPF';
import ApproveCPFDtl from '../components/approval-service/ApproveCPFDtl';
import ApproveLeave from '../components/approval-service/ApproveLeave';
import LeaveDetails from '../components/approval-service/LeaveDetails';
import PensionClearance from '../components/approval-service/PensionClearance';
import DepartmentalApproval from '../components/approval-service/DepartmentalApproval';
import AuditApproval from '../components/approval-service/AuditApproval';

const data = [
    { path: '/', component: Dashboard},
    {path: '/approve-cpf', component: ApproveCPF,name:'approve-cpf'},
    {path: '/approve-cpfdtl', component: ApproveCPFDtl,name:'approve-cpfdtl'},
    {path: '/approve-leave', component: ApproveLeave,name:'approve-leave'},
    {path: '/leave-details', component: LeaveDetails,name:'leave-details'},
    { path: '/pension-clearance', component: PensionClearance,name:'pension-clearance'},
    { path: '/departmental-approval', component: DepartmentalApproval,name:'departmental-approval'},
    { path: '/audit-approval', component: AuditApproval,name:'audit-approval'},

];
export default data;
