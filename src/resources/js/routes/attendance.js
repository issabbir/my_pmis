import Employee from '../components/attendance/Employee';
import AttendanceEntry from '../components/attendance/AttendanceEntry';
import AttendanceApproval from '../components/attendance/AttendanceApproval';
import Report from '../components/report/attendance/AttendanceSummery';
import AttendanceDetails from '../components/leave/AttendanceDetails';
import AttendanceUpload from '../components/attendance/AttendanceUpload';
import AttendanceProcess from '../components/attendance/AttendanceProcess';
const routes = [
    { path: '/attendance/employee', component: Employee,name:'attendance-employee'},
    { path: '/attendance/entry', component: AttendanceEntry,name:'attendance-entry'},
    { path: '/attendance/approval', component: AttendanceApproval,name:'attendance-approval'},
    { path: '/reports', component: Report,name:'attendance-reports'},
	{ path: '/attendance-upload', component: AttendanceUpload,name:'attendance-upload'},
    { path: '/attendance-process', component: AttendanceProcess,name:'attendance-process'},
	{ path: '/attendance-details/:empId/:fromdate/:todate/:type', component: AttendanceDetails, props: true,name:'attendance-details'}];

export default routes;
