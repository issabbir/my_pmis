import Dashboard from '../components/purchase/Dashboard';
import PurchaseContractOrder from '../components/purchase/PurchaseContractOrder';
import POContractApproval from '../components/purchase/POContractApproval';
import SupplierEntry from '../components/purchase/SupplierEntry';


const data = [
    { path: '/', component: Dashboard},
     { path: '/purchase-order', component: PurchaseContractOrder},
     { path: '/purchase-order-approve', component: POContractApproval},
      { path: '/supplier-entry', component: SupplierEntry},
];

export default data;
