import { createServer } from "http";
import { createSSRApp } from "vue";
import { renderToString } from "@vue/server-renderer";
import { renderSpladeApp, SpladePlugin, startServer } from "@protonemedia/laravel-splade";
import Particle from "./Components/Particle.vue";
import LineChart from "./Components/LineChart.vue";
import VueApexCharts from 'vue-apexcharts'
import Scatter from "./Components/Scatter.vue";
import Accordion from "./Components/Accordion.vue";
import '@google/model-viewer';
startServer(createServer, renderToString, (props) => {
    return createSSRApp({
        render: renderSpladeApp(props)
    })
        .use(SpladePlugin, VueApexCharts)
        .component('Particle', Particle)
        .component('LineChart', LineChart)
        .component('Scatter', Scatter)
        .component('Accordion', Accordion)


});