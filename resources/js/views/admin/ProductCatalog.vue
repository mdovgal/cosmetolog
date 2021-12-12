<template>
    <div class="row">
        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>
        <div v-if="message" class="alert alert-success">{{ message }}</div>
        <div v-if="! loaded">Завантаження...</div>

        <div class="col s3">
            Grey navigation panel
        </div>

        <div class="col s9">
            Teal page content
        </div>

</div>
</template>
<script>
    import axios from 'axios';
    import JQuery from 'jquery';
    let $ = JQuery;
    $( document ).ready(function() {
//alert( "ready!" );
console.log( $(".row") );
    });
    const getCatalog = (page, callback) => {
        axios
            .get('/api/catalog', {})
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
                callback(error, error.response.data);
            });
    };

    export default {
        data() {
            return {
                message: null,
                saving: false,
                loaded: true,
                catalog: null,
                meta: null,
                error: null,
            };
        },
        beforeRouteEnter (to, from, next){
            getCatalog(to.query.page, (err, data) => {
                next(vm => vm.setData(err, data));
        });
    },
    beforeRouteUpdate (to, from, next) {
        this.catalog = this.links = this.meta = null
        getCatalog(to.query.page, (err, data) => {
            this.setData(err, data);
        next();
    });
    },
    methods: {
        setData(err, { data: catalog_items, links, meta }) {
            if (err) {
                this.error = err.toString();
            } else {
                this.catalog = catalog_items;
                this.links = links;
                this.meta = meta;
            }
        }
    }
    }
</script>
<style>
    .add_author{text-align: end;margin: 17px 0px;}
    /*div.row div{border: 1px dashed red;}*/
</style>