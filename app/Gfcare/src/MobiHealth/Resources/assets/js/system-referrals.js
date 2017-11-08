Vue.component('gfcare-mobi-system-referral-screen', {

    ready: function() {
        this.getReferrals();
    },

    data: function() {
        return {
            users: [],
            supervisors: [],
            volunteers: [],
            referrals: [],

            editingReferral: {'name':'none'},
            removingReferralId: null,
            
            yesNoOptions: [{'text': 'Yes', value: 1}, {'text':'No','value':0}],
            
            userOptions: [],
            
            forms: {
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
        updateReferrals: function () {
            this.getReferrals();
            return true;
        },
        mobihealthUsersRetrieved: function(users) {
            this.users = users;
            this.supervisors =[]; 
            this.volunteers =[]; 
            for(var i=0; i < users.length; i++) {
                if (users[i].role=='Volunteer') {
                    this.volunteers.push({'text': users[i].name, 'value':users[i].id});
                } else {
                    if (users[i].user_type=='User') {
                        this.supervisors.push({'text': users[i].name, 'value':users[i].id});
                    }
                }
            }
            return true;
        },
    },

    computed: { },

    methods: {
        addReferral: function () {  
            this.forms.addReferral.mhv = '';
            this.forms.addReferral.supervisor = '';
            $('#modal-add-referral').modal('show');  
        },

        editReferral: function (d) { 
            this.editingReferral = d;
            this.forms.updateReferral.mhv = d.mhv;
            this.forms.updateReferral.supervisor = d.supervisor;
            $('#modal-edit-referral').modal('show'); 
        },
        
        removingReferral: function(id) { return (this.removingReferralId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
                               
        // Ajax calls
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
            Spark.put('/gfcare/mobihealth/system/referrals/' + this.editingReferral.id, this.forms.updateReferral)
                .then(function () {
                    $('#modal-edit-referral').modal('hide');
                    self.$dispatch('updateReferrals');
                });
        },              

        removeReferral: function (referral) {
            var self = this;
            self.removingReferralId = referral.id;
            
            this.$http.delete('/gfcare/mobihealth/system/referrals/' + referral.id)
                .success(function () {
                    self.removingReferralId = 0;
                    self.referrals = self.removeFromList(this.referrals, referral);
                    self.$dispatch('updateReferrals');
                })
                .error(function(resp) {
                    self.removingReferralId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
        
        getReferrals: function () {
            var self = this;
            this.$http.get('/gfcare/mobihealth/system/referrals')
                .success(function (referrals) {
                    self.referrals = referrals;
                    self.referrals.sort(function(a,b) { 
                        var x = a.volunteer_name.toLowerCase();
                        var y = b.volunteer_name.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('mobihealthReferralsRetrieved', self.referrals);
                });
        },
    },
    
    filters: { 
    
    },
});
