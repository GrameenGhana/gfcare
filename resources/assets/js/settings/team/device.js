Vue.component('spark-team-settings-device-screen', {

    ready: function() {
    },

    data: function() {
        return {
            users: [],
            devices: [],
            editingDevice: {'name':'none'},
            removingDeviceId: null,
            
            yesNoOptions: [{'text': 'Yes', value: 1}, {'text':'No','value':0}],
            
            deviceOptions: [],
            
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
        devicesRetrieved: function(devices) {
             this.devices = devices;
             this.deviceOptions =[]; 
             for(var i=0; i < devices.length; ++i) {
                 if (devices[i].status=='unallocated') {
                     this.deviceOptions.push({'text': devices[i].type + ' (' + 
                                                      devices[i].tag + ' - ' + devices[i].imei + ')', 
                                              'value':devices[i].id});
                 }
             }
             return true;
        },

        usersRetrieved: function(users) {
            this.users = users;
            return true;
        },
    },

    computed: { },

    methods: {
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
        
        removingDevice: function(id) { return (this.removingDeviceId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
                               
        // Ajax calls
        addNewDevice: function () {
            var self = this;
            Spark.post('/gfcare/settings/teams/devices', this.forms.addDevice)
                .then(function () {
                    $('#modal-add-device').modal('hide');
                    self.$dispatch('updateDevices');
                });
        },       

        updateDevice: function () {
            var self = this;
            Spark.put('/gfcare/settings/teams/devices/' + this.editingDevice.id, this.forms.updateDevice)
                .then(function () {
                    $('#modal-edit-device').modal('hide');
                    self.$dispatch('updateDevices');
                });
        },              

        removeDevice: function (device) {
            var self = this;
            self.removingDeviceId = device.id;
            
            this.$http.delete('/gfcare/settings/teams/devices/' + device.id)
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
        
    },
    
    filters: {
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
            var l = _.find(this.deviceStatusOptions, function(opt) { return opt['value']==status; });
            return (l==null) ? 'No status' : l['text'];
        },
    },
});
