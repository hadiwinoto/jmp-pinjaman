/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require("./bootstrap");
import Vue from "vue";
window.Vue = Vue;

import { BootstrapVue } from "bootstrap-vue";
import vClickOutside from "v-click-outside";
import VueMask from "v-mask";
import Vuelidate from "vuelidate";
import VueApexCharts from "vue-apexcharts";
import * as VueGoogleMaps from "vue2-google-maps";
import VueSweetalert2 from "vue-sweetalert2";
import i18n from "./i18n";
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueElementLoading from "vue-element-loading";
import VTooltip from 'v-tooltip';
import 'sweetalert2/dist/sweetalert2.min.css';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';



Vue.use(ElementUI);
Vue.component('v-select', vSelect);
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.use(VTooltip)


// Import the CSS or use your own!
import VueAWN from 'vue-awesome-notifications'
import 'vue-awesome-notifications/dist/styles/style.css'
const option_alert = {
    position: 'bottom-right',
    labels: {
        success: 'Ok',
        alert: 'Oops...'
    },
    duration: 700
};
Vue.use(VueAWN, option_alert);



Vue.prototype.$isDev = process.env.MIX_APP_ENV !== "production";
Vue.config.devtools = Vue.prototype.$isDev;
Vue.config.debug = Vue.prototype.$isDev;
Vue.config.silent = !Vue.prototype.$isDev;
import tinymce from "vue-tinymce-editor";

Vue.use(VueAxios, axios)

Vue.use(BootstrapVue);
Vue.use(vClickOutside);
Vue.use(VueMask);
Vue.use(Vuelidate);
Vue.use(require("vue-chartist"));
Vue.use(VueSweetalert2);
Vue.component("VueElementLoading", VueElementLoading);
Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyAbvyBxmMbFhrzP9Z8moyYr6dCr-pzjhBE",
        libraries: "places"
    },
    installComponents: true
});

Vue.component("apexchart", VueApexCharts);
Vue.component("tinymce", tinymce);
Vue.component(
    "dynamic-component",
    require("./components/dynamic-component").default
);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import "./views";
import Layouts from "./mixins/layouts.mixin";

const app = new Vue({
    el: "#app",
    mixins: [Layouts],
    i18n
});
