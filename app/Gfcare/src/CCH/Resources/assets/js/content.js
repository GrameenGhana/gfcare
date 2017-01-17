Vue.component('gfcare-cch-content-screen', {

    ready: function() {
        this.getReferences();
        this.getPages();
        this.getSections();
    },

    data: function() {
        return {
            team: null,
            user: null,
            users: null,
 
            pages: [],
            sections: [],
            references: [],
         
            editingPage: {'name':'none'},
            editingSection: {'upload':[]},

            removingPageId: null,
            removingSectionId: null,
             
            pageTypeOptions: [
                {'text': 'Take Action Page', 'value':'Take Action Page'}, 
                {'text': 'Take Action Classification Page', 'value':'Take Action Classification Page'}, 
                {'text': 'Question Page', 'value':'Question Page'}, 
                {'text': 'Info Page', 'value':'Info Page'}, 
                {'text': 'Reference Page', 'value':'Reference Page'}, 
                {'text': 'Calculator Page', 'value':'Calculator Page'}, 
            ],
            
            subSectionOptions: [
                {'text': 'ANC Diagnostic', 'value':'ANC Diagnostic'}, 
                {'text': 'ANC Counselling', 'value':'ANC Counselling'}, 
                {'text': 'ANC References', 'value':'ANC References'}, 
                {'text': 'PNC Diagnostic Newborn', 'value':'PNC Diagnostic Newborn'}, 
                {'text': 'PNC Diagnostic Mother', 'value':'PNC Diagnostic Mother'},                
                {'text': 'PNC Counselling', 'value':'PNC Counselling'}, 
                {'text': 'PNC References', 'value':'PNC References'},
                {'text': 'CWC Diagnostic', 'value':'CWC Diagnostic'}, 
                {'text': 'CWC Counselling', 'value':'CWC Counselling'}, 
                {'text': 'CWC References', 'value':'CWC References'},
                {'text': 'CWC Calculators', 'value':'CWC Calculators'},
            ],
            
            sectionOptions: [],
                        
            forms: {
                addPage: new SparkForm({  
                    type: '',
                    section: '',
                    name: '',
                    shortname: '',
                    subtitle: '',
                    description: '',
                }),
                updatePage: new SparkForm({ 
                    type: '',
                    section: '',
                    name: '',
                    shortname: '',
                    subtitle: '',
                    description: '',  
                }),
                
                addSection: new SparkForm({  
                    name: '',  
                    shortname: '', 
                    sub_section: '',
                    description: '',
                    reference_file: '',
                }),
                updateSection: new SparkForm({                    
                    name: '',  
                    shortname: '', 
                    sub_section: '',
                    description: '',
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
        updatePages: function () {
            this.getPages();
            return true;
        },
        updateSections: function () {
            this.getSections();
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
        addPage: function () {   
            this.forms.addPage.type ='';
            this.forms.addPage.section ='';
            this.forms.addPage.name ='';
            this.forms.addPage.shortname ='';
            this.forms.addPage.subtitle ='';
            this.forms.addPage.description ='';
            $('#modal-add-page').modal('show');  
        },
        editPage: function (page) { 
            this.editingPage = page;
            this.forms.addPage.type = page.type;
            this.forms.addPage.section = page.section;
            this.forms.addPage.name = page.name;
            this.forms.addPage.shortname = page.shortname;
            this.forms.addPage.subtitle = page.subtitle;
            this.forms.addPage.description = page.description;
            $('#modal-edit-page').modal('show'); 
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
        
        
        removingPage: function(id) { return (this.removingPageId == id); },
        removingSection: function(id) { return (this.removingSectionId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
        
        // Ajax calls
        getPages: function () {
            this.$http.get('/gfcare/chn-on-the-go/content/poc/pages')
                .success(function (res) {
                    this.pages = res;
                    this.pages.sort(function(a,b) { 
                        var x = a.section.toLowerCase() + a.type;
                        var y = b.section.toLowerCase() + b.type;
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    this.$broadcast('updatePages', res);
                });
        },
        addNewPage: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/content/poc/pages', this.forms.addPage)
                .then(function () {
                    $('#modal-add-page').modal('hide');
                    self.$dispatch('updatePages');
                });
        }, 
        updatePage: function () {
            var self = this;
            Spark.put('/gfcare/chn-on-the-go/content/poc/pages/' + this.editingPage.id, this.forms.updatePage)
                .then(function () {
                    $('#modal-edit-page').modal('hide');
                    self.$dispatch('updatePages');
                });
        },     
        removePage: function (page) {
            var self = this;
            self.removingPageId = user.id;
            
            this.$http.delete('/gfcare/chn-on-the-go/content/poc/pages/' + page.id)
                .success(function () {
                    self.removingPageId = 0;
                    self.pages = self.removeFromList(this.pages, page);
                    self.$dispatch('updatePages');
                })
                .error(function(resp) {
                    self.removingPageId = 0;
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
                            self.sectionOptions.push({'text': self.sections[i].sub_section + ' > ' + self.sections[i].name, 
                                                      'value':self.sections[i].name});
                    }
                    self.sectionOptions.sort(function(a,b) { 
                        var x = a.text;
                        var y = b.text;
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
