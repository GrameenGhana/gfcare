/*
 * Load the Spark components.
 */
require('./core/components');

module.exports = {
    el: '#spark-app',

    components: {
  	 'notifications': Notifications
    },
    
    ready: function () {
        $(function () {
            $('.spark-first-field').filter(':visible:first').focus();
        });

        if (Spark.userId) {
            this.getUser();
        }

        if (Spark.currentTeamId) {
            this.getTeams();
            this.getCurrentTeam();
        }

        this.whenReady();
    },


    events: {
        updateUser: function () {
            this.getUser();
            return true;
        },

        updateTeams: function () {
            this.getTeams();
            this.getCurrentTeam();
            return true;
        },

        updateTeam: function() {
            this.getCurrentTeam();
            return true;
        },
    },


    methods: {
        whenReady: function () { },

        getUser: function () {
            this.$http.get('/gfcare/api/users/me')
                .success(function (user) {
                    this.$broadcast('userRetrieved', user);
                });
        },

        getTeams: function () {
            this.$http.get('/gfcare/api/teams')
                .success(function (teams) {
                    this.$broadcast('teamsRetrieved', teams);
                });
        },

        getCurrentTeam: function () {
            this.$http.get('/gfcare/api/teams/' + Spark.currentTeamId)
                .success(function (team) {
                    this.$broadcast('currentTeamRetrieved', team);
                });
        }
    }
};
