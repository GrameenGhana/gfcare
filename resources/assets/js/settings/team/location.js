Vue.component('spark-team-settings-location-screen', {

    ready: function () { },

    data: function () {
        return {
            user: null,
            team: null,
            locationTypes: [],
            facilityTypes: [],
            facilityGroupTypes: [],
            
            editingTeamLocation: {'name':'none'},
            editingTeamFacility: {'name':'none'},
            editingTeamFacilityGroup: {'name':'none'},
            
            removingLocationId: null,
            removingFacilityId: null,
            removingFacilityGroupId: null,
        };
    },

    computed: {
        /*
         * Determine if all necessary data has been loaded.
         */
        everythingIsLoaded: function () {
            return this.user && this.team && this.locationTypes.length>0 && this.facilityTypes.length>0;
        },

    },

    events: {
        userRetrieved: function (user) {
            this.user = user;
            return true;
        },

        teamRetrieved: function (team) {
            this.team = team;
            return true;
        },

        locationTypesRetrieved: function (types) {
            this.locationTypes = types.geopolitical;
            this.facilityTypes = types.facilities;
            this.facilityGroupTypes = types.facilitygroups;
            return true;
        },
    },


    methods: {
        addLocation: function (type) {
            this.$broadcast('locationTypeChanged', type);
            $('#modal-add-team-location').modal('show');
        },
        
        editLocation: function (location) {
            this.editingTeamLocation = location;
            $('#modal-edit-team-location').modal('show');
        },

        removeLocation: function (location) {
            var self = this;
            self.removingLocationId = location.id;
            
            this.$http.delete('/gfcare/settings/teams/' + this.team.id + '/locations/' + location.id)
                .success(function () {
                    self.removingLocationId = 0;
                    this.team.locations = self.removeFromList(this.team.locations, location);
                    self.$dispatch('updateTeam');
                    self.$dispatch('updateTeams');
                    self.$dispatch('updateFacilties');
                })
                .error(function(resp) {
                    self.removingLocationId = 0;
                    NotificationStore.addNotification({
                        text: resp.error[0],
                        type: "btn-danger",
                        timeout: 5000,
                    });
                });
        },

        addFacility: function (type) {
            this.$broadcast('facilityTypeChanged', type);
            $('#modal-add-team-facility').modal('show');
        },
        
        editFacility: function (facility) {
            this.editingTeamFacility = facility;
            $('#modal-edit-team-facility').modal('show');
        },
        
        removeFacility: function (facility) {
            var self = this;
            self.removingFacilityId = facility.id;
            
            this.$http.delete('/gfcare/settings/teams/' + this.team.id + '/facilities/' + facility.id)
                .success(function () {
                    self.removingFacilityId = 0;
                    this.team.facilities = self.removeFromList(this.team.facilities, facility);
                    self.$dispatch('updateTeam');
                    self.$dispatch('updateTeams');
                    self.$dispatch('updateFacilties');
                })
                .error(function(resp) {
                    self.removingFacilityId = 0;
                    NotificationStore.addNotification({
                        text: resp.error[0],
                        type: "btn-danger",
                        timeout: 5000,
                    });
                });
        },
        
        addFacilityGroup: function (type) {
            this.$broadcast('facilityGroupTypeChanged', type);
            $('#modal-add-team-facilitygroup').modal('show');
        },
        
        editFacilityGroup: function (fg) {
            this.editingTeamFacilityGroup = fg;
            $('#modal-edit-team-facilitygroup').modal('show');
        },

        removeFacilityGroup: function (fg) {
            var self = this;
            self.removingFacilityGroupId = fg.id;
            
            this.$http.delete('/gfcare/settings/teams/' + this.team.id + '/facilitygroup/' + fg.id)
                .success(function () {
                    self.removingFacilityGroupId = 0;
                    this.team.facilitygroups = self.removeFromList(this.team.facilitygroup, fg);
                    self.$dispatch('updateTeam');
                    self.$dispatch('updateTeams');
                    self.$dispatch('updateFacilties');
                })
                .error(function(resp) {
                    self.removingFacilityGroupId = 0;
                    NotificationStore.addNotification({
                        text: resp.error[0],
                        type: "btn-danger",
                        timeout: 5000,
                    });
                });
        },
                       
        removingLocation: function(id) { return (this.removingLocationId == id); },
        removingFacility: function(id) { return (this.removingFacilityId == id); },
        removingFacilityGroup: function(id) { return (this.removingFraciltyGroupId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
        
        locByType: function (type) {
            return this.team.locations.filter(function (loc) {
                return  loc.type=== type;
            })
        },

        facByType: function (type) {
            return this.team.facilities.filter(function (loc) {
                return  loc.type===type;
            })
        },

        facGroupByType: function (type) {
            return this.team.facilitygroups.filter(function (loc) {
                return  loc.type===type;
            })
        },
        
        locTypeIdx: function(type) {
            return this.locationTypes.indexOf(type);
        },
           
        userOwns: function (team) {
            if (!this.user) { return false; }
            return this.user.id === team.owner_id;
        }
    },

    filters: {
        location_parent: function (value) {
            if (value==0) {
                return "No parent";
            } else {
                var l = _.find(this.team.locations, function (loc) {
                    return loc.id == value;
                });
                return (l==null) ? null : l.name ;
            }
        },
        
        location_parent_type: function (value) {
            var idx = this.locationTypes.indexOf(value);
            if (idx==0) 
                return null;
            return this.locationTypes[idx-1]; 
        },

        location_name: function (value) {
            if (value==0) {
                return "No name";
            } else {
                var l = _.find(this.team.locations, function (loc) {
                    return loc.id == value;
                });
                return (l==null) ? null : l.name ;
            }
        },

        facilitygroup_facilities: function (facIds) {
            var names = "";
            var facs = facIds.split(',');
            for(var i=0; i < facs.length; i++) {
                if (facs[i]!="") {
                    var f = _.find(this.team.facilities, function (fac) {
                        return fac.id == parseInt(facs[i]);
                    });
                    names = (f==null) ? names : (names + ((names==""? '': ', ')) + f.name);
                }
            }
            return (names=="") ? "No facilities" : names;
        },
        
        pluralize: function (value) {
            if (value.toLowerCase().endsWith('s') || value.toLowerCase().endsWith('ies'))
                return value;         
            return (value.toLowerCase().endsWith('y')) ? value.replace(/y$/i,'ies') : value +'s';
        }
    }
});
