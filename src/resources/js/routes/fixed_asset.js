
import Dashboard from '../components/fixed_asset/Dashboard.vue';

// fixed asset
import AssetAddition from '../components/accounts/fixed-asset/AssetAddition';
import AssetRetirement from '../components/accounts/fixed-asset/AssetRetirement';



const data = [
    { path: '/', component: Dashboard},
    {path: '/asset-addition', component: AssetAddition},
    {path: '/asset-retirement', component: AssetRetirement}
    

];

export default data;
