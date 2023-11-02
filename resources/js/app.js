import "./bootstrap";
import "../css/app.css";

import { createApp } from "vue";
import App from "./Components/App.vue"; // Main App component
import router from "./router.js"; // Vue Router

createApp(App).use(router).mount("#app");
