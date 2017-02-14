Vue.component('spark-team-settings-user-screen', {

    ready: function() {
    },

    data: function() {
        return {
            users: null,
            facilities: null,
 
            editingUser: {'name':'none'},

            removingRoleId: null,
            
            facOptions: [],
            deviceOptions: [],
            yesNoOptions: [{'text': 'Yes', value: 1}, {'text':'No','value':0}],
            
            genderOptions: [
                {'text': 'Female', 'value':'female'}, 
                {'text': 'Male', 'value':'male'}, 
                {'text': 'Transgender', 'value':'transgender'}, 
                {'text': 'Un Specified', 'value':'unspecified'}
            ],
            
            statusOptions: [
                {'text':'Active', 'value':'ACTIVE'}, 
                {'text':'In-Active', 'value':'INACTIVE'},
                {'text':'Test', 'value':'TEST'}
            ],
            
            forms: {
                addUser: new SparkForm ({
                    name: '',
                    email: '',
                    password: '',
                    phone_number: '',
                    gender: '',
                    title: '',
                    ischn: '',
                    status: '',
                    device: '',
                    primary_facility: '',
                    supervised_facility: [],
                }),
                
                updateUser: new SparkForm ({
                    name: '',
                    email: '',
                    password: '',
                    current_password: '',
                    device: '', 
                    phone_number: '',
                    gender: '',
                    title: '',
                    ischn: '',
                    status: '',
                    primary_facility: '',
                    supervised_facility: [],
                }),
            }
        };
    },
    
    events: {
        usersRetrieved: function(users) {
            this.users = users;
            return true;
        },

        devicesRetrieved: function(devices) {
             this.deviceOptions =[]; 
             for(var i=0; i < devices.length; ++i) {
                 if (devices[i].status=='unallocated') {
                     this.deviceOptions.push({'text': devices[i].type + ' (' + 
                                                      devices[i].tag + ' - ' + devices[i].imei + ')', 
                                              'value':devices[i].id});
                 }
             }
        },

        facilitiesRetrieved: function (facs) {
            this.facilities = facs.slice(0)
            this.facilities.sort(function(a,b) { 
                var x = a.type.toLowerCase();
                var y = b.type.toLowerCase();
                return (x < y) ? -1 : ((x > y) ? 1 : 0);
            });
        
            for(var i=0; i < this.facilities.length; ++i) {
                this.facOptions.push({'text': this.facilities[i].type + ': ' + this.facilities[i].name, 
                                      'value': this.facilities[i].id});
            }
            return true;
        },
    },

    computed: {
        everythingIsLoaded: function () {
            return this.users.length >0 && this.facilities.length>0; 
        },
    },

    methods: {
        addUser: function () {  
            this.forms.addUser.name = '';
            this.forms.addUser.email = '';
            this.forms.addUser.password = '';
            this.forms.addUser.phone_number = '';
            this.forms.addUser.gender = '';
            this.forms.addUser.title = '';
            this.forms.addUser.ischn = 0;
            this.forms.addUser.status = '';
            this.forms.addUser.device = '';
            this.forms.addUser.primary_facility = '';
            this.forms.addUser.supervised_facility = [];
            $('#modal-add-user').modal('show');  
        },

        editUser: function (user) { 
            this.editingUser = user;
            this.forms.updateUser.name = user.name;
            this.forms.updateUser.email = user.email;
            this.forms.updateUser.password = '';
            this.forms.updateUser.phone_number = user.phone_number;
            this.forms.updateUser.gender = user.info.gender;
            this.forms.updateUser.title = user.info.title;
            this.forms.updateUser.ischn = user.info.ischn;
            this.forms.updateUser.status = user.info.status;
            this.forms.updateUser.device = (user.device!==null) ? user.device.id : '';
            this.forms.updateUser.primary_facility = this.primaryFacilityId(user.facility);
            this.forms.updateUser.supervised_facility = this.supervisedFacilities(user.facility);
            $('#modal-edit-user').modal('show'); 
        },
        
        removingUser: function(id) { return (this.removingUserId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
                               
        moduleUsers: function () {
            return (this.users==null) ? [] : this.users.filter(function (u) { return u.user_type === 'User'; })
        },
        
        systemUsers: function () {
            return (this.users==null) ? [] : this.users.filter(function (u) { return u.user_type != 'User'; })
        },
        
        primaryFacilityId: function(facs) {
            if (facs.length >0) {
                var l = _.find(facs, function (fac) {
                        return fac.primary == 1;
                });
                return (l==null) ? 0 : l.facility.id;
            } else {
                return 0;
            }
        },
        
        supervisedFacilities: function(facs) {
            if (facs.length >0) {
                var l = _.find(facs, function (fac) { return fac.supervised == 1; });
                if (l==null) {        return []; }
                var f = [];
                for(var i=0; i < l.length; i++) {
                    f.push(l[i].facility);
                }    
                return f;
            } else {
                return [];
            }
        },
             
        // Ajax calls
        addNewUser: function () {
            var self = this;
            Spark.post('/gfcare/settings/teams/users', this.forms.addUser)
                .then(function () {
                    $('#modal-add-user').modal('hide');
                    self.$dispatch('updateUsers');
                });
        },       

        updateUser: function () {
            var self = this;
            Spark.put('/gfcare/settings/teams/users/' + this.editingUser.id, this.forms.updateUser)
                .then(function () {
                    $('#modal-edit-user').modal('hide');
                    self.$dispatch('updateUsers');
                    self.$dispatch('updateDevices');
                });
        },     

        removeUser: function (user) {
            var self = this;
            self.removingUserId = user.id;
            
            this.$http.delete('/gfcare/settings/teams/users/' + user.id)
                .success(function () {
                    self.removingUserId = 0;
                    self.users = self.removeFromList(this.users, user);
                    self.$dispatch('updateUsers');
                })
                .error(function(resp) {
                    self.removingUserId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
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
