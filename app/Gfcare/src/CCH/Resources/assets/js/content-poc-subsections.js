Vue.component('gfcare-cch-content-poc-subsection-screen', {

    ready: function() {
        //this.getSubSections();
    },

    data: function() {
        return {
            subsections: [],
            editingSubSection: {'name':''},
            removingSubSectionId: null,
             
            sectionOptions: [],
            
            forms: {
                addSubSection: new SparkForm({  
                    name: '',  
                    section_id: '',  
                    file_name: '',
                    icon_file: '',
                }),
                updateSubSection: new SparkForm({                    
                    name: '',  
                    section_id: '',  
                    file_name: '',
                    icon_file: '',
                }),
            }
        };
    },
    
    events: {
        sectionsRetrieved: function (sections) {
            this.sectionOptions = []; 
            for(var i=0; i < sections.length; ++i) {
                this.sectionOptions.push({'text': sections[i].name, 'value':sections[i].id});
            }
            this.sectionOptions.sort(function(a,b) { 
                 var x = a.text; var y = b.text;
                 return (x < y) ? -1 : ((x > y) ? 1 : 0);
            });
            return true;
        },
        
        subsectionsRetrieved: function(subsections) {
            this.subsections = subsections;
        },
    },

    computed: { },

    methods: {
        getImageUrl: function(subsection) {
            return '/gfcare/chn-on-the-go/content/image/subsection/'+subsection.id;    
        },
        
        addSubSection: function () {   
            this.forms.addSubSection.sub_section_id ='';
            this.forms.addSubSection.name ='';
            this.forms.addSubSection.shortname ='';
            this.forms.addSubSection.description ='';
            $('#modal-add-subsection').modal('show');  
        },

        editSubSection: function (topic) { 
            this.editingTopic = topic;
            this.forms.updateSubSection.sub_section_id = topic.sub_section_id;
            this.forms.updateSubSection.name = topic.name;
            this.forms.updateSubSection.shortname = topic.shortname;
            this.forms.updateSubSection.description = topic.description;
            $('#modal-edit-subsection').modal('show'); 
        },
        
        removingSubSection: function(id) { return (this.removingSubSectionId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
        
        // Ajax calls
        getSubSections: function () {
            var self = this;
            this.$http.get('/gfcare/chn-on-the-go/content/poc/subsections')
                .success(function (res) {
                    self.subsections = res;
                    self.subsections.sort(function(a,b) { 
                        var x = a.section.toLowerCase() + ' ' + a.name.toLowerCase();
                        var y = b.section.toLowerCase() + ' ' + b.name.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('subsectionsRetrieved', self.subsections);
                });
        },

        addNewSubSection: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/content/poc/subsections', this.forms.addSubSection)
                .then(function () {
                    $('#modal-add-subsection').modal('hide');
                    self.$dispatch('updateSections');
                    self.$dispatch('updateSubsections');
                });
        }, 

        updateSubSection: function () {
            var self = this;
            Spark.put('/gfcare/chn-on-the-go/content/poc/subsections/' + this.editingSubSection.id, this.forms.updateSubSection)
                .then(function () {
                    $('#modal-edit-subsection').modal('hide');
                    self.$dispatch('updateSections');
                    self.$dispatch('updateSubsections');
                });
        },     

        removeSubSection: function (sec) {
            var self = this;
            self.removingSubSectionId = sec.id;
            
            this.$http.delete('/gfcare/chn-on-the-go/content/poc/subsections/' + sec.id)
                .success(function () {
                    self.removingSubSectionId = 0;
                    self.subsections = self.removeFromList(this.subsections, sec);
                    self.$dispatch('updateSections');
                    self.$dispatch('updateSubsections');
                })
                .error(function(resp) {
                    self.removingSubSectionId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
    },
    
    filters: {

    },
});
