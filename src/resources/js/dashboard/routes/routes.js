import DashboardLayout from "../pages/Layout/DashboardLayout.vue";
import Dashboard from "../pages/Dashboard.vue";
import Attendance from "../pages/my-account/Attendance";
import Leave from "../pages/my-account/Leave";
import Loan from "../pages/my-account/Loan";
import Nominee from "../pages/my-account/Nominee";
import MyAddress from "../pages/my-account/MyAddress";
import Payslip from "../pages/my-account/Payslip";
import Profile from "../pages/my-account/Profile";
import Family from "../pages/my-account/Family";
import Contact from "../pages/my-account/Contact";
import Accommodation from "../pages/my-account/Accommodation";
import GPFApplication from "../pages/my-account/application/GPFApplication";
import GPFLoanApplication from "../pages/my-account/application/GPFLoanApplication";
import GPFSettlement from "../pages/my-account/application/GPFSettlement";
import HouseInterchange from "../pages/my-account/application/HouseInterchange";
import Application from "../pages/my-account/application/index";
import Statement from "../pages/my-account/statement/index";
import GPFStatementReport from "../pages/my-account/statement/GPFStatementReport";
import LoanStatementReport from "../pages/my-account/statement/LoanStatementReport";
import IncomeTaxStatementReport from "../pages/my-account/statement/IncomeTaxStatementReport";
const routes = [
    {
        path: "/",
        component: DashboardLayout,
        redirect: "/dashboard",
        name: "Dashboard-layout",
        children: [
            {
                path: "dashboard",
                name: "Dashboard",
                component: Dashboard,
            },
            {
                path: 'profile',
                component: Profile,
                name: 'my-account-profile'
            },
            {
                path: 'accommodation',
                component: Accommodation,
                name: 'my-account-accommodation'
            },
            {
                path: 'family',
                component: Family,
                name: 'my-account-family'
            },
            {
                path: 'nominee',
                component: Nominee,
                name: 'my-account-nominee'
            },
            {
                path: 'attendance',
                component: Attendance,
                name: 'my-account-attendance'
            },
            {
                path: 'leave',
                component: Leave,
                name: 'my-account-leave'
            },
            {
                path: 'loan',
                component: Loan,
                name: 'my-account-loan'
            },
            {
                path: 'payslip',
                component: Payslip,
                name: 'my-account-payslip'
            },
            {
                path: 'contact',
                component: Contact,
                name: 'my-account-contact'
            },
            {
                path: 'my-address',
                component: MyAddress,
                name: 'my-account-address'
            },
            {
                path: 'application',
                component: Application,
                name: 'my-account-application',
                redirect: '/gpf-application',
                children: [
                    {
                        path: 'gpf-application',
                        component: GPFApplication,
                        name: 'my-account-gpf-application'
                    },
                    {
                        path: 'gpf-loan-application',
                        component: GPFLoanApplication,
                        name: 'my-account-gpf-loan-application'
                    },
                    {
                        path: 'gpf-settlement',
                        component: GPFSettlement,
                        name: 'my-account-gpf-settlement'
                    },
                    {
                        path: 'house-interchange',
                        component: HouseInterchange,
                        name: 'my-account-house-interchange'
                    }
                ]
            },
            {
                path: 'statement',
                component: Statement,
                name: 'my-account-statement',
                redirect: '/gpf-statement',
                children: [
                    {
                        path: 'gpf-statement-report',
                        component: GPFStatementReport,
                        name: 'my-account-gpf-statement-report'
                    },
                    {
                        path: 'loan-statement-report',
                        component: LoanStatementReport,
                        name: 'my-account-loan-statement-report'
                    },
                    {
                        path: 'income-tax-statement-report',
                        component: IncomeTaxStatementReport,
                        name: 'my-account-income-tax-statement-report'
                    },
                ]
            }

        ]
    }
];

export default routes;
