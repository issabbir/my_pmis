import dashboard from '../components/application-service/dashboard';
import ApplyGpfCpf from '../components/application-service/ApplyGpfCpf';
import ApplyLeave from '../components/application-service/ApplyLeave';
import ApplyWithdraw from '../components/application-service/ApplyWithdraw';
import PensionApplication from '../components/application-service/PensionApplication';

const data= [

    { path: '/', component: dashboard},
    { path: '/apply-gpfcpf', component: ApplyGpfCpf,name:'apply-gpfcpf'},
    { path: '/apply-leave', component: ApplyLeave,name:'apply-leave'},
    { path: '/apply-withdraw', component: ApplyWithdraw,name:'apply-withdraw'},
    { path: '/pension-application', component: PensionApplication,name:'pension-application'},
 ];

export default data;


