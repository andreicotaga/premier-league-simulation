/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue').default;

import VueTailwind from 'vue-tailwind'
import axios from "axios";
import store from "./store";
import EventBus from "./EventBus/EventBus";

import "tailwindcss/tailwind.css"

import {
    TInput,
    TTextarea,
    TSelect,
    TRadio,
    TCheckbox,
    TButton,
    TInputGroup,
    TCard,
    TAlert,
    TModal,
    TDropdown,
    TRichSelect,
    TPagination,
    TTag,
    TRadioGroup,
    TCheckboxGroup,
    TTable,
    TDatepicker,
    TToggle,
    TDialog,
} from 'vue-tailwind/dist/components';

const components = {
    TInput,
    TTextarea,
    TSelect,
    TRadio,
    TCheckbox,
    TButton,
    TInputGroup,
    TCard,
    TAlert,
    TModal,
    TDropdown,
    TRichSelect,
    TPagination,
    TTag,
    TRadioGroup,
    TCheckboxGroup,
    TTable,
    TDatepicker,
    TToggle,
    TDialog,
}

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('league-table-component', require('./components/LeagueTableComponent.vue').default);
Vue.component('prediction-component', require('./components/PredictionComponent.vue').default);
Vue.component('match-result-component', require('./components/MatchResultComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueTailwind, components)

Vue.prototype.$bus = EventBus;

const app = new Vue({
    el: '#app',
    store,
    axios,
});

export default app;
