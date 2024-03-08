import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    build: {
        target: "esnext",
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", 
            "resources/css/login.css",
            "resources/css/content.css",
            "resources/css/coworking.css",
            "resources/css/dapur.css",
            "resources/css/date.css",
            "resources/css/error.css",
            "resources/css/forum.css",
            "resources/css/header.css",
            "resources/css/history.css",
            "resources/css/loader.css",
            "resources/css/mesincuci.css",
            "resources/css/notification.css",
            "resources/css/penghuni.css",
            "resources/css/report.css",
            "resources/css/sergun.css",
            "resources/css/sidebar.css",
            "resources/css/theatre.css",
            "resources/css/view admin/viewcoworking.css",
            "resources/css/view admin/viewdapur.css",
            "resources/css/view admin/viewmesincuci.css",
            "resources/css/view admin/viewreport.css",
            "resources/css/view admin/viewserbaguna.css",
            "resources/css/view admin/viewteater.css",
            "resources/js/app.js",
            "resources/js/bootstrap.js",
            "resources/js/forum.js",
            "resources/js/header.js",
            "resources/js/sidebar.js",
        ],
            refresh: true,
        }),
    ],
});
