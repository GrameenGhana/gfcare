Vue.component('gfcare-mobi-system-screen', {

    ready: function() {
        this.getRoles();
        this.getReferrals();
    },

    data: function() {
        return {
            team: null,
            facilities: null,
            user: null,
            users: null,
            volunteers: null,
            supervisors: null,
 
            roles: [],
            referrals: [],
         
            editingUser: {'name':'none'},
            editingReferral: {'name':'none'},

            removingUserId: null,
            removingReferralId: null,
            
            yesNoOptions: [{'text': 'Yes', value: 1}, {'text':'No','value':0}],
            
            roleOptions: [],
            facOptions:[],
            
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
                    role:'',
                    primary_facility: '',
                }),
                
                updateUser: new SparkForm ({
                    name: '',
                    email: '',
                    password: '',
                    current_password: '',
                    phone_number: '',
                    gender: '',
                    title: '',
                    ischn: '',
                    status: '',
                    role:'',
                    primary_facility: '',
                }),
                
                addReferral: new SparkForm ({
                    mhv: '',
                    supervisor: '',
                }),
                
                updateReferral: new SparkForm ({
                    mhv: '',
                    supervisor: '',
                }),
            }
        };
    },
    
    events: {
        updateRoles: function () {
            this.getRoles();
            return true;
        },
        updateReferrals: function () {
            this.getReferrals();
            return true;
        },
        userRetrieved: function (user) {
            this.user = user;
            return true;
        },
        mobiUsersRetrieved: function(users) {
            this.users = users;
            var mus = this.moduleUsers();
            this.supervisors = [];
            this.volunteers = [];
            for(var i=0; i<mus.length; i++) {
                if (mus[i].role=='Supervisor') {
                    this.supervisors.push({'text': mus[i].name, 'value': mus[i].id});
                } else {
                    this.volunteers.push({'text': mus[i].name, 'value': mus[i].id});
                }
            }
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
            this.forms.addUser.primary_facility = '';
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
            this.forms.updateUser.primary_facility = this.primaryFacilityId(user.facility);
            $('#modal-edit-user').modal('show'); 
        },
        
        addReferral: function () {  
            this.forms.addReferral.mhv = '';
            this.forms.addReferral.supervisor = '';
            $('#modal-add-referral').modal('show');  
        },
        editReferral: function (r) { 
            this.editingReferral = r;
            this.forms.updateReferral.mhv = r.mhv;
            this.forms.updateDevice.supervisor= r.supervisor;
            $('#modal-edit-dreferral').modal('show'); 
        },
        
        removingUser: function(id) { return (this.removingUserId == id); },
        removingReferral: function(id) { return (this.removingReferralId == id); },

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
             
        // Ajax calls
        addNewUser: function () {
            var self = this;
            Spark.post('/gfcare/mobihealth/system/users', this.forms.addUser)
                .then(function () {
                    $('#modal-add-user').modal('hide');
                    self.$dispatch('updateUsers');
                });
        },       
        updateUser: function () {
            var self = this;
            Spark.put('/gfcare/mobihealth/system/users/' + this.editingUser.id, this.forms.updateUser)
                .then(function () {
                    $('#modal-edit-user').modal('hide');
                    self.$dispatch('updateUsers');
                });
        },     
        removeUser: function (user) {
            var self = this;
            self.removingUserId = user.id;
            
            this.$http.delete('/gfcare/mobihealth/system/users/' + user.id)
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
                
        addNewReferral: function () {
            var self = this;
            Spark.post('/gfcare/mobihealth/system/referrals', this.forms.addReferral)
                .then(function () {
                    $('#modal-add-referral').modal('hide');
                    self.$dispatch('updateReferrals');
                });
        },     
        updateReferral: function () {
            var self = this;
            Spark.put('/gfcare/mobihealth/system/roles/' + this.editingReferral.id, this.forms.updateReferral)
                .then(function () {
                    $('#modal-edit-referral').modal('hide');
                    self.$dispatch('updateReferrals');
                });
        },               
        removeReferral: function (r) {
            var self = this;
            self.removingRoleId = r.id;
            
            this.$http.delete('/gfcare/mobihealth/system/referrals/' + r.id)
                .success(function () {
                    self.removingReferralId = 0;
                    self.referrals = self.removeFromList(this.referrals, r);
                    self.$dispatch('updateReferrals');
                })
                .error(function(resp) {
                    self.removingReferralId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
                
        getRoles: function () {
            this.$http.get('/gfcare/mobihealth/system/roles')
                .success(function (roles) {
                    this.roles = roles;
                    this.roleOptions =[]; 
                    for(var i=0; i < this.roles.length; ++i) {
                        this.roleOptions.push({'text': this.roles[i].name, 'value':this.roles[i].name});
                    }
                    this.$broadcast('mobiRolesRetrieved', roles);
                });
        },
        getReferrals: function () {
            var self = this;
            this.$http.get('/gfcare/mobihealth/system/referrals')
                .success(function (rs) {
                    self.referrals = rs;
                    this.$broadcast('mobiReferralsRetrieved', rs);
                });
        },
    },
    
    filters: {
        role_is_editor: function (value) {
            return (value) ? 'Yes' : 'No';
        },
        
        user_name: function (value) {
            var l = _.find(this.users, function (u) {
                        return u.id == value;
            });
            return (l==null) ? 'Unknown' : l.name;  
        },
        
        user_details_facilities: function(user) {
            var l = _.find(user.facility, function (fac) {
                        return fac.primary == 1;
            });
            return (l==null) ? 'None' : l.facility.name;
        },
    },
});
