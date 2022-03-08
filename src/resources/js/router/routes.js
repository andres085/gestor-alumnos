import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "./pages/Dashboard";

const routes = [
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
  },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});