//require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
//import 'materialize-css/dist/js/materialize.min'

Vue.use(VueRouter)

import App from './views/AppAdmin'
import ProductCatalog from './views/admin/ProductCatalog'
import ProductCreate from './views/admin/ProductCreate'
import ProductEdit from './views/admin/ProductEdit'
import CosmetologsList from './views/admin/CosmetologsList'
import CustomersList from './views/admin/CustomersList'
import Orders from './views/admin/Orders'
import Hello from './views/Hello'

import Articles from './views/admin/Articles'
import UsersIndex from './views/admin/UsersIndex'
import UsersEdit from './views/admin/UsersEdit'
import UsersCreate from './views/admin/UsersCreate'
import ArticleCreate from './views/admin/ArticleCreate'

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
        {path: '/admin/cosmetologs', name: 'cosmetologs.list',component: UsersIndex
        },
        {path: '/admin/customers', name: 'customers.list',component: CustomersList
        },
        {path: '/admin/orders', name: 'orders',component: Orders
        },
        { path: '/404', name: '404', component: NotFound
        },

// ---------- old --------------------------------
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