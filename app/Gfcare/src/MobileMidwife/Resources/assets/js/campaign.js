Vue.component('gfcare-mm-campaign-screen',{

ready: function() {
        this.getMobileMidwifeCampaigns();
    },

data : function()
{
   return {

     user: null,
     campaigns :[],

      forms: {
                addCampaign: new SparkForm ({
                    name: '',
                    description: '',
                    start_date: '',
                    end_date: '', 
                   
                }),
                
                updateCampaign: new SparkForm ({
                    name: '',
                    description: '',
                    start_date: '',
                    end_date: '', 
                }),
            }


   };
},

 events: {
        usersRetrieved: function(users) {
            this.users = users;
            return true;
        },
        
        teamRetrieved: function (team) {
            this.team = team;
            return true;
        },

        },


    methods: {

     addCampaign: function () {  
            this.forms.addCampaign.name = '';
            this.forms.addCampaign.description = '';
            this.forms.addCampaign.start_date = '';
            this.forms.addCampaign.end_date = '';
            $('#modal-add-campaign').modal('show');  
        },

         editCampaign: function (campaign) { 
            this.forms.addCampaign.name = '';
            this.forms.addCampaign.description = '';
            this.forms.addCampaign.start_date = '';
            this.forms.addCampaign.end_date = '';
            $('#modal-edit-campaign').modal('show'); 
        },
       

       //Ajax Calls
       addNewCampaign: function () {
            var self = this;
           
            Spark.post('/gfcare/mobile-midwife/campaign', this.forms.addCampaign)
                .then(function () {
                    $('#modal-add-campaign').modal('hide');
                    self.$dispatch('updateCampaign');
                });
        }, 


         getMobileMidwifeCampaigns: function () {
            var self = this;
            this.$http.get('/gfcare/mobile-midwife/campaigns')
                .success(function (campaigns) {
                    self.campaigns = campaigns;
                    self.campaigns.sort(function(a,b) { 
                        var x = a.type.toLowerCase();
                        var y = b.type.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('mmCampaignsRetrieved', self.clients);
                });
        },      


    },





});
