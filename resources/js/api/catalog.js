import axios from 'axios';

export default {
// API for product catalog
    updateCatalog(id, data) {
        return axios.put(`/api/catalog/${id}`, data);
    },
    deleteCategory(id) {
        return axios.delete(`/api/catalog/${id}`);
    },
    createCatalog(data) {
        return axios.post('/api/catalog', data);
    },


// API for products
    findProduct(id) {
        return axios.get(`/api/products/${id}`);
    },
    getProductsParams( product_id ) {
        return axios.get(`/api/product_params/${product_id}`);
    },
    getCategoryProducts( category_id ) {
        return axios.get(`/api/products/category/${category_id}`);
    },
    updateProduct(id, data) {
        return axios.put(`/api/product/${id}`, data);
    },
    deleteProduct(id) {
        return axios.delete(`/api/product/${id}`);
    },
};