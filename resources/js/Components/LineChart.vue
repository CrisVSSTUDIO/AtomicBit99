<template>
    <div id="app">
        <div id="chart" ref="linechart" :perYear="perYear" :yearCount="yearCount"></div>
    </div>
</template>
<script>

export default {
    props: ['yearCount', 'perYear'],
    mounted() {
        this.createChart(); // Call a method to create the chart
    },
    methods: {
        createChart() {
            const chart = new ApexCharts(this.$refs.linechart, {
                chart: {
                    type: 'line',
                    height: 400
                },
                series: [{
                    name: 'Files',
                    data: this.perYear,
                }],
                xaxis: {
                    categories: this.yearCount // Use the yearCount data for the x-axis categories
                },
                title: {
                    text: "Nº of files per year (Linear Regression)",
                    align: 'left',
                    margin: 10,
                    offsetX: 0,
                    offsetY: 0,
                    floating: false,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        fontFamily: undefined,
                        color: '#263238'
                    },
                }
            });
            chart.render();

        }

    }

}
</script>
