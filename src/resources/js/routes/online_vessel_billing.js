
import Dashboard from '../components/online_vessel_billing/Dashboard.vue';

import ArrivalInformation from '../components/online_vessel_billing/bill-receivable/ArrivalInformation';
import BillProcess from '../components/online_vessel_billing/bill-receivable/BillProcess';
import ChalanEntry from '../components/online_vessel_billing/bill-receivable/ChalanEntry';
import CtmsBilling from '../components/online_vessel_billing/bill-receivable/CtmsBilling';
import IssueTracking from '../components/online_vessel_billing/bill-receivable/IssueTracking';
import JettyInfo from '../components/online_vessel_billing/bill-receivable/JettyInfo';
import MiscellaniusBilling from '../components/online_vessel_billing/bill-receivable/MiscellaniusBilling';
import PilotageCertificate from '../components/online_vessel_billing/bill-receivable/PilotageCertificate';
import CustomerEntry from '../components/online_vessel_billing/bill-receivable/CustomerEntry';
import BillApproval from '../components/online_vessel_billing/bill-receivable/BillApproval';
import VesselRegistration from '../components/online_vessel_billing/bill-receivable/VesselRegistration';



const data = [
    { path: '/', component: Dashboard},
    {path: '/arrival-information', component: ArrivalInformation},
    {path: '/bill-process', component: BillProcess},
    {path: '/chalan-entry', component: ChalanEntry},
    {path: '/ctms-billing', component: CtmsBilling},
    {path: '/issue-tracking', component: IssueTracking},
    {path: '/jetty-information', component: JettyInfo},
    {path: '/miscellaneous-billing', component: MiscellaniusBilling},
    {path: '/pilotage-certificate', component: PilotageCertificate},
    {path: '/customer-entry', component: CustomerEntry},
    {path: '/bill-approval', component: BillApproval},
    {path: '/vessel-registration', component: VesselRegistration}
    

];

export default data;
