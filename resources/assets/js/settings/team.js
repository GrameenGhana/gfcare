Vue.component('spark-team-settings-screen', {
    props: ['teamId'],

    /*
     * Bootstrap the component. Load the initial data.
     */
    ready: function () {
        this.getTeam();
        this.getRoles();
        this.getModules();
        this.getLocationTypes();
    },


    /*
     * Initial state of the component's data.
     */
    data: function () {
        return {
            team: null,
        };
    },


    events: {
        /*
         * Handle the "updateTeam" event. Re-retrieve the team.
         */
        updateTeam: function () {
            this.getTeam();
            return true;
        }
    },

    computed: {
  
    },

    methods: {
        /*
         * Get the team from the API.
         */
        getTeam: function () {
            this.$http.get('/gfcare/api/teams/' + this.teamId)
                .success(function (team) {
                    this.team = team;
                    this.$broadcast('teamRetrieved', team);
                });
        },
        
        /**
         * Get all of the roles that may be assigned to users.
         */
        getRoles: function () {
            this.$http.get('/gfcare/api/teams/roles')
                .success(function (roles) {
                    this.roles = roles;
                    this.$broadcast('rolesRetrieved', roles);
                });
        },
        
        /**
         * Get all of the modules that may be assigned to teams.
         */
        getModules: function () {
            this.$http.get('/gfcare/api/teams/modules')
                .success(function (modules) {
                    this.modules = modules;
                    this.$broadcast('modulesRetrieved', modules);
                });
        },
        
        /**
         * Get all of the locations that may be assigned to teams.
         */
        getLocationTypes: function () {
            this.$http.get('/gfcare/api/teams/locationtypes')
                .success(function (types) {
                    this.$broadcast('locationTypesRetrieved', types);
                });
        },
    }
});
