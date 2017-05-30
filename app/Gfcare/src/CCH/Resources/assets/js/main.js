Vue.component('gfcare-cch-screen', {
    props: ['teamId'],

    ready: function() {
        this.getUsers();
        this.getCCHRoles();
        this.getSections();
        this.getSubSections();
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
        updateRoles: function () {
            this.getCCHRoles();
            return true;
        },
        updateSections: function() {
            this.getSections();
            return true;
        },
        updateSubsections: function() {
            this.getSubSections();
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

        getCCHRoles: function () {
            this.$http.get('/gfcare/chn-on-the-go/system/roles')
                .success(function (roles) {
                    this.$broadcast('cchRolesRetrieved', roles);
                });
        },

        getSections: function () {
            var self = this;
            this.$http.get('/gfcare/chn-on-the-go/content/poc/sections')
                .success(function (res) {
                    var sections = res.content;
                    sections.sort(function(a,b) { 
                        var x = a.name.toLowerCase();
                        var y = b.name.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('sectionsRetrieved', sections);
                });
        },
        getSubSections: function () {
            var self = this;
            this.$http.get('/gfcare/chn-on-the-go/content/poc/subsections')
                .success(function (res) {
                    var subsections = res.content;
                    subsections.sort(function(a,b) { 
                        var x = a.section.toLowerCase() + ' ' + a.name.toLowerCase();
                        var y = b.section.toLowerCase() + ' ' + b.name.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('subsectionsRetrieved', subsections);
                });
        },
    },
    
    filters: { },
});
