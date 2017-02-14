Vue.component('spark-team-settings-add-team-facilitygroup-screen', $.extend(true, {
    props:['team', 'facilityGroupTypes'],
    
    ready: function () {
        this.whenReady();
    },
    
    /*
     * Initial state of the component's data.
     */
    data: function () {
        return {
            types: [],
            facilities: [],

            forms: {
                addTeamFacilityGroup: new SparkForm({
                    type: '',
                    name: '',
                    facilities: '',
                })
            }
        };
    },

    watch: {
        'forms.addTeamFacilityGroup.type': function (type) {
 }
    },
    
    events: {
        teamRetrieved: function (team) {
            this.whenReady();
            this.team = team;
            return true;
        },
                   
        facilityGroupTypeChanged: function(type) {
            this.forms.addTeamFacilityGroup.type = type;
            return true;  
        },
    },

    methods: {
        addTeamFacilityGroup: function () {
            var self = this;
            Spark.post('/gfcare/settings/teams/' + this.team.id + '/facilitygroups', this.forms.addTeamFacilityGroup)
                .then(function () {
                    $('#modal-add-team-facilitygroup').modal('hide');
                    self.$dispatch('updateTeam');
                    self.$dispatch('updateFacilties');
                });
        },
        
        whenReady: function() {
            this.setFacilityGroupTypes();
            this.forms.addTeamFacilityGroup.type = "";
            this.forms.addTeamFacilityGroup.name = "";
            this.forms.addTeamFacilityGroup.facilities= "";
        },
        
        setFacilityGroupTypes: function() {
           this.types = [];
            for(var i=0; i < this.facilityGroupTypes.length; ++i) {
              this.types.push({'text': this.facilityGroupTypes[i], 'value':this.facilityGroupTypes[i]});
            }
        },
    }
}, Spark.components.addTeamFacilityGroup));



Vue.component('spark-team-settings-edit-team-facilitygroup-screen', $.extend(true, {
    props:['teamFacilityGroup', 'team'],
    
    ready: function () {   },
    
    data: function () {
        return {
            facilities: [],
            forms: {
                updateTeamFacilityGroup: new SparkForm({
                    type: '',
                    name: '',
                    facilities: '',
                })
            }
        };
    },

    watch: {
        'teamFacilityGroup': function (teamFacilityGroup) {
            this.forms.updateTeamFacilityGroup.type = teamFacilityGroup.type;
            this.forms.updateTeamFacilityGroup.name = teamFacilityGroup.name;
            this.forms.updateTeamFacilityGroup.facilities = teamFacilityGroup.facilities;;
        }
    },
    
    events: {
        teamRetrieved: function (team) {
            this.team = team;
            return true;
        },
    },

    methods: {
        updateTeamFacilityGroup: function () {
            var self = this;
            Spark.put('/gfcare/settings/teams/' + this.team.id + '/facilitygroup/' + this.teamLocation.id, this.forms.updateTeamFacilityGroup)
                .then(function () {
                    $('#modal-edit-team-facilitygroup').modal('hide');
                    self.$dispatch('updateTeam');
                    self.$dispatch('updateFacilties');
                });
        }
    }
}, Spark.components.editTeamFacilityGroup));
