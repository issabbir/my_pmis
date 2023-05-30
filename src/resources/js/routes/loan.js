
import ApprovalSetup from '../components/loan/setup/ApprovalSetup';
import LoanApplications from '../components/loan/LoanApplications';
import LoanGuarantor from '../components/loan/LoanGuarantor';
import LoanApproval from '../components/loan/LoanApproval';
import LoanPayment from '../components/loan/LoanPayment';
import LoanPayInstruction from '../components/loan/LoanPayInstruction';
import LoanSummary from '../components/loan/LoanSummary';
import LoanReport from '../components/report/loan/LoanReport';
import LoanDisbursement from '../components/loan/LoanDisbursement';
import ExistLoanApplications from '../components/loan/ExistLoanApplications';
const routes = [
   { path: '/approval-setup', component:ApprovalSetup, name: 'approval-setup'},
   { path: '/loan-guarantor', component:LoanGuarantor, name: 'loan-guarantor'},
   { path: '/loan-applications', component:LoanApplications, name: 'loan-applications'},
   { path: '/loan-approval', component:LoanApproval, name: 'loan-approval'},
   { path: '/loan-payment', component:LoanPayment, name: 'loan-payment'},
   { path: '/loan-pay-instruction', component:LoanPayInstruction, name: 'loan-pay-instruction'},
   { path: '/loan-applications', component:LoanApplications, name: 'loan-applications'},
    { path: '/loan-summary', component:LoanSummary, name: 'loan-summary'},
    { path: '/loan-reports', component:LoanReport, name: 'loan-reports'},
    { path: '/loan-disbursement', component:LoanDisbursement, name: 'loan-disbursement'},
    { path: '/loan-edit', component:ExistLoanApplications, name: 'loan-edit'}

];

export default routes;
