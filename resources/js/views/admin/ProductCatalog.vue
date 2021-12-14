<template>
    <div class="row">
        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>
        <div v-if="message" class="alert alert-success">{{ message }}</div>
        <div v-if="! loaded">Завантаження...</div>

        <div class="col s4" style="margin-top: 20px;">
            <a class="waves-effect waves-light btn light-blue add_catalog_head" style="width: 100%;" :disabled="saving" @click="addCategory()">
                <i class="material-icons left">add</i>
                Додати категорію
            </a>
            <ul class="collapsible">
                <li v-for="item in catalog" v-if="item.parent_id == 0" :class="{ 'active': item.id == catalog[0].id }"  :key="item.id">
                    <div class="collapsible-header"><i class="material-icons">whatshot</i>
                            <span @click="viewProductList(item)">{{ item.title }}</span>
                        <i class="material-icons right md-24" @click="editCategory(item)">edit</i>
                        <i class="material-icons right md-24" @click="deleteCategory(item)">delete</i>
                    </div>
                    <div class="collapsible-body" v-if="item.parent_id == 0">
                        <ul class="collection">
                            <li class="collection-item" v-for="sub_item in item.children" :key="sub_item.id">
                                <span  @click="viewProductList(sub_item)">{{ sub_item.title }}</span>
                                <i class="material-icons right md-18" style="cursor:pointer;" @click="deleteCategory(sub_item)">delete</i>
                                <i class="material-icons right md-18" style="cursor:pointer;" @click="editCategory(sub_item)">edit</i>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

<!-- START: Modal Structure -->
            <div id="modal1" class="modal" ref="selectedCategoryRecordModal">
                <div class="modal-content">
                    <h6>Редагувати категорію</h6>
                    <div v-if="error_message" class="alert alert-danger" style="color:red;">{{ error_message }}</div>
                    <form id="modal1_form" v-if="selectedCategoryRecord">
                        <input type="hidden"
                               id="id"
                               name="id"
                               v-model="selectedCategoryRecord.id"
                               class="form-control">
                        <div class="form-group">
                            <label for="title">Категорія</label>
                            <select name="parent_id" id="category_select">
                                <option value="0" :selected="selectedCategoryRecord.parent_id == 0">
                                    Top level
                                </option>
                                <option v-for="item in catalog" v-if="item.parent_id == 0" :value="item.id" :selected="item.id == selectedCategoryRecord.parent_id ">
                                    {{ item.title }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Name</label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   v-model="selectedCategoryRecord.title"
                                   class="form-control"
                                   required="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="" class="modal-close waves-effect waves-red btn-flat" @click="cancelCategory()">Cancel</a>
                    <a href="" class="waves-effect waves-green btn-flat" :disabled="saving" @click="saveCategory()">
                    {{ saving ? 'Зберігається...' : 'Зберегти' }}
                    </a>
                </div>
            </div>
<!-- END: Modal Structure -->
        </div>

        <div class="col s8" style="margin-top: 20px; padding-left: 25px;"  v-if="selectedCategoryRecord"  ref="selectedCategoryRecordModal">
            <div class="row">
                <div class="col s9">
                    <h5 style="margin-top: 0px;">Категорія {{ selectedCategoryRecord.title }}</h5>
                </div>
                <div class="col s3">
                    <a class="waves-effect waves-light btn light-blue add_catalog_head" style="width: 100%;" :disabled="saving" @click="addCategory()">
                        <i class="material-icons left">add</i>
                        Додати продукт
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div v-if="products"> Product list</div>
                    <div v-else>У категорії продуктів не знайдено</div>
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

    import api from '../../api/catalog';
//    import api from '../../api/products';
//    $( document ).ready(function() {});

    const getCatalog = (callback) => {
        axios
            .get('/api/catalog', {})
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
                saving: false,
                loaded: true,
                catalog: null,
                products: null,
                popup_catalog: null,
                meta: null,
                error: null,
                error_message: null,
                is_m_build:false,
                is_m_select_build: false,
                selectedCategoryRecord: null,
                category:{
                    id: null,
                    title: "",
                    id_parent: 0
                }
            };
        },
        updated(){
            if(!this.is_m_build){
                M.toast({html: 'M is build now!'})
                var elem = document.querySelectorAll('.collapsible');
                var instances = M.Collapsible.init(elem);

                var elems_btn = document.querySelectorAll('.fixed-action-btn');
                var instances_btn = M.FloatingActionButton.init(elems_btn, {direction:'right'});

                var elems_modal = document.getElementById('modal1');
                var instances_init_modal = M.Modal.init(elems_modal);
                var instance_modal = M.Modal.getInstance(elems_modal);

                this.is_m_build = true;
            }

            var elems_select = document.getElementById('category_select');
            if( elems_select && !this.is_m_select_build){
                var instances_select = M.FormSelect.init(elems_select);
                M.toast({html: 'M-SELECT is build now!'})
                this.is_m_select_build = true;
            }


            //M.toast({html: 'Updated Content now......'})
        },
        beforeRouteEnter (to, from, next){
            getCatalog( (err, data) => {
                next(vm => vm.setData(err, data));
        });
    },
    beforeRouteUpdate (to, from, next) {
        //this.catalog = null
        getCatalog((err, data) => {
            this.setData(err, data);
            next();
        });
    },
    methods: {
// Products methods ------------------------------------------------------
        viewProductList(category_item){
console.log('~~~> viewProductList ~~~~~~~~~~~',category_item.id, category_item.children);
            //selectedCategoryRecord
            this.selectedCategoryRecord = Vue.util.extend({}, category_item);

            api.getCategoryProducts(category_item.id )
            .then((response) => {
console.log('~~~~> getCategoryProducts ~~~~~~~~~~~~~~~~', response.data);
            });
        },
// Categiries methods ------------------------------------------------------
        addCategory(){
            this.popup_catalog = this.catalog;
            var elems_modal = document.getElementById('modal1');
            var instance_modal = M.Modal.getInstance(elems_modal);

            this.selectedCategoryRecord = Vue.util.extend({}, this.category);
            instance_modal.open();
        },
        editCategory(item){
            this.popup_catalog = this.catalog;
            var elems_modal = document.getElementById('modal1');
            var instance_modal = M.Modal.getInstance(elems_modal);

            this.selectedCategoryRecord = Vue.util.extend({}, item);

            instance_modal.open();
        },
        saveCategory(){
            var elems_modal = document.getElementById('modal1');
            var instance_modal = M.Modal.getInstance(elems_modal);

            var form = document.getElementById("modal1_form");
            var parent_id = 0;
            if(form.parent_id){
                parent_id = form.parent_id.value;
            }

            this.saving = true;
            this.error_message = null;

            if(form.id.value != ''){
                api.updateCatalog(form.id.value, {
                    title: form.title.value,
                    parent_id: parent_id
                }).then((response) => {
                    M.toast({html: 'Категорія відредагована!'})

                    instance_modal.close();

                    this.is_m_build = false;
                    this.popup_catalog = null;
                    this.is_m_select_build = false;
                    this.$router.push({ name: 'product.catalog', params: {} });
                }).catch(error => {
                        this.error_message = error.response.data.message || error.message;
                }).then(() => this.saving = false);
            }else{
                api.createCatalog({
                    title: form.title.value,
                    parent_id: parent_id
                }).then((response) => {
                    M.toast({html: 'Категорія додана!'})

                    instance_modal.close();

                    this.is_m_build = false;
                    this.popup_catalog = null;
                    this.is_m_select_build = false;
                    this.$router.push({ name: 'product.catalog', params: {} });
                }).catch(error => {
                    this.error_message = error.response.data.message || error.message;
                }).then(() => this.saving = false);
            }
        },
        deleteCategory(item){
            if(item.parent_id == 0){
                var confirm_message = 'Ви дійсно бажаєте видалити категорію '+item.title +','+"\n"+' її підкатегорії та продукти?'
            }else{
                var confirm_message = 'Ви дійсно бажаєте видалити категорію '+item.title +','+"\n"+' та її продукти?'
            }

            if(confirm( confirm_message )){
                this.saving = true;
                api.deleteCategory(item.id )
                .then((response) => {
                    M.toast({html: 'Категорія видалена!'})

                    this.is_m_build = false;
                    this.$router.go();
                    //this.$router.push({ name: 'product.catalog', params: {} });
                    //this.$router.push("/admin").catch(()=>{});

                    //app.$forceUpdate();
                });
            }
        },
        cancelCategory(){
            this.saving = false;
            this.error_message = null;
            this.is_m_select_build = false;
            this.selectedCategoryRecord = null;
            this.popup_catalog = null;
        },
        setData(err, { data: catalog_items }) {
            if (err) {
                this.error = err.toString();
            } else {
                this.catalog = catalog_items;
//                this.selectedCategoryRecord = Vue.util.extend({}, catalog_items[0]);
                this.selectedCategoryRecord = null;
//                this.selectedCategoryRecord = null;
console.log(catalog_items[0]);
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
</style>