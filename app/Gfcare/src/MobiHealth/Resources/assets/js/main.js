Vue.component('gfcare-mobi-screen', {
    props: ['teamId'],

    ready: function() {
        this.getUsers();
    },

    data: function() {
        return {
            user: null,
            team: null,
            users: null,
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
            this.$http.get('/gfcare/mobihealth/system/users')
                .success(function (users) {
                    self.users = users;
                    self.$broadcast('mobihealthUsersRetrieved', self.users);
            });
        },
    },
    
    filters: { },
});
