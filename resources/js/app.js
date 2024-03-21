import "./bootstrap";
import "../css/app.css";
import { createApp } from "vue/dist/vue.esm-bundler.js";
import { renderSpladeApp, SpladePlugin } from "@protonemedia/laravel-splade";
import "@protonemedia/laravel-splade/dist/style.css";
import ProductCard from '../views/ProductCard.vue'; 
import GameDetail from '../views/GameDetail.vue'; 
import homeGameCard from '../views/homeGameCard.vue';
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";


const el = document.getElementById("app");
const options = {
    // You can set your default options here
};

createApp({
    render: renderSpladeApp({ el })
})
    .use(SpladePlugin, {
        "max_keep_alive": 10,
        "transform_anchors": false,
        "progress_bar": true
    })
    .component('ProductCard', ProductCard)
.component('GameDetail', GameDetail) 
.component('homeGameCard', homeGameCard)
.use(Toast, options)
.mount(el);
