<template>
    <div class="row">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <blockquote style="border-left: 5px solid #80d8ff">
                        <h5 style="margin-top: 42px;">{{ product.title }}</h5>
                        <p style="color: #9e9e9e; font-style: italic;" v-html="product.short_description"></p>
                    </blockquote>
                </div>
            </div>
            <div class="row" v-if="product.id">
                <div class="col s4">
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-image" v-if="product.image">
                                    <img class="materialboxed" :src="product.image" style="margin: auto;height: auto;width: auto; max-width:444px; max-height:444px;">
                                </div>
                                <div class="card-image" v-else>
                                    <img src="/img/product_placeholder.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s8">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="product_name" type="text" class="validate black-text" v-model="product.type" readonly>
                            <label for="product_name">Тип продукту</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="product_brand" type="text" class="validate black-text" v-model="product.brand" readonly>
                            <label for="product_brand">Бренд</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="items_on_stock" type="text" class="validate green-text" v-if="product.items_on_stock" value="В наявності" readonly>
                            <input id="items_on_stock" type="text" class="validate red-text" v-else value="Немає на складі" readonly>
                            <label for="items_on_stock">Доступність</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="price" type="text" class="validate black-text" v-model="product.price" readonly>
                            <label for="price">Ціна, грн</label>
                        </div>
                        <div class="row center-align" v-if="product.items_on_stock">
                            <div class="input-field col s2">
                                <input type="number" id="items" min="0" :max="product.items_on_stock" v-model="product.items">
                                <label for="items">Кількість</label>
                            </div>
                            <div class="input-field col s3">
                                <a class="waves-effect waves-light btn blue" @click="sentToCart(product)">
                                    <i class="material-icons">add_shopping_cart</i>
                                    До кошика
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row"  v-if="product.id">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s2"><a class="active" href="#product_description">Опис товару</a></li>
                        <li class="tab col s2"><a href="#product_composition">Склад</a></li>
                    </ul>
                </div>
                <div id="product_description" class="col s12">
                    <div class="row">
                        <div class="col s12" style="padding: 15px;" v-html="product.description">
                        </div>
                    </div>
                </div>
                <div id="product_composition" class="col s12">
                    <div class="row">
                        <div class="col s12" style="padding: 15px;" v-html="product.composition">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 right-align"  v-if="product.id">
            <div class="col s12" style="margin: 0px 15px;">
                <a class="waves-effect waves-light btn blue" @click="returnToCategory()">
                    До каталогу
                </a>
            </div>
        </div>
    </div>
</template>
<script defer="defer">
    import Vue from 'vue';
    import M from 'materialize-css';
    import 'materialize-css/dist/css/materialize.min.css';
    import axios from 'axios';
    import JQuery from 'jquery';
    let $ = JQuery;

    import api from '../api/catalog';

    const getProductParams = (callback) => {
        axios
                .get('/api/product_params', {})
                .then(response => {
            callback(null, response.data);
    }).catch(error => {
        callback(error, error.response.data);
    });
    };

    export default {
        data(){
            return {
                error_message: null,
                message: null,
                is_updated: false,
                loaded_product: false,
                loaded_params: false,
                saving: false,
                catalog: null,
                product_types: null,
                product_brands: null,
                product: {
                    id: null,
                    category_id: null,
                    category: null,
                    type_id: null,
                    type: null,
                    brand_id: null,
                    brand: null,
                    title: "",
                    short_description: "",
                    description: "",
                    composition: "",
                    price: "",
                    image: "",
                    items_on_stock: "",
                    attachment: null,
                    items: 0,
                    attributes: []
                }
            };
        },
        mounted(){
            setTimeout(() => {
                $("#general_loader").hide();
            }, 50);
        },
        updated(){
            if(!this.is_updated) {
// M.toast({html: 'M::UPDATED!'});
                M.updateTextFields();

                var elems_tab = document.querySelectorAll('.tabs');
                var instance_tab = M.Tabs.init(elems_tab, {duration: 0});

                var elems = document.querySelectorAll('.materialboxed');
                var instances = M.Materialbox.init(elems, {});




                this.is_updated = true;
            }
        },
        created(){
            //this.is_updated = false;
            this.loaded_product = false;
            this.loaded_params = false,

            api.findProduct( this.$route.params.id  ).then((response) => {
                this.loaded = true;

                let that = this;
                $.each(response.data.data, function(indx, data){
                    that.product.id = data.id;
                    that.product.category_id = data.category_id;
                    that.product.type_id = data.type_id;
                    that.product.brand_id = data.brand_id;
                    that.product.title = data.title;
                    that.product.short_description = data.short_description;
                    that.product.description = data.description;
                    that.product.composition = data.composition;
                    that.product.price = data.price;
                    that.product.image = data.image;
                    that.product.items_on_stock = data.items_on_stock;
                });
                this.loaded_product = true;
                if(this.loaded_product && this.loaded_params){
                    this.is_updated = false;
                }
            }).catch((err) => {
                this.$router.push({ name: '404' });
            });

            api
                .getProductsParams( this.$route.params.id )
                .then((response) => {
                    let params = response.data.data;
                    let that = this;

                    $.each(params, function(k, v){
                        $.each(v, function(pp, vv){
                            if(pp == 'catalog'){
                                that.product.category = vv;
                            }
                            if(pp == 'types'){
                                that.product.type = vv;
                            }
                            if(pp == 'brends'){
                                that.product.brand = vv ;
                            }
                        });
                    })
                    this.loaded_params = true;
                    if(this.loaded_product && this.loaded_params){
                        this.is_updated = false;
                    }
                })
                .catch((err) => {
                    this.$router.push({ name: '404' });
                });


        },
//        beforeRouteEnter (to, from, next){
//            getProductParams( (err, data) => {
//                    next(vm => vm.setParams(err, data));
//            });
//        },
        methods: {
            sentToCart(item){

            },
            returnToCategory(){
                this.loaded = false;
                M.toast({html: 'Виконується перенаправлення до категорії'});
                var catalog_id = this.product.category_id;

                this.$router.push({
                    //path: `/products/category/${catalog_id}`,
                    path: `/`,
//                    params: {catalog_id: catalog_id},
//                    props: true
                });
            }
        }
    };


</script>
<style>
    .tabs .indicator{
        background-color: #0091ea;
    }
    .tabs .tab a:hover{
        color: black;
        background-color: white;
    }
    .tabs .tab a{
        color: black;
        background-color: white;
        transition: none !important;
    }
    .tabs .tab a.active {
        background-color: white;
        color: black;
        transition: none !important;
    }
    .tabs .tab a.active:hover {
        background-color: white;
        color: black;
    }

    #items_on_stock, #price, #product_name, #items{
        border-bottom: 1px solid lightgrey !important;
        box-shadow: 0 1px 0 0 lightgrey !important;
    }
    .tabs .tab a:focus, .tabs .tab a:focus.active{
        background-color: white;
    }
    .helper-text{
        position: relative !important;
        min-height: 18px !important;
        display: block !important;
        font-size: 12px !important;
        color: red !important; }
</style>
