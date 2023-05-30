import Dashboard from '../components/admin/Dashboard.vue';
import ApprovalWorkflow from '../components/admin/ApprovalWorkflow';
import CreateUser from '../components/admin/system-admin/CreateUser';
import UpdateUser from '../components/admin/system-admin/UpdateUser';
import SearchUser from '../components/admin/system-admin/SearchUser';
// import CreateUserByEmployee from '../components/admin/system-admin/CreateUserByEmployee';
import UserIpAssign from '../components/admin/system-admin/UserIpAssign';
import  Division from '../components/admin/employee-position/Division';
import  Department  from '../components/admin/employee-position/Department';
import  Section  from '../components/admin/employee-position/Section';
import  Designation  from '../components/admin/employee-position/Designation';
import  DepartmentDesignation  from '../components/admin/employee-position/DepartmentDesignation';
import  LDivision  from '../components/admin/location-setup/Division';
import  LDistrict  from '../components/admin/location-setup/District';
import  Thana  from '../components/admin/location-setup/Thana';
import  ExamBody  from '../components/admin/exam-setup/ExamBody';
import  ExamResult  from '../components/admin/exam-setup/ExamResult';
import  ExamInfo  from '../components/admin/exam-setup/ExamInfo';

import  LeaveTypeInfo  from '../components/admin/leave-setup/TypeInfo';
import  LeaveWorkDay  from '../components/admin/leave-setup/WorkDay';
import  LeaveHoliday  from '../components/admin/leave-setup/Holiday';

import  SalaryHead  from '../components/admin/salary-setup/HeadSetup';
import  EmployeeSalary  from '../components/admin/salary-setup/EmployeeSalary';

import  Bank  from '../components/admin/general/Bank';
import  Branch  from '../components/admin/general/Branch';
import  RoleMenuMap from '../components/admin/system-admin/RoleMenuMap';
import  Report from '../components/admin/system-admin/Report';
import Modules from '../components/admin/system-admin/Modules'
import Menus from '../components/admin/system-admin/Menus'
import SubMenus from '../components/admin/system-admin/SubMenus'
import  ResultTypeEntry from '../components/admin/system-admin/ResultTypeEntry';
import  ExamMapping from '../components/admin/exam-setup/ExamMapping';
import  ExamBodyMapping from '../components/admin/exam-setup/ExamBodyMapping';
import  ExamBodyStore from '../components/admin/exam-setup/ExamBodyStore';
import  InstituteEntry from '../components/admin/exam-setup/InstituteEntry';
import  SubjectEntry from '../components/admin/exam-setup/SubjectEntry';


//News component
import  CreateNews  from '../components/admin/news/CreateNews.vue';

const data = [
    { path: '/', component: Dashboard},
    // { path: '/create-user/:id', component: CreateUser, props: true},
    { path: '/update-user/:id', component: UpdateUser, props: true,name:'update-user'},
    { path: '/search-user', component: SearchUser,name:'search-user'},
    { path: '/create-user', component: CreateUser,name:'create-user'},
    { path: '/modules', component: Modules,name:'modules'},
    { path: '/menus', component: Menus,name:'menus'},
    { path: '/sub-menus', component: SubMenus,name:'sub-menus'},
    { path: '/user-ip-assign/:id', component: UserIpAssign,props:true,name:'user-ip-assign'},
    { path: '/employee-position/division', component: Division,  name:'employee-position-division'},
    { path: '/employee-position/department', component: Department, name:'employee-position-department'},
    { path: '/employee-position/section', component: Section, name:'employee-position-section'},
    { path: '/employee-position/designation', component: Designation, name:'employee-position-designation'},
    { path: '/employee-position/department-designation', component: DepartmentDesignation,name:'employee-position-department-designation'},
    { path: '/location-setup/division', component: LDivision, name:'location-setup-division'},
    { path: '/location-setup/district', component: LDistrict, name:'location-setup-district'},
    { path: '/location-setup/thana', component: Thana, name:'location-setup-thana'},
    { path: '/exam-setup/exam-body', component: ExamBody, name:'exam-setup-exam-body'},
    { path: '/exam-setup/exam-result', component: ExamResult, name:'exam-setup-exam-result' },
    { path: '/exam-setup/exam-info', component: ExamInfo, name:'exam-setup-exam-info'},
    { path: '/leave-setup/type-info', component: LeaveTypeInfo, name:'leave-setup-type-info'},
    { path: '/leave-setup/work-day', component: LeaveWorkDay, name: 'leave-setup-work-day'},
    { path: '/leave-setup/holiday', component: LeaveHoliday, name:'leave-setup-holiday'},
    { path: '/salary-setup/head-setup', component: SalaryHead, name:'salary-setup-head-setup'},
    { path: '/salary-setup/employee-salary', component: EmployeeSalary, name:'salary-setup-employee-salary'},
    { path: '/result-type-entry', component: ResultTypeEntry, name:'result-type-entry'},
    { path: '/general/bank', component: Bank, name:'general-bank'},
    { path: '/general/branch', component: Branch, name:'general-branch'},
    { path: '/role-menu-map',component:RoleMenuMap, name: 'role-menu-map'},
    { path: '/report',component:Report, name:'report'},
    { path: '/news', component: CreateNews, name:'admin-news'},
    { path: '/exam-mapping', component: ExamMapping, name:'exam-mapping'},
    { path: '/exam-body-mapping', component: ExamBodyMapping, name:'exam-body-mapping'},
    { path: '/approval-workflow', component: ApprovalWorkflow, name:'approval-workflow'},
    { path: '/exam-body-store', component: ExamBodyStore, name:'exam-body-store'},
    { path: '/institute-entry', component: InstituteEntry, name:'institute-entry'},
    { path: '/subject-entry', component: SubjectEntry, name:'subject-entry'}
];

export default data;
