import "./bootstrap";
import "../scss/app.scss";

import { createApp } from "vue";
import router from "./router/index";
import App from "./components/App.vue";
import Welcome from "./components/pages/Welcome.vue";

const app = createApp(App).use(router);

app.component("Welcome", Welcome);

app.mount("#app");
