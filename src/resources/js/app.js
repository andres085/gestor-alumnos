require('./bootstrap');

import { createApp } from 'vue';

import App from './components/App.vue';

const app = createApp({

});

app.component('example-component', App);

app.mount('#app');