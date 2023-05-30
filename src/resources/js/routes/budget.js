import Dashboard from '../components/budget/Dashboard';
import DeptBasedBudgetSetup  from '../components/budget/DeptBasedBudgetSetup';
import SetupBudgetaryControl from '../components/budget/SetupBudgetaryControl';
const data = [
    { path: '/', component: Dashboard},
     { path: '/dept-based-budget-setup', component: DeptBasedBudgetSetup},
      { path: '/budgetary-control-setup', component: SetupBudgetaryControl}
];

export default data;
