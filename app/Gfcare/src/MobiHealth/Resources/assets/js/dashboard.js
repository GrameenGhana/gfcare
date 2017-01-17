Vue.component('gfcare-mobi-dashboard-screen', {
    
    ready: function() {
        this.getMessagePlayed();
    },
    
    data: function() {
        return {
           lineData: { 
                labels: [],
                series: [],
           },
        }
    },
    
    events: {
        updateCharts: function () {
            this.updateChart();
            return true;
        },
    },
    
    methods: {
        updateChart: function() {
            new Chartist.Bar('.ct-chart', this.lineData, 
                              {
                                width: 680, 
                                height: 550,
                                //horizontalBars:true,
                                axisY: {
                                    offset: 50
                                },
                                plugins: [
                                   Chartist.plugins.tooltip(),
                                    Chartist.plugins.ctPointLabels({textAnchor: 'middle'})
                                ]
                              });
        },
        
        // Ajax calls
        getMessagePlayed: function () {
            var self = this;
            this.$http.get('/gfcare/mobihealth/api/messageplaycountbysubmodule')
                .success(function (res) {
                    var d = res;
                    d.sort(function(a,b) { 
                        var x = a.play_count;
                        var y = b.play_count;
                        return (x < y) ? 1 : ((x > y) ? -1 : 0);
                    });
                    
                    self.lineData.labels = [];
                    self.lineData.series = [];
                    
                    var vals=[]; var c = 0;
                    for (var x in d) {
                        if (c < 10) {
                            self.lineData.labels.push(d[x].sub_module);
                            vals.push(d[x].play_count);
                            c++;
                        }
                    }
                    self.lineData.series.push(vals);

                    self.$dispatch('updateCharts', d);
                });
        },
    },
});
