import "./bootstrap";
import "../css/app.css";
import "@protonemedia/laravel-splade/dist/style.css";
import '@google/model-viewer';
import Particles from "@tsparticles/vue3";
import VueParticles from "@tsparticles/vue3";
import { loadSlim } from "@tsparticles/slim"; // if you are going to use `loadSlim`, install the "@tsparticles/slim" package too.
import Particle from "./Components/Particle.vue";
import Scatter from "./Components/Scatter.vue";
import { createApp } from "vue/dist/vue.esm-bundler.js";
import { renderSpladeApp, SpladePlugin } from "@protonemedia/laravel-splade";
import VueApexCharts from 'vue-apexcharts'
import Accordion from "./Components/Accordion.vue";
import LineChart from "./Components/LineChart.vue";
// import Swiper JS
import Swiper from 'swiper';
// import Swiper styles
import 'swiper/css';

const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'vertical',
    loop: true,
  
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  });
  
  

const el = document.getElementById("app");

createApp({
    render: renderSpladeApp({ el })
})
    .use(SpladePlugin, {
        "max_keep_alive": 10,
        "transform_anchors": true,
        
        "progress_bar": true,
        "components": {
            Particle,
            LineChart,
            Scatter,
            Accordion
        },
        VueApexCharts
    })
    .use(Particles, {
        init: async engine => {
            await loadSlim(engine); // or you can load the slim version from "@tsparticles/slim" if don't need Shapes or Animations

        },
    })
    .mount(el);
