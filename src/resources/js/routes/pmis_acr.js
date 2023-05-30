import reports from '../components/pmis/acr/EmployeeRportBook';
import fourthClassConfidential from '../components/pmis/acr/FourthClassConfidential';
import thirdClassConfidential from '../components/pmis/acr/ThirdClassConfidential';
import fourthClassConfidential2 from '../components/pmis/acr/FourthClassConfidential2';
import thirdClassConfidential2 from '../components/pmis/acr/ThirdClassConfidential2';
import officerConfidential from '../components/pmis/acr/OfficerConfidential';
import ServiceInnerSheet from "../components/pmis/acr/ServiceInnerSheet";

const data= [
    { path: '/reports', component: reports },
    { path: '/fourth-class-confidential', component: fourthClassConfidential },
    { path: '/third-class-confidential', component: thirdClassConfidential },
    { path: '/fourth-class-confidential2', component: fourthClassConfidential2 },
    { path: '/third-class-confidential2', component: thirdClassConfidential2 },
    { path: '/officer-confidential', component: officerConfidential },
    { path: '/service-inner-sheet', component: ServiceInnerSheet },
  ];

export default data;
