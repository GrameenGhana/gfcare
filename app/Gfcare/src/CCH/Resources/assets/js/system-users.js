Vue.component('gfcare-cch-system-user-screen', {
    props: ['teamId'],

    ready: function() { 
    },

    data: function() {
        return {
            users: null,
            teamUsers: null,
            userIds: [],
 
            editingUser: {'name':'none'},

            removingUserId: null,
            
            roleOptions: [],
            userOptions: [],
            
            forms: {
                addUser: new SparkForm ({
                    user_id: '',
                    role: '',
                }),
                
                updateUser: new SparkForm ({
                    role:'',
                }),
            }
        };
    },
    
    events: {
        updateTeamUsers: function() {
            this.getTeamUsers();
            return true;
        },
        cchUsersRetrieved: function(users) {
            this.users = users;
            this.userIds =[]; 
            for(var i=0; i < users.length; ++i) {
                this.userIds.push(users[i].id);
            }
            this.getTeamUsers();
            return true;
        },
        teamUsersRetrieved: function(users) {
            return true;
        },
        cchRolesRetrieved: function(roles) {
             this.roleOptions =[]; 
             for(var i=0; i < roles.length; ++i) {
                 this.roleOptions.push({'text': roles[i].name, 'value':roles[i].name});
             }
        },
    },

    computed: {
        everythingIsLoaded: function () {
            return this.users.length >0 && this.roleOptions.length>0;
        },
    },

    methods: {
        addUser: function () {  
            this.forms.addUser.user_id = '';
            this.forms.addUser.role = '';
            $('#modal-add-user').modal('show');  
        },

        editUser: function (user) { 
            this.editingUser = user;
            this.forms.updateUser.user_id = user.id;
            this.forms.updateUser.role = user.role;
            $('#modal-edit-user').modal('show'); 
        },
        
        removingUser: function(id) { return (this.removingUserId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        isInArray: function(item, array) { 
            return !! ~$.inArray(item, array); 
        },

        moduleUsers: function () {
            return (this.users==null) ? [] : this.users.filter(function (u) { return u.user_type === 'User'; })
        },
        
        systemUsers: function () {
            return (this.users==null) ? [] : this.users.filter(function (u) { return u.user_type != 'User'; })
        },
        
        // Ajax calls
        addNewUser: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/system/users', this.forms.addUser)
                .then(function () {
                    $('#modal-add-user').modal('hide');
                    self.$dispatch('updateUsers');
                    self.$dispatch('updateTeamUsers');
                });
        },       

        updateUser: function () {
            var self = this;
            Spark.put('/gfcare/chn-on-the-go/system/users/' + this.editingUser.id, this.forms.updateUser)
                .then(function () {
                    $('#modal-edit-user').modal('hide');
                    self.$dispatch('updateUsers');
                    self.$dispatch('updateTeamUsers');
                });
        },     

        removeUser: function (user) {
            var self = this;
            self.removingUserId = user.id;
            
            this.$http.delete('/gfcare/chn-on-the-go/system/users/' + user.id)
                .success(function () {
                    self.removingUserId = 0;
                    self.users = self.removeFromList(this.users, user);
                    self.$dispatch('updateUsers');
                    self.$dispatch('updateTeamUsers');
                })
                .error(function(resp) {
                    self.removingUserId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
        getTeamUsers: function () {
            var self = this;
            this.$http.get('/gfcare/api/teams/'+ this.teamId + '/users')
                .success(function (users) {
                    this.teamUsers = users;
                    this.userOptions =[]; 
                    for(var i=0; i < this.teamUsers.length; i++) {
                        if ($.inArray(this.teamUsers[i].id, this.userIds)==-1) {
                            this.userOptions.push({'text': this.teamUsers[i].name, 'value':this.teamUsers[i].id});
                        }
                    }
                    self.$dispatch('teamUsersRetrieved', users);
                });
        },
    },
    
    filters: {
        user_details_facilities: function(user) {
            var l = _.find(user.facility, function (fac) {
                        return fac.primary == 1;
            });
            return (l==null) ? 'None' : l.facility.name;
        },
        
        user_details_supervised: function(user) {
            var names = "";
            for(var i=0; i < user.facility.length; i++) {
                if (user.facility[i].supervised) {
                    names = (names + ((names==""? '': ', ')) + user.facility[i].facility.name);
                }
            }
            return (names=="") ? "No facilities" : names;
        },
        
        user_details_devices: function(user) {
            return (user.device==null) ? 'None issued' : user.device.type + ' (' + user.device.imei +')';
        },
    },
});
