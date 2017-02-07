Vue.component('gfcare-cch-screen', {
    props: ['teamId'],

    ready: function() {
        this.getUsers();
        this.getFacilities();
    },

    data: function() {
        return {
            user: null,
            team: null,
            users: null,
            facilities: null,
        };
    },
    
    events: {
        updateUsers: function() {
            this.getUsers();
            return true;
        },
        userRetrieved: function(user) {
            this.user = user;
            return true;
        },
        currentTeamRetrieved: function(team) {
            this.team = team;
            return true;
        },
    },

    computed: { },

    methods: {
        getUsers: function () {
            var self = this;
            this.$http.get('/gfcare/chn-on-the-go/system/users')
                .success(function (users) {
                    self.users = users;
                    self.$broadcast('cchUsersRetrieved', self.users);
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
    },
    
    filters: { },
});
