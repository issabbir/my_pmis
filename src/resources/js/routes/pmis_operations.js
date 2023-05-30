//hossain

import DeathRegistration from "../components/pension/DeathRegistration";
import increment from '../components/pmis/operations/Increment';
import promotion from '../components/pmis/operations/Promotion';
import punishment from '../components/pmis/operations/Punishment';
import transfer from '../components/pmis/operations/Transfer';
import tour from '../components/pmis/operations/Tour';
import PunishmentApproval from "../components/pmis/operations/approval/PunishmentApproval";
import EmployeeStatus from "../components/pmis/operations/EmployeeStatus";
import IncrementProcess from "../components/pmis/operations/IncrementProcess";
const data= [
    //hossain
    {path:'/death-registration', component:DeathRegistration, name:'death-registration'},
    { path: '/increment', component: increment, name:'increment'},
    { path: '/promotion', component: promotion, name:'promotion'},
    { path: '/punishment', component: punishment, name:'punishment'},
    { path: '/transfer', component:transfer, name:'transfer'},
    { path: '/tour', component: tour, name:'tour'},
    { path: '/employee-status', component: EmployeeStatus, name: 'employee-status'},
    { path: '/increment-process', component: IncrementProcess, name: 'increment-process'},
    { path: '/approval/punishment', component: PunishmentApproval, name:'punishment-approval'}
];

export default data;


