Vue.component('gfcare-cch-system-screen', {

    ready: function() {
        this.getCCHRoles();
        this.getCCHDevices();
    },

    data: function() {
        return {
            team: null,
            facilities: null,
            user: null,
            users: null,
 
            roles: [],
            devices: [],
         
            editingUser: {'name':'none'},
            editingRole: {'name':'none'},
            editingDevice: {'name':'none'},

            removingUserId: null,
            removingRoleId: null,
            removingDeviceId: null,
            
            yesNoOptions: [{'text': 'Yes', value: 1}, {'text':'No','value':0}],
            
            roleOptions: [],
            deviceOptions: [],
            facOptions: [],
            
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
            
            deviceStatusOptions: [
                {'text':'Unallocated','value':'unallocated'},
                {'text':'In active use','value':'active'},
                {'text':'Under repair','value':'repair'},
                {'text':'Deactivated','value':'deactivated'},
                {'text':'Damaged','value':'damaged'},
                {'text':'Lost or stolen','value':'lost_stolen'},
                {'text':'Unknown','value':'unknown'},
            ],
                        
            forms: {
                addRole: new SparkForm({  name: '',  is_editor: 0,  }),
                updateRole: new SparkForm({ name: '',  is_editor: 0,  }),
                
                addUser: new SparkForm ({
                    name: '',
                    email: '',
                    password: '',
                    phone_number: '',
                    gender: '',
                    title: '',
                    ischn: '',
                    status: '',
                    role:'',
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
                    role:'',
                    primary_facility: '',
                    supervised_facility: [],
                }),
                
                addDevice: new SparkForm ({
                    type: '',
                    tag: '',
                    color: '',
                    imei: '',
                }),
                
                updateDevice: new SparkForm ({
                    type: '',
                    tag: '',
                    color: '',
                    imei: '',
                    status: '',
                }),
            }
        };
    },
    
    events: {
        updateRoles: function () {
            this.getCCHRoles();
            return true;
        },
        updateDevices: function () {
            this.getCCHDevices();
            return true;
        },
        userRetrieved: function (user) {
            this.user = user;
            return true;
        },
        cchUsersRetrieved: function(users) {
            this.users = users;
            return true;
        },
        teamRetrieved: function (team) {
            this.team = team;
            return true;
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
            return this.user && this.team && this.facilities;
        },
    },

    methods: {
        addRole: function () {  
            this.forms.addRole.name = '';
            this.forms.addRole.is_editor = 0;
            $('#modal-add-role').modal('show');  
        },
        editRole: function (role) { 
            this.editingRole = role;
            this.forms.updateRole.name = role.name;
            this.forms.updateRole.is_editor = role.is_editor;
            $('#modal-edit-role').modal('show'); 
        },
        
        addUser: function () {  
            this.forms.addUser.name = '';
            this.forms.addUser.email = '';
            this.forms.addUser.password = '';
            this.forms.addUser.phone_number = '';
            this.forms.addUser.gender = '';
            this.forms.addUser.title = '';
            this.forms.addUser.ischn = 0;
            this.forms.addUser.status = '';
            this.forms.addUser.role = '';
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
            this.forms.updateUser.role = user.role;
            this.forms.updateUser.device = (user.device!==null) ? user.device.id : '';
            this.forms.updateUser.primary_facility = this.primaryFacilityId(user.facility);
            this.forms.updateUser.supervised_facility = this.supervisedFacilities(user.facility);
            $('#modal-edit-user').modal('show'); 
        },
        
        addDevice: function () {  
            this.forms.addDevice.type = '';
            this.forms.addDevice.tag = '';
            this.forms.addDevice.color = '';
            this.forms.addDevice.imei = '';
            $('#modal-add-device').modal('show');  
        },
        editDevice: function (d) { 
            this.editingDevice = d;
            this.forms.updateDevice.type = d.type;
            this.forms.updateDevice.tag= d.tag;
            this.forms.updateDevice.color = d.color;
            this.forms.updateDevice.imei = d.imei;
            this.forms.updateDevice.status = d.status;
            $('#modal-edit-device').modal('show'); 
        },
        
        removingRole: function(id) { return (this.removingRoleId == id); },
        removingUser: function(id) { return (this.removingUserId == id); },
        removingDevice: function(id) { return (this.removingDeviceId == id); },

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
            Spark.post('/gfcare/chn-on-the-go/system/users', this.forms.addUser)
                .then(function () {
                    $('#modal-add-user').modal('hide');
                    self.$dispatch('updateUsers');
                });
        },       
        updateUser: function () {
            var self = this;
            Spark.put('/gfcare/chn-on-the-go/system/users/' + this.editingUser.id, this.forms.updateUser)
                .then(function () {
                    $('#modal-edit-user').modal('hide');
                    self.$dispatch('updateUsers');
                    self.$dispatch('updateDevices');
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
                })
                .error(function(resp) {
                    self.removingUserId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
                
        addNewRole: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/system/roles', this.forms.addRole)
                .then(function () {
                    $('#modal-add-role').modal('hide');
                    self.$dispatch('updateRoles');
                });
        },     
        updateRole: function () {
            var self = this;
            Spark.put('/gfcare/chn-on-the-go/system/roles/' + this.editingRole.id, this.forms.updateRole)
                .then(function () {
                    $('#modal-edit-role').modal('hide');
                    self.$dispatch('updateRoles');
                });
        },               
        removeRole: function (role) {
            var self = this;
            self.removingRoleId = role.id;
            
            this.$http.delete('/gfcare/chn-on-the-go/system/roles/' + role.id)
                .success(function () {
                    self.removingRoleId = 0;
                    self.roles = self.removeFromList(this.roles, role);
                    self.$dispatch('updateRoles');
                })
                .error(function(resp) {
                    self.removingRoleId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
        
        addNewDevice: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/system/devices', this.forms.addDevice)
                .then(function () {
                    $('#modal-add-device').modal('hide');
                    self.$dispatch('updateDevices');
                });
        },       
        updateDevice: function () {
            var self = this;
            Spark.put('/gfcare/chn-on-the-go/system/devices/' + this.editingDevice.id, this.forms.updateDevice)
                .then(function () {
                    $('#modal-edit-device').modal('hide');
                    self.$dispatch('updateDevices');
                });
        },              
        removeDevice: function (device) {
            var self = this;
            self.removingDeviceId = device.id;
            
            this.$http.delete('/gfcare/chn-on-the-go/system/devices/' + device.id)
                .success(function () {
                    self.removingDeviceId = 0;
                    self.devices = self.removeFromList(this.devices, device);
                    self.$dispatch('updateDevices');
                })
                .error(function(resp) {
                    self.removingDeviceId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
        
        getCCHRoles: function () {
            this.$http.get('/gfcare/chn-on-the-go/system/roles')
                .success(function (roles) {
                    this.roles = roles;
                    this.roleOptions =[]; 
                    for(var i=0; i < this.roles.length; ++i) {
                        this.roleOptions.push({'text': this.roles[i].name, 'value':this.roles[i].name});
                    }
                    this.$broadcast('cchRolesRetrieved', roles);
                });
        },
        getCCHDevices: function () {
            var self = this;
            this.$http.get('/gfcare/chn-on-the-go/system/devices')
                .success(function (devices) {
                    self.devices = devices;
                    self.devices.sort(function(a,b) { 
                        var x = a.type.toLowerCase();
                        var y = b.type.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.deviceOptions = []; 
                    for(var i=0; i < self.devices.length; ++i) {
                        if (self.devices[i].status=='unallocated') {
                            self.deviceOptions.push({'text': self.devices[i].type + ' (' + 
                                                             self.devices[i].tag + ' - ' + self.devices[i].imei + ')', 
                                                     'value':self.devices[i].id});
                        }
                    }
                    this.$broadcast('cchDevicesRetrieved', devices);
                });
        },
    },
    
    filters: {
        role_is_editor: function (value) {
            return (value) ? 'Yes' : 'No';
        },
        
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
        
        device_owner: function(user_id) {
              var l = null;
              var f = null;
              if (user_id != 0) {
                  l = _.find(this.users, function (u) {
                      return u.id == user_id;
                  });
                  if (l!=null) {
                    f = _.find(l.facility, function (fac) {
                        return fac.primary == 1;
                    });
                  }
              }
              return (l==null) ? 'Not assigned' : l.name + ((f==null) ? '' : ' (' + f.facility.name +')' );
        },
            
        device_status: function (status) {
            var l = _.find(this.deviceStatusOptions, function(opt) {
                        return opt['value']==status; 
            });
            return (l==null) ? 'No status' : l['text'];
        },
    },
});
