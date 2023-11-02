import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import App from "./Components/App.vue";

const routes = [
    {
        path: "/",
        component: App,
    },
];

export default new VueRouter({ routes });
