import Dashboard from '../components/audit/Dashboard';
import GovernmentAuditDetails from '../components/audit/government-audit/GovernmentAuditDetails';
import GovernmentAuditApprove from '../components/audit/government-audit/GovernmentAuditApprove';
import InternalAuditDetails from '../components/audit/internal-audit/InternalAuditDetails';
import InternalAuditDetailsApprove from '../components/audit/internal-audit/InternalAuditDetailsApprove';

const data = [
    {path: '/', component: Dashboard},
    {path: '/government-audit-details', component: GovernmentAuditDetails},
    {path: '/government-audit-approve', component: GovernmentAuditApprove},
    {path: '/internal-audit-details', component: InternalAuditDetails},
    {path: '/internal-audit-details-approve', component: InternalAuditDetailsApprove}
];

export default data;
