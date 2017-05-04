Vue.component('gfcare-mm-system-config-screen', {
    props: ['teamId'],

    ready: function() { 
        this.getConfig();
    },

    data: function() {
        return {
            config: {voice:'', sms:''},
            forms: {
                updateForm: new SparkForm ({ team_id: '', sms: '', voice: '', }),
            }
        };
    },

    watch: {
        'config': function(c) {
            this.forms.updateForm.sms = c.sms;
            this.forms.updateForm.voice = c.voice;
        }
    },
    
    events: { },

    computed: {
        everythingIsLoaded: function () { return true; },
    },

    methods: {
        updateConfig: function () {
            var self = this;
            this.forms.updateForm.team_id = this.teamId;
            Spark.put('/gfcare/mobile-midwife/system/config/' + this.teamId, this.forms.updateForm)
                .then(function () { 
                
                });
        },     

        getConfig: function () {
            var self = this;
            this.$http.get('/gfcare/mobile-midwife/system/config')
                .success(function (cfg) {
                    if (cfg.length>0) { self.config = cfg[0]; }
                });
        },
    },
    
    filters: { },
});
