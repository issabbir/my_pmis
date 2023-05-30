import Dashboard from '../components/hydrography/Dashboard';
//import Request from '../components/hydrography/Request';

import CustomerRequest from '../components/hydrography/CustomerRequest';
import Invoice from '../components/hydrography/Invoice';
import Invoice2 from '../components/hydrography/InvoiceAdReqDetails';



import RequestListAdmin from '../components/hydrography/RequestListAdmin';
import RequestListAssignAdmin from '../components/hydrography/RequestListAssignAdmin';
import ProductSettings from '../components/hydrography/ProductSettings';

const routes = [
    { path: '/', component: Dashboard},
    //{ path: '/request', component: Request},

    { path: '/request', component: CustomerRequest},
    { path: '/invoice', component: Invoice},
    { path: '/invoice-admin-Req-Details', component: Invoice2},



    { path: '/request-list-admin', component: RequestListAdmin},
    { path: '/request-list-assign-admin', component: RequestListAssignAdmin},
    { path: '/product-settings', component: ProductSettings}
];

export default routes;
