//require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './views/App'
import Hello from './views/Hello'
import Home from './views/Home'
//import Articles from './views/Articles'
//import UsersIndex from './views/UsersIndex'
//import UsersEdit from './views/UsersEdit'
//import UsersCreate from './views/UsersCreate'
//import ArticleCreate from './views/ArticleCreate2'
import NotFound from './views/NotFound'

const router = new VueRouter({
    mode: 'history',
    routes: [
        //{path: '/admin', name: 'users.index',component: UsersIndex
        //},
        {path: '/admin/hello', name: 'hello', component: Hello,
        },
        //{path: '/admin/users/create', name: 'users.create', component: UsersCreate,
        //},
        //{path: '/admin/users/:id/edit', name: 'users.edit', component: UsersEdit,
        //},
        //{path: '/admin/article/user/:id/create', name: 'article.add', component: ArticleCreate,
        //},
        //{path: '/admin/articles', name: 'articles', component: Articles,
        //},
        { path: '/404', name: '404', component: NotFound },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router
});