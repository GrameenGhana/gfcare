Vue.component('gfcare-mobi-screen', {
    props: ['teamId'],

    ready: function() {
        this.getTeam();
        this.getUsers();
        this.getFacilities();
    },

    data: function() {
        return {
            team: null,
            users: null,
            facilities: null,
        };
    },
    
    events: {
        updateTeam: function () {
            this.getTeam();
            return true;
        },
        
        updateUsers: function() {
            this.getUsers();
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
        getFacilities: function () {
            this.$http.get('/gfcare/api/teams/' + this.teamId + '/facilities')
                .success(function (facilities) {
                    this.facilities = facilities;
                    this.$broadcast('facilitiesRetrieved', facilities);
                });
        },
        getUsers: function () {
            this.$http.get('/gfcare/mobihealth/system/users')
                .success(function (users) {
                    this.users = users;
                    this.$broadcast('mobiUsersRetrieved', users);
                });
        },
    },
    
    filters: {

    },
});
