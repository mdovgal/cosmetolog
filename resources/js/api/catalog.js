import axios from 'axios';

export default {

// API for products
    findProduct(id) {
        return axios.get(`/api/products/${id}`);
    },
    getProductsParams( product_id ) {
        return axios.get(`/api/product_view_params/${product_id}`);
    },
    getCategoryProducts( category_id ) {
        return axios.get(`/api/products/category/${category_id}`);
    },
// API for Cart
    getUserCart( user_id ) {
        return axios.get(`/api/cart/${user_id}`);
    },
    createCart( user_id ) {
        return axios.post(`/api/cart/${user_id}`);
    },
    saveItemToCart( cart_id, product_id, quantity ) {
        return axios.post(`/api/cart/${cart_id}/add_product/${product_id}/quantity/${quantity}`);
    }
};