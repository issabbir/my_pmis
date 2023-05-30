// Hossain
import Dashboard from '../components/recruitment/dashboard';
import CircularPublication from '../components/recruitment/ApplicationShortlistProcess/CircularPublication';
import PublicationListView from '../components/recruitment/ApplicationShortlistProcess/PublicationListView';
import JobApplication from '../components/recruitment/ApplicationShortlistProcess/JobApplication';
import Registration from '../components/recruitment/ApplicationShortlistProcess/Registration';
import Login from '../components/recruitment/ApplicationShortlistProcess/Login';
import JobCircular from '../components/recruitment/ApplicationShortlistProcess/JobCircular';
import ShortList from '../components/recruitment/ApplicationShortlistProcess/ShortList';
import JobList from '../components/recruitment/ApplicationShortlistProcess/JobList';
import ApplicantProfile from '../components/recruitment/ApplicationShortlistProcess/ApplicantProfile';

//Rokan
import FinalSelection from '../components/recruitment/AcceptanceProcess/FinalSelection';
import TestResult from '../components/recruitment/TestingProcess/TestResult';

// Shabbir
import AdmitCard from '../components/recruitment/TestAllocation/AdmitCard';
import Attendance from '../components/recruitment/TestAllocation/Attendance';
import InterviewBoard from '../components/recruitment/TestAllocation/InterviewBoard';
import Scheduling from '../components/recruitment/TestAllocation/Scheduling';
import InterviewInvitation from '../components/recruitment/TestAllocation/InterviewInvitation';

const data = [
    {path: '/', component: Dashboard},
    {path: '/job-circular', component: JobCircular},
    {path: '/publication-list', component: CircularPublication},
    {path: '/publication-list-view', component: PublicationListView},
    {path: '/job-application', component: JobApplication},
    {path: '/registration', component: Registration},
    {path: '/login', component: Login},
    {path: '/short-list', component: ShortList},
    {path: '/final-selection', component: FinalSelection},
    {path: '/job-list', component: JobList},
    {path: '/applicant-profile', component: ApplicantProfile},
    {path: '/interview-invitation', component: InterviewInvitation},
    {path: '/admit-card', component: AdmitCard},
    {path: '/attendance', component: Attendance},
    {path: '/interview-board', component: InterviewBoard},
    {path: '/scheduling', component: Scheduling},
    {path: '/test-result', component: TestResult}
];

export default data;
