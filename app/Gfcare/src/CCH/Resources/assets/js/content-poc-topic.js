Vue.component('gfcare-cch-content-screen', {

    ready: function() {
        this.getReferences();
        this.getSections();
        this.getSubSections();
        this.getTopics();
    },

    data: function() {
        return {
            team: null,
            user: null,
            users: null,
 
            topics: [],
            sections: [],
            subsections: [],
            references: [],
         
            editingSection: {'name':''},
            editingSubSection: {'name':''},
            editingTopic: {'upload':[]},

            removingSectionId: null,
            removingSubSectionId: null,
            removingTopicId: null,
             
            sectionOptions: [ ],
            subSectionOptions: [],
            
            forms: {
                addTopic: new SparkForm({  
                    sub_section_id: '',
                    name: '',
                    shortname: '',
                    description: '',
                    reference_file: '',
                }),
                updateTopic: new SparkForm({ 
                    sub_section_id: '',
                    name: '',
                    shortname: '',
                    description: '',
                    reference_file: '',
                }),
                
                addSection: new SparkForm({  
                    name: '',  
                    reference_file: '',
                }),
                updateSection: new SparkForm({                    
                    name: '',  
                    reference_file: '',
                }),

                addSubSection: new SparkForm({  
                    name: '',  
                    section_id: '',  
                    reference_file: '',
                }),
                updateSubSection: new SparkForm({                    
                    name: '',  
                    section_id: '',  
                    reference_file: '',
                }),
                
                addReference: new SparkForm({reference_desc: '', reference_file: '',shortname:'',}),
            }
        };
    },
    
    events: {
        updateReferences: function () {
            this.getReferences();
            return true;
        },
        updateTopics: function () {
            this.getTopics();
            return true;
        },
        updateSections: function () {
            this.getSections();
            return true;
        },      

        updateSubSections: function () {
            this.getSubSections();
            return true;
        },      

        userRetrieved: function (user) {
            this.user = user;
            return true;
        },

        teamRetrieved: function (team) {
            this.team = team;
            return true;
        },
    },

    computed: {
        everythingIsLoaded: function () {
            return this.user && this.team;
        },
    },

    methods: {
        addTopic: function () {   
            this.forms.addTopic.type ='';
            this.forms.addTopic.section ='';
            this.forms.addTopic.name ='';
            this.forms.addTopic.shortname ='';
            this.forms.addTopic.subtitle ='';
            this.forms.addTopic.description ='';
            $('#modal-add-topic').modal('show');  
        },
        editTopic: function (topic) { 
            this.editingTopic = topic;
            this.forms.addTopic.type = topic.type;
            this.forms.addTopic.section = topic.section;
            this.forms.addTopic.name = topic.name;
            this.forms.addTopic.shortname = topic.shortname;
            this.forms.addTopic.subtitle = topic.subtitle;
            this.forms.addTopic.description = topic.description;
            $('#modal-edit-topic').modal('show'); 
        },
        
        addSection: function () {  
            this.forms.addSection.name = '';
            this.forms.addSection.shortname = '';
            this.forms.addSection.sub_section = '';
            this.forms.addSection.description = '';
            this.forms.addSection.reference_file = '';
            $('#modal-add-section').modal('show');  
        },
        editSection: function (sec) { 
            this.editingSection = sec; 
            this.forms.updateSection.name = sec.name;
            this.forms.updateSection.shortname = sec.shortname;
            this.forms.updateSection.sub_section = sec.sub_section;
            this.forms.updateSection.description = sec.description;
            $('#modal-edit-section').modal('show'); 
        },
        
        addReference: function () {  
            this.forms.addReference.reference_desc = '';
            this.forms.addReference.reference_file = '';
            this.forms.addReference.shortname = '';
            $('#modal-add-reference').modal('show');  
        },
        
        
        removingTopic: function(id) { return (this.removingTopicId == id); },
        removingSection: function(id) { return (this.removingSectionId == id); },
        removingSubSection: function(id) { return (this.removingSubSectionId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
        
        // Ajax calls
        getTopics: function () {
            this.$http.get('/gfcare/chn-on-the-go/content/poc/topics')
                .success(function (res) {
                    this.topics = res;
                    this.topics.sort(function(a,b) { 
                        var x = a.section.toLowerCase() + a.sub_section;
                        var y = b.section.toLowerCase() + b.sub_section;
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    this.$broadcast('updateTopics', res);
                });
        },
        addNewTopic: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/content/poc/topics', this.forms.addTopic)
                .then(function () {
                    $('#modal-add-topic').modal('hide');
                    self.$dispatch('updateTopics');
                });
        }, 
        updateTopic: function () {
            var self = this;
            Spark.put('/gfcare/chn-on-the-go/content/poc/topics/' + this.editingTopic.id, this.forms.updateTopic)
                .then(function () {
                    $('#modal-edit-topic').modal('hide');
                    self.$dispatch('updateTopics');
                });
        },     
        removeTopic: function (topic) {
            var self = this;
            self.removingTopicId = user.id;
            
            this.$http.delete('/gfcare/chn-on-the-go/content/poc/topics/' + topic.id)
                .success(function () {
                    self.removingTopicId = 0;
                    self.topics = self.removeFromList(this.topics, topic);
                    self.$dispatch('updateTopics');
                })
                .error(function(resp) {
                    self.removingTopicId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
                
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
                    self.sectionOptions = []; 
                    for(var i=0; i < self.sections.length; ++i) {
                            self.sectionOptions.push({'text': self.sections[i].name, 'value':self.sections[i].id});
                    }
                    self.sectionOptions.sort(function(a,b) { 
                        var x = a.text; var y = b.text;
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    this.$broadcast('updateSections', res);
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

        getSubSections: function () {
            var self = this;
            this.$http.get('/gfcare/chn-on-the-go/content/poc/subsections')
                .success(function (res) {
                    self.subsections = res;
                    self.subsections.sort(function(a,b) { 
                        var x = a.section + ' ' + a.name.toLowerCase();
                        var y = a.section + ' ' + b.name.toLowerCase();
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.subsectionOptions = []; 
                    for(var i=0; i < self.subsections.length; ++i) {
                            self.subsectionOptions.push({'text': self.subsections[i].section +' > '+self.subsections[i].name, 'value':self.subsections[i].id});
                    }
                    self.subsectionOptions.sort(function(a,b) { 
                        var x = a.text; var y = b.text;
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    this.$broadcast('updateSubSections', res);
                });
        },
        addNewSubSection: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/content/poc/subsections', this.forms.addSubSection)
                .then(function () {
                    $('#modal-add-subsection').modal('hide');
                    self.$dispatch('updateSubSections');
                });
        }, 
        updateSubSection: function () {
            var self = this;
            Spark.put('/gfcare/chn-on-the-go/content/poc/subsections/' + this.editingSubSection.id, this.forms.updateSubSection)
                .then(function () {
                    $('#modal-edit-subsection').modal('hide');
                    self.$dispatch('updateSubSections');
                });
        },     
        removeSubSection: function (sec) {
            var self = this;
            self.removingSubSectionId = sec.id;
            
            this.$http.delete('/gfcare/chn-on-the-go/content/poc/subsections/' + sec.id)
                .success(function () {
                    self.removingSubSectionId = 0;
                    self.subsections = self.removeFromList(this.subsections, sec);
                    self.$dispatch('updateSubSections');
                })
                .error(function(resp) {
                    self.removingSubSectionId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },

        getReferences: function () {
            this.$http.get('/gfcare/chn-on-the-go/content/lc/references')
                .success(function (refs) {
                    this.references = refs;
                    this.$broadcast('updateReferences', refs);
                });
        },
        addNewReference: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/content/references', this.forms.addReference)
                .then(function () {
                    $('#modal-add-reference').modal('hide');
                    self.$dispatch('updateReferences');
                });
        }, 
    },
    
    filters: {

    },
});
