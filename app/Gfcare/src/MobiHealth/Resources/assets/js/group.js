Vue.component('gfcare-mobi-group-screen', {
     props: ['teamId'],
    ready: function() {
     

    },

    data: function() {
        return {
             
        };
    },
    
    events: {

    },


     watch: {
       
       

    },

    computed: {
       
    },

    methods: {
         getAttendance: function () {
            var self = this;
            this.$http.get('/gfcare/mobihealth/groups')
                .success(function (groups) {
                    
                });
        }, 

    },
    
    filters: {

    },
});

Vue.component('gfcare-mm-mobihealth-dropdown', {
    props: ['teamId'],

    template: '<div>\
        <div class="row">\
          <div class="col-md-4">\
            <spark-select :display="\'CHV\'"\
                              :form="forms.loadOptions"\
                              :name="\'chv\'"\
                              :items="volunteers"\
                              :input.sync="forms.loadOptions.chv">\
                    </spark-select>\
          </div>\
          <div class="col-md-4">\
            <spark-select :display="\'Meetings\'"\
                              :form="forms.loadOptions"\
                              :name="\'meeting\'"\
                              :items="meetingOptions"\
                              :input.sync="forms.loadOptions.meeting">\
                    </spark-select>\
          </div>\
        </div>\
        </div>',

    ready: function() { 
         this.getUsers();
    },

    data: function() {
        return {
           users: null,
             volunteers : [],
             meetings : [],
             meetingOptions:[],
      
            forms : {
           
                loadOptions: new SparkForm ({
                    chv: null,
                    meeting: null,
                }),
          }
        };
    },

    watch: {
         'users': function(v) {
            this.forms.loadOptions.chv = null;
            this.volunteers = [];
            if (v.length > 0) { 
                var self = this;
                $.each(v, function(i, c) { self.volunteers.push({text:c.name, value:c});});    
                this.forms.loadOptions.chv = v[0]; 
            }
        },
         'forms.loadOptions.chv': function(v) {
            this.meetings = [];
            console.log(v);
            if (v != null) { this.meetings = v.meeting; }
            console.log('meeting ' + this.meetings)

        },

         
         'meetings': function(v) {
            this.forms.loadOptions.meeting = null;
            this.meetingOptions = [];
            if (v.length > 0) { 
         var self = this;
        $.each(v, function(i, p) { self.meetingOptions.push({text:p.name, value:p});}); 
        this.forms.loadOptions.meeting = v[0]; 
      }
      }, 
      
       'forms.loadOptions.meeting': function(v) {
            if (v != null) {
        console.log(v);
        console.log(this.forms.loadOptions.meeting.attendance);
                //var attendance = this.getContentByType(this.forms.updateForm.program.contents, v); 
                //this.$broadcast('mmContentUpdated',contents);
            }
        },


    },
    
    events: { 

        usersRetrieved: function(users) {
            this.users = users;
           // this.users = moduleUsers();
            console.log(users);
            return true;
        },
    },

    computed: {
        everythingIsLoaded: function () { return true; },
        /*
         everythingIsLoaded: function () {
            console.log("in computed");
            return this.users.length >0; 
        },*/
    },

    methods: {
       
         
       
         //Ajax Calls
         getUsers: function () {
            var self = this;
           
           this.$http.get('/gfcare/settings/users')
                .success(function (users) {
                  console.log(users);
                    if(users.length>0){self.users = users;}
                });
        },  


       
         //Ajax Calls
         getMeetings: function () {
            var self = this;
           
           this.$http.get('/gfcare/mobihealth/meetings')
                .success(function (meetings) {
                    if(meetings.length>0){self.meetings = meetings;}
                });
        },    
    },
    
    filters: { },
});