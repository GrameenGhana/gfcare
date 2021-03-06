Vue.component('gfcare-noyawa-client-screen', {

    ready: function() {
        this.getNoyawaClients();
    },

    data: function() {
        return {
            users: [],
            clients: [],
            editingClient: {'name':'none'},
            removingClientId: null,
            
            yesNoOptions: [{'text': 'Yes', value: 1}, {'text':'No','value':0}],
            
            userOptions: [],
            
            forms: {
                addClient: new SparkForm ({
                    user_id: '',
                    name: '',
                    registered: '',
                }),
                
                updateClient: new SparkForm ({
                    user_id: '',
                    name: '',
                    registered: '',
                }),
            }
        };
    },
    
    events: {
        updateClients: function () {
            this.getNoyawaClients();
            return true;
        },
        noyawaUsersRetrieved: function(users) {
            this.users = users;
            this.userOptions =[]; 
            for(var i=0; i < users.length; i++) {
                if (users[i].role=='Volunteer') {
                    this.userOptions.push({'text': users[i].name, 'value':users[i].id});
                }
            }
            return true;
        },
    },

    computed: { },

    methods: {
        addClient: function () {  
            this.forms.addClient.name = '';
            this.forms.addClient.user_id = '';
            this.forms.addClient.registered = 0;
            $('#modal-add-client').modal('show');  
        },

        editClient: function (d) { 
            this.editingClient = d;
            this.forms.updateClient.name = d.name;
            this.forms.updateClient.user_id = d.user_id;
            this.forms.updateClient.registered= d.registered;
            $('#modal-edit-client').modal('show'); 
        },
        
        removingClient: function(id) { return (this.removingClientId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
                               
        // Ajax calls
        addNewClient: function () {
            var self = this;
            Spark.post('/gfcare/noyawa/clients', this.forms.addClient)
                .then(function () {
                    $('#modal-add-client').modal('hide');
                    self.$dispatch('updateClients');
                });
        },       

        updateClient: function () {
            var self = this;
            Spark.put('/gfcare/noyawa/clients/' + this.editingClient.id, this.forms.updateClient)
                .then(function () {
                    $('#modal-edit-client').modal('hide');
                    self.$dispatch('updateClients');
                });
        },              

        removeClient: function (client) {
            var self = this;
            self.removingClientId = client.id;
            
            this.$http.delete('/gfcare/noyawa/clients/' + client.id)
                .success(function () {
                    self.removingClientId = 0;
                    self.clients = self.removeFromList(this.clients, client);
                    self.$dispatch('updateClients');
                })
                .error(function(resp) {
                    self.removingClientId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
        
        getNoyawaClients: function () {
            var self = this;
            this.$http.get('/gfcare/noyawa/clients')
                .success(function (clients) {
                    self.clients = clients;
                    console.log(clients);
                    self.clients.sort(function(a,b) { 
                        var x = a.lastname.toLowerCase();
                        var y = b.lastname.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('noyawaClientsRetrieved', self.clients);
                });
        },

    },
    
    filters: { 
        registration_status: function(r) { return (r) ? 'Registered' : 'Not Registered'; },
        registration_date_status: function(c) { return (c.registered==0) ? 'Not registered' : c.registration_date; },
    
    },
});
