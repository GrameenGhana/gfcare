Vue.component('gfcare-mobi-group-screen', {

    ready: function() {
    },

    data: function() {
        return {
        };
    },
    
    events: {
    },

    computed: {
    },

    methods: {
      getGroups: function () {
            var self = this;
            this.$http.get('/gfcare/mobihealth/groups')
                .success(function (campaigns) {
                    self.campaigns = campaigns;
                    self.campaigns.sort(function(a,b) { 
                        var x = a.name.toLowerCase();
                        var y = b.name.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('mmCampaignsRetrieved', self.campaigns);
                });
        }, 


    },
    
    filters: {

    },
});
