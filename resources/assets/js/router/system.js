
export default [
    {
        name: 'group',
        path: '/system/group',
        component: resolve => void(require(['../views/system/group.vue'], resolve))
    },
    {
        name: 'rule',
        path: '/system/rule',
        component: resolve => void(require(['../views/system/rule.vue'], resolve))
    },
    {
        name: 'admin',
        path: '/system/admin',
        component: resolve => void(require(['../views/system/admin.vue'], resolve))
    },
    {
        name: 'profile',
        path: '/system/profile',
        component: resolve => void(require(['../views/system/profile.vue'], resolve))
    },
    {
        name: 'logslist',
        path: '/system/logs',
        component: resolve => void(require(['../views/system/logs.vue'], resolve))
    }
]