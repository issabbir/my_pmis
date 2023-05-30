import PfSettlement from '../components/pmis/provident-fund/PfSettlement';
import pfLoanCalculation from '../components/pmis/provident-fund/PfLoanCalculation';
import pfStatement from '../components/pmis/provident-fund/PfStatement';
import withdrawForm from '../components/pmis/provident-fund/WithdrawForm';
import ExistLoanApplications from '../components/pmis/provident-fund/ExistLoanApplications';
import ApplyPf from '../components/pmis/provident-fund/ApplyPf';
import withdrawFromPrint from '../components/pmis/provident-fund/WithdrawFromPrint';
import PFLoanApplication from '../components/pmis/provident-fund/ApplyGpfCpf';
import PfInterestRate from '../components/pmis/provident-fund/PfInterestRate';
import GPFApplication from '../components/pmis/provident-fund/GPFApplication';
import PFSummary from '../components/pmis/provident-fund/PFSummary';
import LoanApproval from '../components/pmis/provident-fund/LoanApproval';
import report from '../components/report/provident-fund/ProvidentFundSummery'


const data= [
    { path: '/withdraw-application', component: withdrawForm, name:'withdraw-application'},
    { path: '/loan-edit', component: ExistLoanApplications, name:'loan-edit'},
    { path: '/pf-settlement', component: PfSettlement, name:'pf-settlement'},
    { path: '/pf-loan-calculation', component: pfLoanCalculation, name: 'pf-loan-calculation'},
    { path: '/pf-statement', component: pfStatement, name:'pf-statement'},
    { path: '/apply-pf/:id', props: true,component: ApplyPf, name:'apply-pf-id'},
    { path: '/withdraw-print', component: withdrawFromPrint, name:'withdraw-print'},
    { path: '/pf-loan-application', component: PFLoanApplication, name:'pf-loan-application'},
    { path: '/gpf-int-rate-define', component: PfInterestRate, name:'gpf-int-rate-define'},
    { path: '/gpf-application', component: GPFApplication, name:'gpf-application'},
    { path: '/gpf-summary', component: PFSummary, name:'gpf-summary'},
    { path: '/loan-approval', component: LoanApproval, name:'loan-approval'},
    { path: '/apply-pf/', props: true,component: ApplyPf, name:'apply-pf'},
    {path:'/report',component:report, name:'report-provident-fund'}
  ];

export default data;


