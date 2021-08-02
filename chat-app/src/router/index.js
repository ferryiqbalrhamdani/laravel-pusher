import Vue from 'vue'
import VueRouter from 'vue-router'
import Conversation from '../views/conversation/index.vue'
import store from '../store'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'home',
        component: Conversation,
        meta: {
            auth: true,
        },
    },
    {
        path: '/conversation/:id',
        name: 'conversation.show',
        component: () => import(/* webpackChunkName: "login" */ '@/views/conversation/show.vue'),
        meta: {
            auth: true,
        },
    },
    {
        path: '/login',
        name: 'auth.login',
        component: () => import(/* webpackChunkName: "login" */ '@/views/auth/Login.vue'),
    },
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
})

router.beforeEach((to, from, next) => {
    if (to.meta.auth && !store.getters['auth/authenticated']) next('/login')
    else next()

    if (to.name == 'auth.login' && store.getters['auth/authenticated']) next({ name: 'home' })
    else next()
})

export default router
