var Vue = require('vue');
var VueResource = require('vue-resource');
var moment = require('moment');
var VueMomentJS = require('vue-momentjs');
var Vue2TouchEvents  = require('vue2-touch-events');
var VueApexCharts   = require('vue-apexcharts');

var main = require('./components/main.vue')
var category = require('./components/words/category.vue')
var learn = require('./components/words/learn.vue')
var learnCheck = require('./components/words/learn-check.vue')
var packRow = require('./components/words/pack-row.vue')

Vue.use(VueResource);
Vue.use(VueMomentJS, moment);
Vue.use(Vue2TouchEvents);
Vue.component('apexchart', VueApexCharts)

new Vue({
    el: '.vue-block',
    data: function () {
       return {
           selectedRow:[]
       }
    },
    components: {
        'main-page' : main,
        'category' : category,
        'learn' : learn,
        'learn-check' : learnCheck,
        'pack-row' : packRow,
    },
    methods: {
        selectrow(row){
            if(this.selectedRow.indexOf(row) !== -1){
                delete this.selectedRow[this.selectedRow.indexOf(row)];
                var newArr = [];
                this.selectedRow.forEach(function (item) {
                    if(item != null)
                        newArr.push(item);
                })
                this.selectedRow = newArr

            }
            else
                this.selectedRow.push(row)
            console.log(this.selectedRow)
        }
    },
    created: function () {
        this.$moment.locale('ru')
    }
});