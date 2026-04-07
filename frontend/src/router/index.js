import { createRouter, createWebHashHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'MainView',
        component: () => import('@/views/MainView.vue')
    },
    {
        path: '/task/:id',
        name: 'TaskInfo',
        component: () => import('@/views/TaskView.vue')
    }
];

const router = createRouter({
    history: createWebHashHistory(),
    routes
});

export default router;