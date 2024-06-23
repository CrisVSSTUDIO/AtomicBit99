<template>
    <div id="app">
        <div id="chart" ref="linechart"></div>
    </div>
</template>

<script>
import ApexCharts from 'apexcharts';

export default {
    props: ['clusterKeys', 'clusterValues'],
 
    mounted() {
        console.log(this.clusterKeys, this.clusterValues[0]);
        this.createChart();
    },

    methods: {
        createChart() {
/*             const chartData = this.potato;
 */            const chart = new ApexCharts(this.$refs.linechart, {
            chart: {
                type: 'scatter',
                height: 400,
            },
          
            series: [{
                name: this.clusterKeys[0],
                data: 
                    this.clusterValues[0]
            }, {
                name: this.clusterKeys[1],
                data: 
                    this.clusterValues[1]
            }, {
                name: this.clusterKeys[2],
                data: 
                    this.clusterValues[2]
            },
            {
                name: this.clusterKeys[3],
                data: 
                    this.clusterValues[3]
            },{
                name: this.clusterKeys[4],
                data: 
                    this.clusterValues[4]
            },
            {
                name: this.clusterKeys[5],
                data: 
                    this.clusterValues[5]
            },
            {
                name: this.clusterKeys[6],
                data: 
                    this.clusterValues[6]
            }],
            xaxis: {
                tickAmount: 2,
                labels: {
                    formatter: function (val) {
                        return parseFloat(val).toFixed(1)
                    }
                }
            },
            yaxis: {
                tickAmount: 7
            },
            title: {
                text: 'Clustering of filesizes and filetypes',
                align: 'left',
                margin: 10,
                offsetX: 0,
                offsetY: 0,
                floating: false,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    fontFamily: undefined,
                    color: '#263238',
                },
            },
        });
            chart.render();
        },

        /*  transformData(potato) {
            console.log(potato)
             const series = [];
 
             for (const [assetName, assetValues] of Object.entries(potato)) {
                 const dataPoints = Object.values(assetName).map((value, index) => [index + 1, parseFloat(value)]);
                 series.push({
                     name: assetName,
                     data: dataPoints,
                 });
             }
          
             return series;
         }, */
    },
};
</script>
