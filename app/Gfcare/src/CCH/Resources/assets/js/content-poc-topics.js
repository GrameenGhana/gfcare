Vue.component('gfcare-cch-content-poc-topic-screen', {

    ready: function() {
        this.getTopics();
    },

    data: function() {
        return {
            topics: [],
            editingTopic: {'upload':[]},
            removingTopicId: null,
             
            subSectionOptions: [],
            
            forms: {
                addTopic: new SparkForm({  
                    sub_section_id: '',
                    name: '',
                    shortname: '',
                    description: '',
                    upload_file: '',
                    file_name: '',
                }),
                updateTopic: new SparkForm({ 
                    sub_section_id: '',
                    name: '',
                    shortname: '',
                    description: '',
                    upload_file: '',
                    file_name: '',
                }),
            }
        };
    },
    
    events: {
        updateTopics: function () {
            this.getTopics();
            return true;
        },
        subsectionsRetrieved: function (subsections) {
            this.subSectionOptions = []; 
            for(var i=0; i < subsections.length; ++i) {
                    this.subSectionOptions.push({'text': subsections[i].section +' > '+subsections[i].name, 'value':subsections[i].id});
            }
            this.subSectionOptions.sort(function(a,b) { 
                var x = a.text; var y = b.text;
                return (x < y) ? -1 : ((x > y) ? 1 : 0);
            });
            return true;
        },
    },

    computed: {
    },

    methods: {
        addTopic: function () {   
            this.forms.addTopic.sub_section_id ='';
            this.forms.addTopic.name ='';
            this.forms.addTopic.shortname ='';
            this.forms.addTopic.description ='';
            $('#modal-add-topic').modal('show');  
        },

        editTopic: function (topic) { 
            this.editingTopic = topic;
            this.forms.updateTopic.sub_section_id = topic.sub_section_id;
            this.forms.updateTopic.name = topic.name;
            this.forms.updateTopic.shortname = topic.shortname;
            this.forms.updateTopic.description = topic.description;
            $('#modal-edit-topic').modal('show'); 
        },
        
        removingTopic: function(id) { return (this.removingTopicId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
        
        // Ajax calls
        getTopics: function () {
            var self  = this;
            this.$http.get('/gfcare/chn-on-the-go/content/poc/topics')
                .success(function (res) {
                    self.topics = res.content;
                    self.topics.sort(function(a,b) { 
                        var x = a.section.toLowerCase() + a.sub_section;
                        var y = b.section.toLowerCase() + b.sub_section;
                        return (x < y) ? -1 : ((x > y) ? 1 : 0);
                    });
                    self.$broadcast('topicsRetrieved', self.topics);
                });
        },

        addNewTopic: function () {
            var self = this;
            Spark.post('/gfcare/chn-on-the-go/content/poc/topics', this.forms.addTopic)
                .then(function () {
                    $('#modal-add-topic').modal('hide');
                    self.$dispatch('updateSubsections');
                    self.$dispatch('updateTopics');
                });
        }, 

        updateTopic: function () {
            var self = this;
            Spark.put('/gfcare/chn-on-the-go/content/poc/topics/' + this.editingTopic.id, this.forms.updateTopic)
                .then(function () {
                    $('#modal-edit-topic').modal('hide');
                    self.$dispatch('updateSubsections');
                    self.$dispatch('updateTopics');
                });
        },     

        removeTopic: function (topic) {
            var self = this;
            self.removingTopicId = topic.id;
            
            this.$http.delete('/gfcare/chn-on-the-go/content/poc/topics/' + topic.id)
                .success(function () {
                    self.removingTopicId = 0;
                    self.topics = self.removeFromList(this.topics, topic);
                    self.$dispatch('updateSubsections');
                    self.$dispatch('updateTopics');
                })
                .error(function(resp) {
                    self.removingTopicId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
    },
    
    filters: {

    },
});
