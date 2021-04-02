
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.queryString = require('query-string');

import Multiselect from 'vue-multiselect';
require('vue-multiselect/dist/vue-multiselect.min.css');
Vue.component('multiselect', Multiselect);

const app = new Vue({
    el: '#app',

    data: {
        showFilter: false,
        location_name: [],
        selected_types: [],
        types: [],
        locations: [],
        events: [],
        loadingEvents: false,
    },

    async created () {
        var parsed = queryString.parse(window.location.search, {arrayFormat: 'bracket'});

        await this.getEvents(
            parsed.query || ''
        );

        await this.getLocations();
        await this.getTypes();

        this.location_name = queryString.parse(parsed.query ? parsed.query : '', {arrayFormat: 'index'}).location_name
        this.selected_types = queryString.parse(parsed.query ? parsed.query : '', {arrayFormat: 'index'}).selected_types
    },

    methods: {
        getEvents (query) {
            this.loadingEvents = true;

            var query = query || {};

            return axios.get(`/api/events?${query}`).then(response => {
                this.events = response.data;
                this.loadingEvents = false;
            });
        },

        async getLocations () {
            const getLocationsResponse = await axios.get(`/api/locations`);

            this.locations = getLocationsResponse.data;
        },

        async getTypes () {
            const getTypesResponse = await axios.get(`/api/types`);

            this.types = getTypesResponse.data;
        },

        filter () {
            this.events = [];

            var query = {};

            if (this.location_name) {
                query.location_name = this.location_name;
            }

            if (this.selected_types) {
                query.selected_types = this.selected_types;
            }

            if (jQuery.param(query)) {
                window.history.replaceState(null, null, '?query=' + queryString.stringify(query, {arrayFormat: 'index'}));
            } else {
                window.history.replaceState(null, null, '/');
            }

            this.getEvents(jQuery.param(query));
        }
    }
});
