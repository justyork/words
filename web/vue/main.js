var Vue = require('vue');
var VueResource = require('vue-resource');
var moment = require('moment');
var VueMomentJS = require('vue-momentjs');
var Vue2TouchEvents  = require('vue2-touch-events');

var learn = require('./components/words/learn.vue')
var learnCheck = require('./components/words/learn-check.vue')

Vue.use(VueResource);
Vue.use(VueMomentJS, moment);
Vue.use(Vue2TouchEvents);

new Vue({
    el: '.vue-block',
    data: function () {
       return {
       }
    },
    components: {
        'learn' : learn,
        'learn-check' : learnCheck,
    },
    methods: {

    },
    created: function () {
        this.$moment.locale('ru')
    }
});