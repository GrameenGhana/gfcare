Vue.component('spark-team-settings-module-screen', {
    /*
     * Bootstrap the component. Load the initial data.
     */
    ready: function () {
        this.initializeTooltips();
    },

    /*
     * Initial state of the component's data.
     */
    data: function () {
        return {
            user: null,
            team: null,
            modules: [],
            switchingStatus: false,
            addingModule: false,
            removingModule: false,
        };
    },


    computed: {
        /*
         * Determine if all necessary data has been loaded.
         */
        everythingIsLoaded: function () {
            return this.user && this.team && this.modules.length > 0;
        },

        /*
         * Get all users except for the current user.
         */
        modulesExceptMine: function () {
            var self = this;
            return _.reject(self.modules, function (module) {
                    var exists = self.team.modules.some(function (m) {
                        return m.module_id === module.id;
                    }); 
                    return exists;
            });
    }
},


events: {
    /*
     * Handle the "userRetrieved" event.
     */
    userRetrieved: function (user) {
        this.user = user;
        return true;
    },

    /*
     * Handle the "teamRetrieved" event.
     */
    teamRetrieved: function (team) {
        this.team = team;
        return true;
    },

    /*
     * Handle the "modulesRetrieved" event.
     */
    modulesRetrieved: function (modules) {
        this.modules = modules;
        return true;
    },
},


methods: {
    /*
     * Initialize the tooltips for the plan features.
     */
    initializeTooltips: function () {
        setTimeout(function () {
            $('[data-toggle="tooltip"]').tooltip({
                html: true
            });
        }, 250);
    },

    /*
     * Add a module to a project.
     */
    addModule: function (module) {
        var self = this;
        self.addingModule = true;
        this.$http.post('/gfcare/settings/teams/' + this.team.id + '/modules', module)
            .success(function () {
                self.addingModule = false;
                self.$dispatch('updateTeam');
                self.$dispatch('updateTeams');
            });
    },

    /*
     * Switch existing module status.
     */
    switchStatus: function (module) {
        var self = this;
        self.switchingStatus = true;
        this.$http.get('/gfcare/settings/teams/'+ this.team.id + '/modules/' + module.id + '/switch')
            .success(function () {
                self.switchingStatus = false;
                self.$dispatch('updateTeam');
                self.$dispatch('updateTeams');
            });
    },

    /*
     * Remove an existing module.
     */
    removeModule: function (module) {
        var self = this;
        self.removeModuleFromList(module);
        self.removingModule = true;
        this.$http.delete('/gfcare/settings/teams/' + this.team.id + '/modules/' + module.id)
            .success(function () {
                self.removingModule = false;
                self.$dispatch('updateTeam');
                self.$dispatch('updateTeams');
            });
    },

    /*
     * Remove a module from the current list of modules.
     */
    removeModuleFromList: function (module) {
        this.team.modules = _.reject(this.team.modules, function (i) {
            return i.id === module.id;
        });
    },

    /*
     * Determine if the current user owns the given team.
     */
    userOwns: function (team) {
        if (!this.user) {
            return false;
        }
        return this.user.id === team.owner_id;
    }
},

filters: {
    /**
     * Filter the module to its displayable name.
     */
    module: function (value) {
        return _.find(this.modules, function (module) {
            return module.id == value;
        }).name;
    },

    module_description: function (value) {
        return _.find(this.modules, function (module) {
            return module.id == value;
        }).description;
    }
}
});
