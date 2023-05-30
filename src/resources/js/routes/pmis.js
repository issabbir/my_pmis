import dashboard from '../components/pmis/Dashboard';
import BasicInfo from '../components/pmis/employee/BasicInfo';
import Contacts from '../components/pmis/employee/Contacts';
import Address from '../components/pmis/employee/Address';
import Experience from '../components/pmis/employee/Experience';
import TaxBank from '../components/pmis/employee/TaxBank';
import Service from '../components/pmis/employee/Service';
import Promotion from '../components/pmis/employee/Promotion';
import Increment from '../components/pmis/employee/Increment';
import Transfer from '../components/pmis/employee/Transfer';
import PmisPunishment from '../components/pmis/employee/Punishment';
import PmisTour from '../components/pmis/employee/Tour';
import OtherQualification from '../components/pmis/employee/OtherQualification';
import SearchEmployee from '../components/pmis/SearchEmployee'
import SearchEmployeeColection from '../components/pmis/SearchEmployeeColection';
import EmployeeDetails from '../components/pmis/EmployeeDetails';
import Training from '../components/pmis/employee/Training';
import Accommodation from "../components/pmis/employee/Accommodation";
import Nominee from '../components/pmis/employee/Nominee';
import Family from '../components/pmis/employee/Family';
import PfLoan from '../components/pmis/employee/PfLoan';
import Academic from '../components/pmis/employee/Academic';
import ProfCert from '../components/pmis/employee/ProfCert';
import identification from '../components/pmis/employee/Identification';
import lateAttendance from '../components/pmis/LateAttendance';
import officerList from '../components/pmis/OfficerList';
import chargeEntry from '../components/pmis/ChargeEntry';
import basicInfoCollection from '../components/pmis/BasicInfoCollection';
import Notification from "../components/pmis/Notification";
import searchDeputationEmployee from '../components/pmis/SearchDeputationEmployee';
import deputationBasicInfo from '../components/pmis/deputation-employee/BasicInfo';
import deputationContacts from '../components/pmis/deputation-employee/Contacts';
import PrlSearchEmployee from '../components/pmis/prl/PrlSearchEmployee.vue';
import PrlEmployeeNotice from '../components/pmis/prl/PrlEmployeeNotice.vue';
import PrlPersonalRecord from '../components/pmis/prl/PrlPersonalRecord.vue'
import GpfSubscription from '../components/pmis/employee/GpfSubscription';
import Other from '../components/pmis/employee/Others';
import employeeReport from '../components/report/employee/EmployeeSummery';
import EmployeeApproval from "../components/pmis/EmployeeApproval";
import NomineeApproval from "../components/pmis/NomineeApproval";
import InChargeApproval from "../components/pmis/InChargeApproval";
import AcademicApproval from "../components/pmis/AcademicApproval";
import TourApproval from "../components/pmis/TourApproval";
import Attachments from "../components/pmis/employee/Attachments";
import NewRecruit from "../components/pmis/NewRecruit";
import ContactApproval from "../components/pmis/approval/ContactApproval";
import FamilyApproval from "../components/pmis/approval/FamilyApproval";
import GeneralApproval from "../components/pmis/GeneralApproval";
import AddressApproval from "../components/pmis/approval/AddressApproval";
import Profile from "../components/pmis/Profile";
import TraningApproval from "../components/pmis/TraningApproval";
const data= [

    { path: '/', component: dashboard},
    { path: '/employee/basic-info', component: BasicInfo, name:'employee-basic-info'},
    { path: '/employee/basic-info/:id', component: BasicInfo,  props: true,name:'employee-basic-info'},
    { path: '/employee/contacts', component: Contacts,name:'employee-basic-info'},
    { path: '/employee/contacts/:id', component: Contacts,  props: true,name:'employee-basic-info'},
    { path: '/employee/identification', component: identification,name:'employee-basic-info'},
    { path: '/employee/identification/:id', component: identification,  props: true,name:'employee-basic-info'},
    { path: '/late-attendance', component: lateAttendance,name:'late-attendance'},
    { path: '/late-attendance/:id', component: lateAttendance,  props: true,name:'late-attendance'},
    { path: '/officer-list', component: officerList,name:'officer-list'},
    { path: '/officer-list/:id', component: officerList,  props: true,name:'officer-list'},
    { path: '/employee/address', component: Address,name:'employee-basic-info'},
    { path: '/employee/address/:id', component: Address,  props: true,name:'employee-basic-info'},
    { path: '/employee/attachments', component: Attachments,name:'new-attachment'},
    { path: '/employee/attachments/:id', component: Attachments,  props: true,name:'employee-attachment'},
    { path: '/employee/experience', component: Experience,name:'employee-basic-info'},
    { path: '/employee/experience/:id', component: Experience,  props: true,name:'employee-basic-info'},
    { path: '/employee/tour', component: PmisTour,name:'employee-basic-info'},
    { path: '/employee/tour/:id', component: PmisTour,  props: true,name:'employee-basic-info'},
    { path: '/employee/tax-bank', component: TaxBank,name:'employee-basic-info'},
    { path: '/employee/tax-bank/:id', component: TaxBank,  props: true,name:'employee-basic-info'},
    { path: '/employee/service', component: Service,name:'employee-basic-info'},
    { path: '/employee/service/:id', component: Service,  props: true,name:'employee-basic-info'},
    { path: '/employee/promotion', component: Promotion,name:'employee-basic-info'},
    { path: '/employee/promotion/:id', component: Promotion,  props: true,name:'employee-basic-info'},
    { path: '/employee/increment', component: Increment,name:'employee-basic-info'},
    { path: '/employee/increment/:id', component: Increment,  props: true,name:'employee-basic-info'},
    { path: '/employee/punishment', component: PmisPunishment,name:'employee-basic-info'},
    { path: '/employee/punishment/:id', component: PmisPunishment,  props: true,name:'employee-basic-info'},
    { path: '/employee/transfer', component: Transfer,name:'employee-basic-info'},
    { path: '/employee/transfer/:id', component: Transfer,  props: true,name:'employee-basic-info'},
    { path: '/employee/other-qualification', component: OtherQualification,name:'employee-basic-info'},
    { path: '/employee/other-qualification/:id', component: OtherQualification,  props: true,name:'employee-basic-info'},
    { path: '/search-employee', component: SearchEmployee,name:'search-employee'},
    { path: '/notification/:id', component: Notification,name:'notification', props: true},
    { path: '/search-employee-collection', component: SearchEmployeeColection,name:'search-employee-collection'},
    { path: '/employee-details/:id', component: EmployeeDetails,  props: true,name:'employee-details'},
    { path: '/employee/training', component: Training,name:'employee-basic-info'},
    { path: '/employee/training/:id', component: Training,  props: true,name:'employee-basic-info'},
    { path: '/employee/accommodation', component: Accommodation,name:'employee-basic-info'},
    { path: '/employee/accommodation/:id', component: Accommodation,  props: true,name:'employee-basic-info'},
    { path: '/employee/nominee', component: Nominee,name:'employee-basic-info'},
    { path: '/employee/nominee/:id', component: Nominee,  props: true,name:'employee-basic-info'},
    { path: '/employee/family', component: Family,name:'employee-basic-info'},
    { path: '/employee/family/:id', component: Family,  props: true,name:'employee-basic-info'},
    { path: '/employee/gpf-subscription', component: GpfSubscription,name:'employee-basic-info'},
    { path: '/employee/gpf-subscription/:id', component: GpfSubscription,  props: true,name:'employee-basic-info'},
    { path: '/employee/pf-Loan', component: PfLoan,name:'employee-basic-info'},
    { path: '/employee/pf-Loan/:id', component: PfLoan,  props: true,name:'employee-basic-info'},
    { path: '/employee/academic', component: Academic,name:'employee-basic-info'},
    { path: '/employee/academic/:id', component: Academic,  props: true,name:'employee-basic-info'},
    { path: '/employee/profCert', component: ProfCert,name:'employee-basic-info'},
    { path: '/employee/profCert/:id', component: ProfCert,  props: true,name:'employee-basic-info'},
    { path: '/prl/search-employee', component: PrlSearchEmployee},
    { path: '/prl/employee-notice', component: PrlEmployeeNotice},
    { path: '/prl/prl-personal-record', component: PrlPersonalRecord},
    { path: '/charge-entry', component: chargeEntry,name:'charge-entry'},
    { path: '/basic-info-collection/:id', component: basicInfoCollection,props: true,name:'search-employee-collection'},
    { path:'/employee/other-record', component: Other,name:'employee-basic-info'},
    { path:'/employee/other-record/:id', component: Other,props: true,name:'employee-basic-info'},
    { path:'/report',component:employeeReport, name:'report-employee'},
    { path: '/search-deputation-employee', component: searchDeputationEmployee, name:'search-deputation-employee'},
    { path: '/deputation-employee/basic-info', component: deputationBasicInfo, name:'deputation-employee-basic-info'},
    { path: '/deputation-employee/basic-info/:id', component: deputationBasicInfo,  props: true,name:'edit-deputation-employee-basic-info'},
    { path: '/deputation-employee/contacts', component: deputationContacts,name:'deputation-employee-contact-info'},
    { path: '/deputation-employee/contacts/:id', component: deputationContacts,  props: true,name:'edit-deputation-employee-contact-info'},
    { path: '/employee-approval', component: EmployeeApproval ,name:'employee-approval'},
    { path: '/nominee-approval', component: NomineeApproval ,name:'nominee-approval'},
    { path: '/inCharge-approval', component: InChargeApproval ,name:'inCharge-approval'},
    { path: '/contact-approval', component: ContactApproval ,name:'contact-approval'},
    { path: '/academic-approval', component: AcademicApproval ,name:'academic-approval'},
    { path: '/tour-approval', component: TourApproval ,name:'tour-approval'},
    { path: '/traning-approval', component: TraningApproval ,name:'traning-approval'},
    { path: '/family-approval', component: FamilyApproval ,name:'family-approval'},
    { path: '/address-approval', component: AddressApproval ,name:'address-approval'},
    { path: '/employee/new-recruits', component: NewRecruit ,name:'new-recruit'},
    { path: '/general-approval', component: GeneralApproval ,name:'general-approval'},
    { path: '/employee-profile/:id', component: Profile ,name:'employee-profile', props: true},
];

export default data;


