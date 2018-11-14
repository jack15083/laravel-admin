import Vue from 'vue';
import VueRouter from 'vue-router';
import system from '../router/system.js' //系统管理
Vue.use(VueRouter);

let vueRoutes = {
    saveScrollPosition: true,
    routes: [
        {
            name: 'hello',
            path: '/',
            component: resolve => void(require(['../components/Hello.vue'], resolve))
        }
    ]
};

vueRoutes.routes = vueRoutes.routes.concat(system);

export default new VueRouter(vueRoutes);
