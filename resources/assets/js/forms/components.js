
Vue.component('spark-text', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="text" class="form-control spark-first-field" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

Vue.component('spark-hidden', {
    props: ['display', 'form', 'name', 'input'],
    template: '<input type="hidden" class="form-control" v-model="input" />'
});

Vue.component('spark-email', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="email" class="form-control spark-first-field" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)"> \
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

Vue.component('spark-file', {
    props: ['display', 'form', 'name', 'input','warning'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="file" class="form-control spark-first-field" @change="onFileChange">\
        <p class="help-block"><span style="color: red">{{ warning }}</span> </p>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>',
    
    methods: {
        onFileChange(e) {
          var files = e.target.files || e.dataTransfer.files;
          if (!files.length)
            return;
           this.createFile(files[0]);
        },
        createFile(file) {
            var reader = new FileReader();
            var vm = this;
            reader.onload = (e) => {
                vm.input = e.target.result                
            };
            reader.readAsDataURL(file);
        },
    },
});

Vue.component('spark-password', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="password" class="form-control spark-first-field" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

Vue.component('spark-shortname', {
    props: ['display', 'form', 'name', 'input', 'source'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="text" class="form-control spark-first-field" v-model="input">\
        <span class="btn-warning btn-circle" style="cursor:pointer" id="generate" @click.prevent="createShortName">Generate short name</span> \
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>',
    
    methods: {
          createShortName: function() {
            var lower = $.trim(this.source.toLowerCase()); // to lower case
            var hyp = lower.replace(/ /g,"_");  
            var value=hyp.replace (/[`~!@#$%^&*()|+\-=?;:'",.<>\{\}\[\]\\\/]/g,"");
            this.input = value;
        },
    }
    
});


Vue.component('spark-select', {
    props: ['display', 'form', 'name', 'items', 'input','placetext'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <select class="form-control spark-first-field" v-model="input" :placeholder="placetext">\
            <option v-for="item in items" :value="item.value">\
                {{ item.text }}\
            </option>\
        </select>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

Vue.component('spark-multi-select', {
    props: ['display', 'form', 'name', 'items', 'input', 'fieldlabel', 'placetext'],

    components: {
        'v-select': vSelect
    },
    
    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
        <label class="col-md-4 control-label">{{ display }}</label>\
        <div class="col-md-6">\
          <v-select \
                :debounce="250" \
                :options="items" \
                :multiple="true" \
                :value.sync="input" \
                :placeholder="placetext" \
                :label="fieldlabel"></v-select> \
            <span class="help-block" v-show="form.errors.has(name)">\
                <strong>{{ form.errors.get(name) }}</strong>\
            </span>\
        </div>\
    </div>',
});

Vue.component('spark-location-select', {
    props: ['display', 'form', 'name', 'teamId', 'input'],
    
    components: {
        'v-select': vSelect
    },

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}"> \
                <label class="col-md-4 control-label">{{ display }}</label> \
                <div class="col-md-3"> \
                    <v-select :value.sync="selectedType" :options="locationTypes"\
                              :on-change="getLocations" placeholder="Select location type"></v-select>\
                </div>\
                <div class="col-md-5">\
                    <v-select \
                        :debounce="250" \
                        :options="locations" \
                        :value.sync="selectedLocation" \
                        placeholder="Select location" \
                        label="name"></v-select> \
                    <span class="help-block" v-show="form.errors.has(name)">\
                        <strong>{{ form.errors.get(name) }}</strong>\
                    </span>\
                </div>\
            </div>',
    
    ready: function() {
        this.getLocationTypes();
    },
              
    data: function() {
        return {
            locations: null,
            locationTypes: null,
            selectedType: null,
            selectedLocation: null,
        };
    },
              
    watch: {
        'selectedLocation': function (val) {
            this.input = (val===null) ? "" : val.id;
        }
    },
        
    methods: {
      getLocationTypes: function() {
        this.$http.get('/gfcare/api/teams/locationtypes').then(resp => {
           this.locationTypes = resp.data.geopolitical;
           this.selectedLocation = "";
           this.selectedType = this.locationTypes[0];
        })
      },    
          
      getLocations: function() {
        this.$http.get('/gfcare/api/teams/' + this.teamId + '/locations/' + this.selectedType).then(resp => {
           this.locations = resp.data;
           this.selectedLocation = (this.locations.length>0) ? this.locations[0] : "" ;
        })
      }
    }
});

Vue.component('spark-facility-select', {
    props: ['display', 'form', 'name', 'teamId', 'input'],
    
    components: {
        'v-select': vSelect
    },

    template: '<spark-location-select :display="\'Location\'" \
                                      :form="form" \
                                      :name="\'location_id\'" \
                                      :team-id="teamId" \
                                      :input.sync="selectedLocation"> \
                </spark-location-select>\
                <div class="form-group" :class="{\'has-error\': form.errors.has(name)}"> \
                <label class="col-md-4 control-label">{{ display }}</label> \
                <div class="col-md-12">\
                    <v-select \
                        :debounce="250" \
                        :options="facilities" \
                        :multiple="true" \
                        :value.sync="selectedFacilities" \
                        placeholder="Select facilities" \
                        label="name"></v-select> \
                    <span class="help-block" v-show="form.errors.has(name)">\
                        <strong>{{ form.errors.get(name) }}</strong>\
                    </span>\
                </div>\
            </div>',
    
    ready: function() {
    },
              
    data: function() {
        return {
            facilities: null,
            facilityTypes: null,
            selectedLocation: null,
            selectedFacilities: null,
        };
    },
              
    watch: {
        'selectedLocation': function (val) {
            if (!(val==null)) {
                this.getFacilities(val);
            }
        },
        'selectedFacilities': function (val) {
            this.input = (val===null) ? "" : val;
        }
    },
        
    methods: {
      getFacilityTypes: function() {
        this.$http.get('/gfcare/api/teams/locationtypes').then(resp => {
           this.facilityTypes = resp.data.facilities;
        })
      },    
          
      getFacilities: function(locationId) {
        this.$http.get('/gfcare/api/teams/' + this.teamId + '/facilities/' + locationId).then(resp => {
            this.facilities = resp.data;
        })
      }
    }
});