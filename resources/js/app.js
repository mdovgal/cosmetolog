//require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './views/App'
import ProductCatalog from './views/ProductCatalog'
import ProductView from './views/ProductView'
import NotFound from './views/NotFound'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {path: '/', name: 'product.catalog',component: ProductCatalog
        },
        {path: '/product/:id/', name: 'product.view',component: ProductView
        },
        {path: '/products/category/:catalog_id', name: 'products.catalog',component: ProductCatalog
        },
        {path: '/cart', name: 'products.catalog',component: ProductCatalog
        },
        { path: '/404', name: '404', component: NotFound },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router
});