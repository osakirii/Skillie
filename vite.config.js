import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: "0.0.0.0", // Permite conexões externas
        port: 5173, // Porta fixa para o Vite
        cors: true,
        hmr: {
            host: "localhost", // Para Live Share funcionar corretamente
        },
    },
});
