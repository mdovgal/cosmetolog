//require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
//import 'materialize-css/dist/js/materialize.min'

Vue.use(VueRouter)

import App from './views/App'
import ProductCatalog from './views/admin/ProductCatalog'
import ProductCreate from './views/admin/ProductCreate'
import ProductEdit from './views/admin/ProductEdit'
import CosmetologsList from './views/admin/CosmetologsList'
import CustomersList from './views/admin/CustomersList'
import Orders from './views/admin/Orders'
import Hello from './views/Hello'

import Home from './views/Home'
import Articles from './views/Articles'
import UsersIndex from './views/UsersIndex'
import UsersEdit from './views/UsersEdit'
import UsersCreate from './views/UsersCreate'
import ArticleCreate from './views/ArticleCreate2'

import NotFound from './views/NotFound'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {path: '/admin', name: 'product.catalog',component: ProductCatalog
        },
        {path: '/admin/products/category/:catalog_id', name: 'products.catalog',component: ProductCatalog
        },
        {path: '/admin/catalog/:catalog_id/product/create', name: 'product.create',component: ProductCreate
        },
        {path: '/admin/product/:id/edit', name: 'product.edit', component: ProductEdit
        },
        {path: '/admin/cosmetologs', name: 'cosmetologs.list',component: CosmetologsList
        },
        {path: '/admin/customers', name: 'customers.list',component: CustomersList
        },
        {path: '/admin/orders', name: 'orders',component: Orders
        },
        { path: '/404', name: '404', component: NotFound
        },

// ---------- old --------------------------------
        {path: '/admin/users', name: 'users.index',component: UsersIndex
        },
        {path: '/admin/hello', name: 'hello', component: Hello,
        },
        {path: '/admin/users/create', name: 'users.create', component: UsersCreate,
        },
        {path: '/admin/users/:id/edit', name: 'users.edit', component: UsersEdit,
        },
        {path: '/admin/article/user/:id/create', name: 'article.add', component: ArticleCreate,
        },
        {path: '/admin/articles', name: 'articles', component: Articles,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router
});