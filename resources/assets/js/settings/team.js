Vue.component('spark-team-settings-screen', {
    props: ['teamId'],

    ready: function () {
        this.getTeam();
        this.getUsers();
        this.getDevices();
        this.getFacilities();
        this.getRoles();
        this.getModules();
        this.getLocationTypes();
    },

    data: function () {
        return {
            team: null,
        };
    },


    events: {
        updateTeam: function () {
            this.getTeam();
            return true;
        },
        updateUsers: function () {
            this.getUsers();
            return true;
        },
        updateDevices: function () {
            this.getDevices();
            return true;
        },
        updateFacilities: function() {
            this.getFacilities();
            return true;
        },
    },

    computed: {
  
    },

    methods: {
        getTeam: function () {
            this.$http.get('/gfcare/api/teams/' + this.teamId)
                .success(function (team) {
                    this.team = team;
                    this.$broadcast('teamRetrieved', team);
                });
        },

        getUsers: function () {
            var self = this;
            this.$http.get('/gfcare/api/teams/'+ this.teamId + '/users')
                .success(function (users) {
                    self.users = users;
                    self.$broadcast('usersRetrieved', self.users);
                });
        },
        
        getDevices: function () {
            var self = this;
            this.$http.get('/gfcare/api/teams/'+ this.teamId + '/devices')
                .success(function (devices) {
                    self.devices = devices;
                    self.devices.sort(function(a,b) { 
                        var x = a.type.toLowerCase();
                        var y = b.type.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('devicesRetrieved', self.devices);
                });
        },

        getRoles: function () {
            this.$http.get('/gfcare/api/teams/roles')
                .success(function (roles) {
                    this.roles = roles;
                    this.$broadcast('rolesRetrieved', roles);
                });
        },
        
        getModules: function () {
            this.$http.get('/gfcare/api/teams/modules')
                .success(function (modules) {
                    this.modules = modules;
                    this.$broadcast('modulesRetrieved', modules);
                });
        },

        getFacilities: function () {
            var self = this;
            this.$http.get('/gfcare/api/teams/' + this.teamId + '/facilities')
                .success(function (facilities) {
                    self.facilities = facilities;
                    self.$broadcast('facilitiesRetrieved', self.facilities);
                });
        },

        getLocationTypes: function () {
            this.$http.get('/gfcare/api/teams/locationtypes')
                .success(function (types) {
                    this.$broadcast('locationTypesRetrieved', types);
                });
        },
    }
});
