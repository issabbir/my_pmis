import DashboardLayout from "../pages/Layout/DashboardLayout.vue";
import Dashboard from "../pages/Dashboard.vue";

const routes = [
    {
        path: "/",
        component: DashboardLayout,
        redirect: "/dashboard",
        name: "Dashboard",
        children: [
            {
                path: "dashboard",
                name: "Dashboard",
                component: Dashboard,
            }
        ]
    }
];

export default routes;
