import Dashboard from '../components/marine/Dashboard';
import Incident from '../components/marine/Incident';
import Vhflog from '../components/marine/Vhflog';
import FreshWaterRequest from '../components/marine/FreshWaterRequest';
import FreshWaterStatus from '../components/marine/FreshWaterStatus';
import DocMasterView from '../components/marine/DocMasterView';
import RequestApproval from '../components/marine/RequestApproval';
import MooringInfoEntry from '../components/marine/MooringInfoEntry';
import MooringInfoApproval from '../components/marine/MooringInfoApproval';

const routes = [
    { path: '/', component: Dashboard},
    { path: '/incident', component: Incident},
    { path: '/vhflog', component: Vhflog},
    { path: '/fresh-water-request', component: FreshWaterRequest},
    { path: '/fresh-water-status', component: FreshWaterStatus},
    { path: '/doc-master-view', component: DocMasterView},
    { path: '/request-approval', component: RequestApproval},
    { path: '/mooring-info-entry', component: MooringInfoEntry},
    { path: '/mooring-info-approval', component: MooringInfoApproval},
];

export default routes;
