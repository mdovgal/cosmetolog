<template>
    <div class="row">
        <div v-if="message" class="alert alert-success">{{ message }}</div>
        <div class="progress" v-if="! loaded && !catalog">
            <div class="indeterminate"></div>
        </div>


        <div class="col s3" style="margin-top: 20px;">
            <h5>Каталог</h5>
            <ul class="collapsible">
                <li v-for="item in catalog" v-if="item.parent_id == 0" :class="{ 'active': item.id == catalog[0].id }"  :key="item.id">
                    <div class="collapsible-header"><i class="material-icons">whatshot</i>
                            <span  style="width:100%;">{{ item.title }}</span>
                        <i class="material-icons right md-24" @click="editCategory(item)">edit</i>
                        <i class="material-icons right md-24" @click="deleteCategory(item)">delete</i>
                    </div>
                    <div class="collapsible-body" v-if="item.parent_id == 0">
                        <ul class="collection">
                            <li class="collection-item" v-for="sub_item in item.children" :key="sub_item.id">
                                <span  @click="viewProductList(sub_item)" style="cursor:pointer;">{{ sub_item.title }}</span>
                                <i class="material-icons right md-18" style="cursor:pointer;" @click="deleteCategory(sub_item)">delete</i>
                                <i class="material-icons right md-18" style="cursor:pointer;" @click="editCategory(sub_item)">edit</i>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <div class="col s9" style="margin-top: 20px; padding-left: 25px;"  v-if="selectedCategoryRecord"  ref="selectedCategoryRecordModal">
            <div class="row">
                <div class="col s9">
                    <h5 style="margin-top: 0px;">Категорія: {{ selectedCategoryRecord.title }}</h5>
                    <div class="progress" v-if="! loaded && catalog && !products">
                        <div class="indeterminate"></div>
                    </div>
                </div>
                <div class="col s3" v-if="selectedCategoryRecord">
                    <a class="waves-effect waves-light btn light-blue add_catalog_head" style="width: 100%;" :disabled="saving" @click="addProduct(selectedCategoryRecord)" v-if="selectedCategoryRecord.parent_id">
                        <i class="material-icons left">add</i>
                        Додати продукт
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div v-if="loaded && products">
                        <div v-if="products">

                            <div class="row products_row" v-for="row in products">
                                <div class="col s4" v-for="{id, image, title, short_description, price, items_on_stock} in row">
                                    <div class="card">
                                        <div class="card-image">
                                            <img v-if="image" :src="image">
                                            <img v-else src="/img/product_placeholder.png">

                                            <router-link :to="{ name: 'product.edit', params: { id } }" class="btn-floating halfway-fab waves-effect waves-light blue edit" >
                                                <i class="material-icons">edit</i>
                                            </router-link>
                                            <a class="btn-floating halfway-fab waves-effect waves-light blue delete" @click="deleteProduct( id, title )"><i class="material-icons">delete</i></a>
                                        </div>
                                        <div class="card-content">
                                            <h6><b>{{title}}</b></h6>
                                            <div class="row short_description" v-html="short_description"></div>
                                            <div class="row price">
                                                <div class="col s6">Ціна, грн</div>
                                                <div class="col s6">Кількість</div>
                                            </div>
                                            <div class="row price">
                                                <div class="col s6"><b>{{ price }}</b></div>
                                                <div class="col s6"><b>{{ items_on_stock }}</b></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div v-if="loaded && !products">У категорії продукти відсутні</div>
                </div>
            </div>


        </div>

</div>
</template>
<script>
    import Vue from 'vue';
    import M from 'materialize-css';
    import 'materialize-css/dist/css/materialize.min.css';
    import axios from 'axios';
    import JQuery from 'jquery';
    let $ = JQuery;

    import api from '../api/catalog';

    const getCatalog = (callback) => {
        axios
            .get('/api/catalog/products', {})
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
                callback(error, error.response.data);
            });
    };

    const getProducts = (callback) => {
        axios
            .get('/api/products', {})
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
                loaded: true,
                catalog: null,
                error: null,
                error_message: null,
                selectedCategoryRecord: null
            };
        },
        mounted(){
            setTimeout(() => {
                $("#general_loader").hide();
            }, 50);
        },
        updated(){
                var elem = document.querySelectorAll('.collapsible');
                var instances = M.Collapsible.init(elem);

//                var elems_btn = document.querySelectorAll('.fixed-action-btn');
//                var instances_btn = M.FloatingActionButton.init(elems_btn, {direction:'right'});
        },
        beforeRouteEnter (to, from, next){
            getCatalog( (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
    beforeRouteUpdate (to, from, next) {
        alert('beforeRouteUpdate');
        getCatalog((err, data) => {
            this.setData(err, data);
            next();
        });
    },
    methods: {
        setData(err, { data: catalog_items }) {
            if (err) {
                this.error = err.toString();
            } else {
                this.catalog = catalog_items;
                this.selectedCategoryRecord = null;

//                if(typeof this.$route.params.catalog_id !== "undefined"){
//                    let router_item = null;
//                    let that = this;
//                    $.each(catalog_items, function(v, parent_i){
//                        $.each(parent_i.children, function(vv, ii){
//                            if(ii.id == that.$route.params.catalog_id){
//                                router_item = ii;
//                            }
//                        });
//                    });
//                    this.viewProductList(router_item)
//                }
            }
        }
    }
}
</script>
<style>
    .add_author{text-align: end;margin: 17px 0px;}
    /*div.row div{border: 1px dashed red;}*/

    .material-icons.md-18 { font-size: 18px; }
    .material-icons.md-24 { font-size: 24px; }
    .material-icons.md-36 { font-size: 36px; }
    .material-icons.md-48 { font-size: 48px; }

    .material-icons.md-dark { color: rgba(0, 0, 0, 0.54); }
    .material-icons.blue { color: #80d8ff; }

    .progress {
        background-color: #2196f3;
    }
    .progress .indeterminate {
        background-color: #90caf9;
    }
    .row.products_row .card{ width: 335px; min-height: 539px;}
    .row.products_row .card-image{
        border-bottom: 1px solid lightgrey;
        height: 291px;
        width: 291px;
    }
    .row.products_row .card-image img{
        margin: auto;
        height: 100%;
        width: 100%;
        max-width:290px;
        max-height:290px;
        object-fit: cover;
        object-position: center;
    }
    .btn-floating.halfway-fab.edit{
        right: 26px;
    }
    .btn-floating.halfway-fab.delete{
        right: -17px;
    }
    .card-content .row.short_description{
        min-height: 90px;
        overflow: hidden;
    }
    .card-content .row.price{
        margin-bottom: 0px;
    }

    #title{
        border-bottom: 1px solid lightgrey !important;
        box-shadow: 0 1px 0 0 lightgrey !important;
    }

    .helper-text{
        position: relative !important;
        min-height: 18px !important;
        display: block !important;
        font-size: 12px !important;
        color: red !important; }


</style>