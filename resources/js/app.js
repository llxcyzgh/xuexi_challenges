import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './views/App'
import Index from './views/Index'
import Edit from './views/Edit'
import Add from './views/Add'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'index',
            component: Index
        },
        {
            path: '/edit',
            name: 'edit',
            component: Edit
        },
        {
            path: '/add',
            name: 'add',
            component: Add
        }
    ]
})


const app = new Vue({
    el: '#app',
    components: {App},
    router,
})
