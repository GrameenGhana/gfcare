Vue.component('spark-bar-chart', {
    props: ['columns', 'rows', 'options'], 
    components: {
        'vue-chart': vChart
    },
    template: '<vue-chart :chart-type="bar" :columns="columns" :rows="rows" :options="options"></vue-chart>',
});
