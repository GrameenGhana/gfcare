Vue.component('gfcare-mobi-app-user-screen', {

 ready: function() { 
        this.getMobiHealthUser();    
    },

  data : function(){

  	return { 
       
       communityusers : [],
      

  	};

  },
 
 methods :{
   getMobiHealthUser: function () {
            var self = this;
            this.$http.get('/gfcare/mobihealth/community/users')
                .success(function (users) {
                  self.communityusers = users;
                  self.communityusers.sort(function(a,b) { 
                        var x = a.lastname.toLowerCase();
                        var y = b.lastname.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                   self.$broadcast('mmCommunityUsersRetrieved', self.communityusers);

                });
            //console.log(self.communityusers);
        },      

 }



});