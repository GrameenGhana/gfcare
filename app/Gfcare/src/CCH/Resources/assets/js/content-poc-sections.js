Vue.component('gfcare-cch-content-poc-section-screen', {

    ready: function() {
    },

    data: function() {
        return {
            sections: [],
            editingSection: {'name':''},
            removingSectionId: null,
             
            forms: {
                addSection: new SparkForm({  
                    name: '',  
                    icon_file: '',
                    file_name: '',
                }),
                updateSection: new SparkForm({                    
                    name: '',  
                    icon_file: '',
                    file_name: '',
                }),
            }
        };
    },
    
    events: {
        sectionsRetrieved: function (sections) {
            this.sections = sections;
            return true;
        },
    },

    computed: {},

    methods: {
        
        getImageUrl: function(section) {
            return '/gfcare/chn-on-the-go/content/image/section/'+section.id;    
        },
        
        removingSection: function(id) { return (this.removingSectionId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        addSection: function () {  
            this.forms.addSection.name = '';
            this.forms.addSection.icon_file = '';
            $('#modal-add-section').modal('show');  
        },

        editSection: function (sec) { 
            this.editingSection = sec; 
            this.forms.updateSection.name = sec.name;
            $('#modal-edit-section').modal('show'); 
        },
        
        // Ajax calls
        getSections: function () {
            var self = this;
            this.$http.get('/gfcare/chn-on-the-go/content/poc/sections')
                .success(function (res) {
                    self.sections = res;
                    self.sections.sort(function(a,b) { 
                        var x = a.name.toLowerCase();
                        var y = b.name.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('sectionsRetrieved', self.sections);
                });
        },

        addNewSection: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/content/poc/sections', this.forms.addSection)
                .then(function () {
                    $('#modal-add-section').modal('hide');
                    self.$dispatch('updateSections');
                });
        }, 

        updateSection: function () {
            var self = this;
            Spark.put('/gfcare/chn-on-the-go/content/poc/sections/' + this.editingSection.id, this.forms.updateSection)
                .then(function () {
                    $('#modal-edit-section').modal('hide');
                    self.$dispatch('updateSections');
                });
        },     

        removeSection: function (sec) {
            var self = this;
            self.removingSectionId = sec.id;
            
            this.$http.delete('/gfcare/chn-on-the-go/content/poc/sections/' + sec.id)
                .success(function () {
                    self.removingSectionId = 0;
                    self.sections = self.removeFromList(this.sections, sec);
                    self.$dispatch('updateSections');
                })
                .error(function(resp) {
                    self.removingSectionId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
    },
    
    filters: {

    },
});
