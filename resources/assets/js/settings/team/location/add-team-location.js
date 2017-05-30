Vue.component('spark-team-settings-add-team-location-screen', $.extend(true, {
    props:['team', 'locationTypes'],
    
    ready: function () {
        this.whenReady();
    },
    
    /*
     * Initial state of the component's data.
     */
    data: function () {
        return {
            types: [],
            locations: [],
            parents: [],
            defaultParents: [{'text':'None', 'value':0}],

            forms: {
                addTeamLocation: new SparkForm({
                    name: '',
                    parent_id: '',
                    type: '',
                    level: 0,
                })
            }
        };
    },

    watch: {
        'forms.addTeamLocation.type': function (type) {
            var level = _.indexOf(this.locationTypes, type);
            this.forms.addTeamLocation.level = level;
            this.setParents(level);    
        }
    },
    
    events: {
        teamRetrieved: function (team) {
            this.whenReady();
            return true;
        },
                   
        locationTypeChanged: function(type) {
            this.forms.addTeamLocation.type = type;
            return true;  
        },
    },

    methods: {
        addTeamLocation: function () {
            var self = this;
            Spark.post('/gfcare/settings/teams/' + this.team.id + '/locations', this.forms.addTeamLocation)
                .then(function () {
                    $('#modal-add-team-location').modal('hide');
                    self.$dispatch('updateFacilties');
                    self.$dispatch('updateTeam');
                });
        },
        
        whenReady: function() {
            this.setLocations();
            this.setLocationTypes();
            this.setParents();
            this.forms.addTeamLocation.name = "";
        },
        
        setLocations: function() {
           this.locations = [];
           for(var i=0; i < this.team.locations.length; ++i) {
               this.locations.push({'text': this.team.locations[i].name, 'value':this.team.locations[i].id, 
                                    'level': this.team.locations[i].level });
           }
        },
        
        setLocationTypes: function() {
           this.types = [];
           for(var i=0; i < this.locationTypes.length; ++i) {
               if (this.parentExists(i)) {
                    this.types.push({'text': this.locationTypes[i], 'value':this.locationTypes[i], 'level': i });
               }
            }
           this.forms.addTeamLocation.type = this.types[0].text;
        },
        
        setParents: function(level) {
            this.parents = [];
            for(var i=0; i < this.locations.length; ++i) {
                if (this.locations[i].level == level-1) {
                    this.parents.push(this.locations[i]);
                }
            }
            this.parents = (this.parents.length) ? this.parents : this.defaultParents; 
            this.forms.addTeamLocation.parent_id = this.parents[0].value;
        },
        
        parentExists: function(locType) {
            if (locType==0)
                return true;
            
            var parentId = locType - 1;
            for(var i=0; i < this.team.locations.length; ++i) {
                if (this.team.locations[i].level==parentId) {
                    return true;
                }
            }
            
            return false;
        },
    }
}, Spark.components.addTeamLocation));
