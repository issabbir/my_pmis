import dashboard from '../components/leave/Dashboard';
import LeaveEntry from '../components/leave/LeaveEntry';
import Holiday from '../components/leave/Holiday';
import HolidayCalendar from '../components/leave/HolidayCalendar';
import Report from '../components/report/leave/LeaveSummery';
import ApproveLeave from '../components/leave/ApproveLeave';
import LeaveSummary from '../components/leave/LeaveSummary';
import ExistingLeaveEntry from '../components/leave/ExistingLeaveEntry';
import TeachersHolidaySetup from '../components/leave/TeachersHolidaySetup';
import AcademicHolidayDuty from '../components/leave/AcademicHolidayDuty';

const routes = [
    { path: '/', component: dashboard },
    { path: '/leave-entry', component: LeaveEntry,name:'leave-entry' },
    { path: '/existing-leave-entry', component: ExistingLeaveEntry,name:'existing-leave-entry' },
    { path: '/holiday-entry', component: Holiday,name:'holiday-entry' },
    { path: '/holiday-calendar', component: HolidayCalendar,name:'holiday-calendar' },
    { path: '/reports', component: Report,name:'leave-reports' },
    { path: '/approve-leave', component: ApproveLeave,name:'approve-leave' },
    { path: '/leave-summary', component: LeaveSummary,name:'leave-summary' },
    { path: '/teachers-holiday-setup', component: TeachersHolidaySetup, name: 'teachers-holiday-setup' },
    { path: '/academic-holiday-duty', component: AcademicHolidayDuty, name: 'academic-holiday-duty' }
];

export default routes;
