import "./bootstrap";
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";

import App from "./App.vue";
import LandingPage from "./pages/LandingPage.vue";
import Login from "./pages/Login.vue";
import Register from "./pages/Register.vue";
import Profile from "./pages/Profile.vue";
import Clients from "./pages/Clients.vue";
import Passes from "./pages/Passes.vue";
import Sessions from "./pages/Sessions.vue";

axios.defaults.baseURL = "/api";
axios.defaults.withCredentials = true;

const routes = [
    { path: "/", component: LandingPage },
    { path: "/login", component: Login },
    { path: "/register", component: Register },
    { path: "/profile", component: Profile, meta: { requiresAuth: true } },
    {
        path: "/clients",
        component: Clients,
        meta: { requiresAuth: true, role: "admin" },
    },
    {
        path: "/passes",
        component: Passes,
        meta: { requiresAuth: true, role: "admin" },
    },
    {
        path: "/sessions",
        component: Sessions,
        meta: { requiresAuth: true, role: "admin" },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const token = localStorage.getItem("token");
    const user = JSON.parse(localStorage.getItem("user"));

    if (to.meta.requiresAuth && !token) {
        return next("/login");
    }

    if (to.meta.role && user?.role !== to.meta.role) {
        return next("/profile");
    }

    next();
});

const app = createApp(App);
app.use(router);
app.mount("#app");
