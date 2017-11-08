Vue.component('gfcare-mm-service-content-screen', {
    props: ['teamId'],

    ready: function() { 
        this.getContent();    
    },

    data: function() {
        return {
			content: [],
            contentOptions:[{'text': 'sms', 'value':'sms'},{'text': 'voice', 'value':'voice'}],

            forms : {

                addContent: new SparkForm({
                    name:'',
                    week:'',
                    content_type:'',
                    sms_message:''
                }),

                updateContent : new SparkForm({
                    
                    name:'',
                    week:'',
                    content_type:'',
                    sms_message:''

                })
                
            }

        };
    },

    watch: { },
    
    events: { 
		mmContentUpdated: function(c) {
			console.log(c);
			this.content = c;
			return true;
		}
	},

    computed: { },
    methods: { 
        getContent: function () {
            var self = this;
            this.$http.get('/gfcare/mobile-midwife/content')
                .success(function (res) {
                    if (res.length>0) { 
                      self.content = res;  
             }
            });
        },
          addContent: function () {  
            this.forms.addContent.name = '';
            this.forms.addContent.week = '';
            this.forms.addContent.content_type = '';
            this.forms.addContent.sms_message = '';
            $('#modal-add-content').modal('show');  
        },  

    },
    filters: { },
});

Vue.component('gfcare-mm-content-dropdown', {
    props: ['teamId'],

    template: '<div>\
				<div class="row">\
					<div class="col-md-4">\
						<spark-select :display="\'Campaign\'"\
                              :form="forms.updateForm"\
                              :name="\'campaign\'"\
                              :items="campaignOptions"\
                              :input.sync="forms.updateForm.campaign">\
                		</spark-select>\
					</div>\
					<div class="col-md-4">\
						<spark-select :display="\'Program\'"\
                              :form="forms.updateForm"\
                              :name="\'program\'"\
                              :items="programOptions"\
                              :input.sync="forms.updateForm.program">\
                		</spark-select>\
					</div>\
					<div class="col-md-4">\
						<spark-select :display="\'Channel\'"\
                              :form="forms.updateForm"\
                              :name="\'channel\'"\
                              :items="channelOptions"\
                              :input.sync="forms.updateForm.channel">\
                		</spark-select>\
					</div>\
				</div>\
        </div>',

    ready: function() { 
        this.getCampaigns();
    },

    data: function() {
        return {
            campaigns: [],
            programs: [],
            channels:[],

            campaignOptions: [],
            programOptions: [],
            channelOptions: [],

            forms: {
                updateForm: new SparkForm ({ 
					campaign: null, 
					program: null, 
					channel: null, 
				}),
            }
        };
    },

    watch: {
        'campaigns': function(v) {
            this.forms.updateForm.campaign = null;
			this.campaignOptions = [];
            if (v.length > 0) { 
				var self = this;
				$.each(v, function(i, c) { self.campaignOptions.push({text:c.name, value:c});});	
				this.forms.updateForm.campaign = v[0]; 
			}
        },
 
        'forms.updateForm.campaign': function(v) {
            this.programs = [];
            console.log(v);
            if (v != null) { this.programs = v.programs; }
        },

        'programs': function(v) {
            this.forms.updateForm.program = null;
			this.programOptions = [];
            if (v.length > 0) { 
				var self = this;
				$.each(v, function(i, p) { self.programOptions.push({text:p.name, value:p});});	
				this.forms.updateForm.program = v[0]; 
			}
        },

        'forms.updateForm.program': function(v) {
            this.channelOptions = [];
            this.forms.updateForm.channel = null;
            if (v != null) {
                if (v.channels=='both') {
                    this.channelOptions.push({text:'SMS', value:'sms'}); 
                    this.channelOptions.push({text:'Voice', value:'voice'}); 
                } else if (v.channels=='sms') {
                    this.channelOptions.push({text:'SMS', value:'sms'}); 
                } else {
                    this.channelOptions.push({text:'Voice', value:'voice'}); 
                }
                this.forms.updateForm.channel = this.channelOptions[0].value;
            }
        },

        'forms.updateForm.channel': function(v) {
            if (v != null) {
				console.log(v);
				console.log(this.forms.updateForm.program.contents);
                var contents = this.getContentByType(this.forms.updateForm.program.contents, v); 
                this.$dispatch('mmContentUpdated',contents);
            }
        },
    },
    
    events: { },

    computed: {
        everythingIsLoaded: function () { return true; },
    },

    methods: {
        getContentByType: function (list, type) {
            return _.filter(list, function (i) { console.log('Comparing '+i.content_type +' to '+type); return i.content_type == type; });
        },

        getCampaigns: function () {
            var self = this;
            this.$http.get('/gfcare/mobile-midwife/campaigns')
                .success(function (res) {
                    if (res.length>0) { self.campaigns = res; }
                });
        },
    },
    
    filters: { },
});
