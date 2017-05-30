window.NotificationStore = {
  state: [], // here the notifications will be added

  addNotification: function (notification) {
    this.state.push(notification)
  },
  removeNotification: function (notification) {
    this.state.$remove(notification)
  }
};

window.Notification = Vue.extend({
  template: '<div class="notification callout animated" :class="notification.type ? notification.type : \'secondary\'" > \
        <button @click="triggerClose(notification)" class="btn btn-xs pull-right" :class="notification.type ? notification.type : \'secondary\'" style="border:non"> \
          <span><i class="fa fa-times"></i> </span>\
        </button> \
        <h5 v-if="notification.title">{{notification.title}}</h5><p>{{notification.text}}</p>\
      </div>',
  props: ['notification'],
  data: function () {
  	return { timer: null }
  },
  ready: function () {
      let timeout = this.notification.hasOwnProperty('timeout') ? this.notification.timeout : true
      if (timeout) {
        let delay = this.notification.delay || 3000
          this.timer = setTimeout(function () {
            this.triggerClose(this.notification)
          }.bind(this), delay)
        }
  },

  methods: {
    triggerClose: function (notification) {
    	clearTimeout(this.timer)
        this.$dispatch('close-notification', notification)
    }
  }
})

window.Notifications = Vue.extend({
    template: '<div class="notifications">\
        <notification v-for="notification in notifications" :notification="notification" @close-notification="removeNotification"\ transition="fade"> </notification></div>',
    components: {
        notification: Notification
    },
    data () {
        return {
          notifications: NotificationStore.state
        }
    },
    methods: {
        removeNotification: function (notification) {
          NotificationStore.removeNotification(notification)
        }
    }
})

Vue.transition('fade', {
  enterClass: 'fadeInDown', // class of animate.css
  leaveClass: 'fadeOutDown' // class of animate.css
})
