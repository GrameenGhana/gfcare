Vue.component('gfcare-cch-system-role-screen', {

    ready: function() {
        this.getCCHRoles();
    },

    data: function() {
        return {
            roles: [],
         
            editingRole: {'name':'none'},
            removingRoleId: null,
            
            yesNoOptions: [{'text': 'Yes', value: 1}, {'text':'No','value':0}],
            
            forms: {
                addRole: new SparkForm({  name: '',  is_editor: 0,  }),
                updateRole: new SparkForm({ name: '',  is_editor: 0,  }),
            }
        };
    },
    
    events: {
        updateRoles: function () {
            this.getCCHRoles();
            return true;
        },
    },

    computed: { }, 

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
        
        removingRole: function(id) { return (this.removingRoleId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
                               
             
        // Ajax calls
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
        
        getCCHRoles: function () {
            var self = this;
            this.$http.get('/gfcare/chn-on-the-go/system/roles')
                .success(function (roles) {
                    self.roles = roles;
                    self.$broadcast('cchRolesRetrieved', self.roles);
                });
        },
    },
    
    filters: {
        role_is_editor: function (value) {
            return (value) ? 'Yes' : 'No';
        },
    },
});
