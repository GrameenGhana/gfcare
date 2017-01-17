Vue.component('spark-nav-bar-topbar', $.extend(true, {
    /*
     * Initial state of the component's data.
     */
    data: function () {
        return {
            user: null,
            currentTeam: null,
            activeModulesList: [],
        };
    },


    events: {
        /**
         * Handle the "userRetrieved" event.
         */
        userRetrieved: function (user) {
            this.user = user;
            return true;
        },

        /**
         * Handle the "currentTeamRetrieved" event.
         */
        currentTeamRetrieved: function (team) {
            var self = this;
            this.currentTeam = team;
            this.activeModulesList = [{link:'/gfcare/home', name:'Home', class: ''}];
            if (this.currentTeam) {
                this.activeModulesList.push({link: '/gfcare/settings/teams/'+this.currentTeam.id, name: this.currentTeam.name + ' > ', class:''});
                _.each(this.currentTeam.modules, function (m) {
                    if (m.active) { 
                        self.activeModulesList.push({link: '/gfcare/settings/teams/switchmodule/'+m.id, name: m.menu_name, class:'module'});
                    }
                });
                if (this.currentTeam && this.activeModulesList.length < 3) {
                    this.activeModulesList[1].name = this.currentTeam.name; 
                }
            }
            return true;
        },
    },

    
}, Spark.components.navTopbar));
