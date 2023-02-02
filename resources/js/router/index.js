import { createWebHistory, createRouter } from "vue-router";

import Welcome from "../components/pages/Welcome.vue";
import Upload from "../components/pages/Upload.vue";
import GraphQLUpload from "../components/pages/GraphQLUpload.vue";

const routes = [
    {
        path: "/",
        name: "Welcome",
        component: Welcome,
    },
    {
        path: "/upload",
        name: "Upload",
        component: Upload,
    },
    {
        path: "/graphql-upload",
        name: "GraphQLUpload",
        component: GraphQLUpload,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
