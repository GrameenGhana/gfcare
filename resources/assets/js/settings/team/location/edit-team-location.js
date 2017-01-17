Vue.component('spark-team-settings-edit-team-location-screen', $.extend(true, {
    props:['teamLocation', 'team'],
    
    ready: function () {   },
    
    data: function () {
        return {
            forms: {
                updateTeamLocation: new SparkForm({
                    name: '',
                    parent_id: '',
                    type: '',
                    level: 0,
                })
            }
        };
    },

    watch: {
        'teamLocation': function (teamLocation) {
            this.forms.updateTeamLocation.level = teamLocation.level;
            this.forms.updateTeamLocation.parent_id = teamLocation.parent_id;
            this.forms.updateTeamLocation.type = teamLocation.type;
            this.forms.updateTeamLocation.name = teamLocation.name;
        }
    },
    
    events: {
        teamRetrieved: function (team) {
            this.team = team;
            return true;
        },
    },

    methods: {
        updateTeamLocation: function () {
            var self = this;
            Spark.put('/gfcare/settings/teams/' + this.team.id + '/locations/' + this.teamLocation.id, this.forms.updateTeamLocation)
                .then(function () {
                    $('#modal-edit-team-location').modal('hide');
                    self.$dispatch('updateTeam');
                });
        }
    }
}, Spark.components.editTeamLocation));
