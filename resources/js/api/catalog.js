import axios from 'axios';

export default {

// API for products
    findProduct(id) {
        return axios.get(`/api/products/${id}`);
    },
    getProductsParams( product_id ) {
        return axios.get(`/api/product_params/${product_id}`);
    },
    getCategoryProducts( category_id ) {
        return axios.get(`/api/products/category/${category_id}`);
    }
};