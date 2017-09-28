Vue.component('gfcare-mm-program-screen',{
   ready:function(){
       this.getMobileMidwifePrograms();
       this.getCampaigns();

   },

   data:function(){
   	return{
   		user:null,
   		programs:[],
        campaigns:[],
   		editingProgram:{'name':'none'},
   		channelOptions: [
                {'text': 'sms', 'value':'sms'}, 
                {'text': 'voice', 'value':'voice'}, 
                {'text': 'both', 'value':'both'}
            ],
        campaignOptions: [],
      
        
         forms: {
                addProgram: new SparkForm ({
                    name: '',
                    campaign:'',
                    channel: '',
                    start_week: '',
                    end_week: '', 
                   
                }),
                
                editingProgram: new SparkForm ({
                    name: '',
                    campaign:'',
                    channel: '',
                    start_week: '',
                    end_week: '', 
                }),
            }
 

   };
},
methods:{

	 getMobileMidwifePrograms: function () {
            var self = this;
            this.$http.get('/gfcare/mobile-midwife/programs')
                .success(function (programs) {
                    self.programs = programs;
                    self.programs.sort(function(a,b) { 
                        var x = a.name.toLowerCase();
                        var y = b.name.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('mmProgramsRetrieved', self.programs);
                });
        }, 

      getCampaigns: function () {
            var self = this;
            this.$http.get('/gfcare/mobile-midwife/campaigns')
                .success(function (res) {
                    if (res.length>0) { 
                      self.campaigns = res; 
                      this.campaignOptions =[]; 
               for(var i=0; i < this.campaigns.length; ++i) {
                    this.campaignOptions.push({'text': this.campaigns[i].name, 
                                      'value': this.campaigns[i].id});
                    }
                 
             }
            });
        },


         addProgram: function () {  
            this.forms.addProgram.name = '';
            this.forms.addProgram.channel = '';
            this.forms.addProgram.start_week = '';
            this.forms.addProgram.end_week = '';
            $('#modal-add-program').modal('show');  
        },  

         editingProgram: function (program) { 
            this.forms.addProgram.name = '';
            this.forms.addProgram.channel = '';
            this.forms.addProgram.start_week = '';
            this.forms.addProgram.end_week = '';
            $('#modal-edit-program').modal('show'); 
        },  

        removingProgram: function(id) { return (this.removingProgramId == id); },


        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

//Ajax Calls
       addNewProgram: function () {
            var self = this;
            console.log("in program save");
            Spark.post('/gfcare/mobile-midwife/programs', this.forms.addProgram)
                .then(function () {
                    $('#modal-add-program').modal('hide');
                    self.$dispatch('updatePrograms');
                });
        }, 


         updateProgram: function () {
            var self = this;
            Spark.put('/gfcare/mobile-midwife/programs' + this.editingProgram.id, this.forms.UpdateProgram)
                .then(function () {
                    $('#modal-edit-program').modal('hide');
                    self.$dispatch('updatePrograms');
                });
        },   

},
 events: {

      campaignsRetrieved: function(campaigns) {
             this.campaignOptions =[]; 
             for(var i=0; i < this.campaigns.length; ++i) {
                    this.campaignOptions.push({'text': this.campaigns[i].name, 
                                      'value': this.campaigns[i].id});
                 
             }


        },


        mmProgramsRetrieved: function(c) {
            console.log(c);
            this.programs = c;
            return true;
        },
  

 }


});