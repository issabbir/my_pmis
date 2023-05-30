import Dashboard from '../components/traffic/Dashboard';

import IgmEntry from '../components/traffic/IgmEntry';
import CartTicket from '../components/traffic/CartTicket';
import Sdo from '../components/traffic/Sdo';



const routes = [
    { path: '/', component: Dashboard},
    { path: '/igm-entry', component: IgmEntry},
    { path: '/cart-ticket', component: CartTicket},
    { path: '/sdo', component: Sdo},

];

export default routes;
