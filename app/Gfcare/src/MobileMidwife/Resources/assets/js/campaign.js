Vue.component('gfcare-mm-campaign-screen',{

ready: function() {
        this.getMobileMidwifeCampaigns();
    },

data : function()
{
   return {

     user: null,
     campaigns :[],
     editingCampaign: {'name':'none'},

      forms: {
                addCampaign: new SparkForm ({
                    name: '',
                    description: '',
                    start_date: '',
                    end_date: '', 
                   
                }),
                
                editCampaign: new SparkForm ({
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
       
        removingCampaign: function(id) { return (this.removingCampaignId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

       //Ajax Calls
       addNewCampaign: function () {
            var self = this;
            console.log("in campaign save");
            Spark.post('/gfcare/mobile-midwife/campaigns', this.forms.addCampaign)
                .then(function () {
                    $('#modal-add-campaign').modal('hide');
                    self.$dispatch('updateCampaigns');
                });
        }, 


         updateCampaign: function () {
            var self = this;
            Spark.put('/gfcare/mobile-midwife/campaigns' + this.editingCampaign.id, this.forms.UpdateCampaign)
                .then(function () {
                    $('#modal-edit-campaign').modal('hide');
                    self.$dispatch('updateCampaigns');
                });
        },              


         getMobileMidwifeCampaigns: function () {
            var self = this;
            this.$http.get('/gfcare/mobile-midwife/campaigns')
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





});
