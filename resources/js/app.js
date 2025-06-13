import './bootstrap';
import '../css/app.css';

import Vue from 'vue';
import Vuetify from 'vuetify';
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import { createInertiaApp } from '@inertiajs/vue2';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import $ from 'jquery';
window.$ = $;
window.jQuery = $

const vuetify = new Vuetify({
    icons: {
        iconfont: 'mdi',
    },
})

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),

    setup({ el, App, props, plugin }) {
        // Add route function.
        // Register Inertia
        Vue.use(plugin);
        Vue.use(ZiggyVue, Ziggy);
        Vue.use(Vuetify);
        Vue.use(BootstrapVue)
        Vue.use(IconsPlugin)
        return new Vue({ render: h => h(App, props), vuetify }).$mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
