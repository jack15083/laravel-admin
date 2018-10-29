import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: 'hello',
            path: '/hello',
            component: resolve => void(require(['../components/Hello.vue'], resolve))
        }
    ]
});
