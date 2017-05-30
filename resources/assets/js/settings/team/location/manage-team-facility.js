Vue.component('spark-team-settings-add-team-facility-screen', $.extend(true, {
    props:['team', 'facilityTypes'],
       
    ready: function () {
        this.whenReady();
    },
    
    /*
     * Initial state of the component's data.
     */
    data: function () {
        return {
            types: [],

            forms: {
                addTeamFacility: new SparkForm({
                    type: '',
                    location_id: '',
                    name: '',
                    contact: '',
                    phonenumber: '',
                    address: '',
                    email: '',
                    longitude: '',
                    latitude: '',
                })
            }
        };
    },

    watch: {
        'forms.addTeamFacility.location_id': function (id) {
            //console.log("New Location id: "+id);
        }
    },
    
    events: {
        teamRetrieved: function (team) {
            this.whenReady();
            return true;
        },
                   
        facilityTypeChanged: function(type) {
            this.forms.addTeamFacility.type = type;
            return true;  
        },
    },

    methods: {
        addTeamFacility: function () {
            var self = this;
            Spark.post('/gfcare/settings/teams/' + this.team.id + '/facilities', this.forms.addTeamFacility)
                .then(function () {
                    $('#modal-add-team-facility').modal('hide');
                    self.$dispatch('updateTeam');
                    self.$dispatch('updateFacilties');
                });
        },
        
        whenReady: function() {
            this.setFacilityTypes();
            this.forms.addTeamFacility.location_id = "";
            this.forms.addTeamFacility.name = "";
            this.forms.addTeamFacility.contact = "";
            this.forms.addTeamFacility.phonenumber = "";
            this.forms.addTeamFacility.address = "";
            this.forms.addTeamFacility.email = "";
            this.forms.addTeamFacility.longitude = "";
            this.forms.addTeamFacility.latitude = "";
        },
        
        setFacilityTypes: function() {
           this.types =[]; 
           for(var i=0; i < this.facilityTypes.length; ++i) {
              this.types.push({'text': this.facilityTypes[i], 'value':this.facilityTypes[i]});
           }
        },
    }
}, Spark.components.addTeamFacility));



Vue.component('spark-team-settings-edit-team-facility-screen', $.extend(true, {
    props:['team', 'teamFacility'],
    
    ready: function () {   },
    
    data: function () {
        return {
            forms: {
                updateTeamFacility: new SparkForm({
                    type: '',
                    location_id: '',
                    name: '',
                    contact: '',
                    phonenumber: '',
                    address: '',
                    email: '',
                    longitude: '',
                    latitude: '',
                })
            }
        };
    },

    watch: {
        'teamFacility': function (teamFacility) {
            this.forms.updateTeamFacility.type = teamFacility.type;
            this.forms.updateTeamFacility.location_id = teamFacility.location_id;
            this.forms.updateTeamFacility.name = teamFacility.name;
            this.forms.updateTeamFacility.contact = teamFacility.contact;
            this.forms.updateTeamFacility.phonenumber = teamFacility.phonenumber;
            this.forms.updateTeamFacility.address = teamFacility.address;
            this.forms.updateTeamFacility.email = teamFacility.email;
            this.forms.updateTeamFacility.longitude = teamFacility.longitude;
            this.forms.updateTeamFacility.latitude = teamFacility.latitude;
        }
    },
    
    events: {
        teamRetrieved: function (team) {
            this.team = team;
            return true;
        },
    },

    methods: {
        updateTeamFacility: function () {
            var self = this;
            Spark.put('/gfcare/settings/teams/' + this.team.id + '/facilities/' + this.teamLocation.id, this.forms.updateTeamFacility)
                .then(function () {
                    $('#modal-edit-team-facility').modal('hide');
                    self.$dispatch('updateFacilties');
                    self.$dispatch('updateTeam');
                });
        }
    }
}, Spark.components.editTeamFacility));
