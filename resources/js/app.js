import "./bootstrap";
import "../scss/app.scss";

import { createApp } from "vue";
import router from "./router/index";
import App from "./components/App.vue";
import Welcome from "./components/pages/Welcome.vue";
import Upload from "./components/pages/Upload.vue";
import GraphQLUpload from "./components/pages/GraphQLUpload.vue";

const app = createApp(App).use(router);

app.component("Welcome", Welcome);
app.component("Upload", Upload);
app.component("GraphQLUpload", GraphQLUpload);

app.mount("#app");
