Vue.component('gfcare-mobi-meeting-screen', {

 ready: function() { 
        this.getMeeting();    
    },

  data : function(){

  	return { 
       
       meetings : [],
      

  	};

  },
 
 methods :{
   getMeeting: function () {
            var self = this;
            this.$http.get('/gfcare/mobihealth/community/meetings')
                .success(function (meetings) {
                  console.log(meetings);
                  self.meetings = meetings;
                  self.meetings.sort(function(a,b) { 
                        var x = a.name.toLowerCase();
                        var y = b.name.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                   self.$broadcast('mmMeetingsRetrieved', self.meetings);

                });
          console.log(self.meetings);
        },      

 }



});