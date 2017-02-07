Vue.component('gfcare-cch-content-references-screen', {

    ready: function() {
        this.getReferences();
    },

    data: function() {
        return {
            references: [],
            removingReferenceId: null,
            forms: {
                addReference: new SparkForm({reference_desc: '', reference_file: '',shortname:'',}),
            }
        };
    },
    
    events: {
        updateReferences: function () {
            this.getReferences();
            return true;
        },
    },

    computed: { },

    methods: {
        addReference: function () {  
            this.forms.addReference.reference_desc = '';
            this.forms.addReference.reference_file = '';
            this.forms.addReference.shortname = '';
            $('#modal-add-reference').modal('show');  
        },
        
        removingReference: function(id) { return (this.removingReferenceId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
        
        // Ajax calls
        addNewReference: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/content/references', this.forms.addReference)
                .then(function () {
                    $('#modal-add-reference').modal('hide');
                    self.$dispatch('updateReferences');
                });
        }, 

        removeReference: function (reference) {
            var self = this;
            self.removingReferenceId = reference.id;
            
            this.$http.delete('/gfcare/chn-on-the-go/content/ls/references/' + reference.id)
                .success(function () {
                    self.removingReferenceId = 0;
                    self.references = self.removeFromList(self.references, reference);
                    self.$dispatch('updateReferences');
                })
                .error(function(resp) {
                    self.removingReferenceId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
                
        getReferences: function () {
            this.$http.get('/gfcare/chn-on-the-go/content/lc/references')
                .success(function (refs) {
                    this.references = refs;
                    this.$broadcast('referencesRetrieved', refs);
                });
        },
    },
    
    filters: {

    },
});
