
import Dashboard from '../components/fixed_asset/Dashboard.vue';

// fixed asset
import AssetAddition from '../components/accounts/fixed-asset/AssetAddition';
import AssetRetirement from '../components/accounts/fixed-asset/AssetRetirement';

//
// import ArrivalInformation from '../components/accounts/bill-receivable/ArrivalInformation';
// import BillProcess from '../components/accounts/bill-receivable/BillProcess';
// import ChalanEntry from '../components/accounts/bill-receivable/ChalanEntry';
// import CtmsBilling from '../components/accounts/bill-receivable/CtmsBilling';
// import IssueTracking from '../components/accounts/bill-receivable/IssueTracking';
// import JettyInfo from '../components/accounts/bill-receivable/JettyInfo';
// import MiscellaniusBilling from '../components/accounts/bill-receivable/MiscellaniusBilling';
// import PilotageCertificate from '../components/accounts/bill-receivable/PilotageCertificate';

// import BillApproval from '../components/accounts/bill-receivable/BillApproval';

// import VesselRegistration from '../components/accounts/bill-receivable/VesselRegistration';
import CustomerEntry from '../components/accounts/bill-receivable/CustomerEntry';
import Payable from '../components/accounts/accounts-payable/Payable';
import PaymentVoucher from '../components/accounts/accounts-payable/PaymentVoucher';
import SupplierEntry from '../components/accounts/accounts-payable/SupplierEntry';
import PaymentOverview from '../components/accounts/accounts-payable/PaymentOverview';

//Shabbir cash management

import FdrDetails from '../components/accounts/cash-management/FdrDetails';
import FdrDetailsEntry from '../components/accounts/cash-management/FdrDetailsEntry';
import StdDetailsEntry from '../components/accounts/cash-management/StdDetailsEntry';
 import StdDetails from '../components/accounts/cash-management/StdDetails';
import ChallanEntryCash from '../components/accounts/cash-management/ChallanEntry';
import ChallanEntryCashSearch from '../components/accounts/cash-management/ChallanEntrySearch';
import CashClear from '../components/accounts/cash-management/CashClear';
import PaymentIncomeTax from '../components/accounts/cash-management/PaymentIncomeTax';
import PaymentIncomeTaxSearch from '../components/accounts/cash-management/PaymentIncomeTaxSearch';
import CashManagementPayable from '../components/accounts/cash-management/Payable';
import BankTransfer from '../components/accounts/cash-management/BankTransfer';

//general ledger
import ChartOfAccounts from '../components/accounts/general-ledger/ChartOfAccounts';
import Journals from '../components/accounts/general-ledger/Journals.vue';
import Period from '../components/accounts/general-ledger/Period.vue';
import FinancialCalendar from '../components/accounts/general-ledger/FinancialCalendar';

const data = [
    { path: '/', component: Dashboard},
    {path: '/asset-addition', component: AssetAddition},
    {path: '/asset-retirement', component: AssetRetirement},

    // {path: '/arrival-information', component: ArrivalInformation},
    // {path: '/bill-process', component: BillProcess},
    // {path: '/chalan-entry', component: ChalanEntry},
    // {path: '/ctms-billing', component: CtmsBilling},
    // {path: '/issue-tracking', component: IssueTracking},
    // {path: '/jetty-information', component: JettyInfo},
    // {path: '/miscellaneous-billing', component: MiscellaniusBilling},
    // {path: '/pilotage-certificate', component: PilotageCertificate},
    // {path: '/customer-entry', component: CustomerEntry},
    // {path: '/bill-approval', component: BillApproval},
    // {path: '/vessel-registration', component: VesselRegistration},
    {path: '/customer-entry', component: CustomerEntry},
    {path: '/payable', component: Payable},
    {path: '/payment-voucher', component: PaymentVoucher},
    {path: '/supplier-entry', component: SupplierEntry},
    {path: '/payment-overview', component: PaymentOverview},
    //General ledger
    {path: '/chartof-accounts', component: ChartOfAccounts},
    { path: '/fdr-details', component: FdrDetails },
    { path: '/fdr-details-data', component: FdrDetailsEntry },
     { path: '/std-details', component: StdDetails },
    { path: '/std-details-data', component: StdDetailsEntry },
    { path: '/challan-entry-cash', component: ChallanEntryCash },
    { path: '/challan-entry-search', component: ChallanEntryCashSearch },
    { path: '/cash-clear', component: CashClear },
    {path: '/payment-income-tax', component: PaymentIncomeTax},
    {path: '/payment-income-tax-search', component: PaymentIncomeTaxSearch},
    {path: '/cashmanagement-payble', component: CashManagementPayable},
    {path: '/bank-transfer', component: BankTransfer},
    {path: '/journals', component: Journals},
    {path: '/period', component: Period},
    {path: '/financial-calendar', component: FinancialCalendar}

];

export default data;
