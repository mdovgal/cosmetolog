<template>
    <div class="row">
        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>
        <div v-if="message" class="alert alert-success">{{ message }}</div>
        <div v-if="! loaded">Завантаження...</div>

        <div class="col s3" style="margin-top: 20px;">
            <a class="waves-effect waves-light btn light-blue add_catalog_head" style="width: 100%;"><i class="material-icons left">add</i>Додати категорію</a>
            <ul class="collapsible">
                <li v-for="item in catalog" v-if="item.parent_id == 0" :class="{ 'active': item.id == catalog[0].id }">
                    <div class="collapsible-header"><i class="material-icons">whatshot</i>
                        {{ item.title }}
                        <i class="material-icons right md-24" @click="editCategory(item)">edit</i>
                        <i class="material-icons right md-24" @click="deleteCategory(item)">delete</i>
                    </div>
                    <div class="collapsible-body" v-if="item.parent_id == 0">
                        <ul class="collection">
                            <li class="collection-item" v-for="sub_item in item.children">
                                {{ sub_item.title }}
                                <i class="material-icons right md-18" style="cursor:pointer;" @click="deleteCategory(sub_item)">delete</i>
                                <i class="material-icons right md-18" style="cursor:pointer;" @click="editCategory(sub_item)">edit</i>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

            <!-- Modal Structure -->
            <div id="modal1" class="modal" ref="selectedRecordModal">
                <div class="modal-content">
                    <h6>Редагувати категорію</h6>
                    <div v-if="error_message" class="alert alert-danger" style="color:red;">{{ error_message }}</div>
                    <form id="modal1_form" v-if="selectedRecord">
                        <input type="text"
                               id="id"
                               name="id"
                               v-model="selectedRecord.id"
                               class="form-control">
                        <div class="form-group">
                            <label for="title">Батьківська категорія</label>
                            <select name="parent_id" id="category_select">
                                <option value="0" selected="selected">
                                    Top level
                                </option>
                                <option v-for="item in catalog" v-if="item.parent_id == 0" :value="item.id" :selected="{ 'selected': item.id == selectedRecord.parent_id }">
                                    {{ item.title }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Name</label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   v-model="selectedRecord.title"
                                   class="form-control"
                                   required="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-close waves-effect waves-red btn-flat" @click="cancelCategory()">Cancel</a>
                    <a href="#!" class="waves-effect waves-green btn-flat" :disabled="saving" @click="saveCategory()">
                    {{ saving ? 'Зберігається...' : 'Зберегти' }}
                    </a>
                </div>
            </div>
        </div>

        <div class="col s9" style="margin-top: 20px; padding-left: 25px;">
            Teal page content
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

    export default {
        data() {
            return {
                message: null,
                saving: false,
                loaded: true,
                catalog: null,
                meta: null,
                error: null,
                error_message: null,
                is_m_build:false,
                selectedRecord: null
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
            if( elems_select ){
                var instances_select = M.FormSelect.init(elems_select);
            }


            M.toast({html: 'Updated Content now......'})
        },
        beforeRouteEnter (to, from, next){
            getCatalog( (err, data) => {
                next(vm => vm.setData(err, data));
        });
    },
    beforeRouteUpdate (to, from, next) {
        this.catalog = null
        getCatalog((err, data) => {
            this.setData(err, data);
        next();
    });
    },
    methods: {
        editCategory(item){
            var elem_select = document.getElementById('parent_id');
            var inst_select = M.FormSelect.init(elem_select);

            var elems_modal = document.getElementById('modal1');
            var instance_modal = M.Modal.getInstance(elems_modal);

            this.selectedRecord = Vue.util.extend({}, item);

            instance_modal.open();
        },
        saveCategory(){
            var form = document.getElementById("modal1_form");
            var parent_id = 0;
            if(form.parent_id){
                parent_id = form.parent_id.value;
            }

            var elems_modal = document.getElementById('modal1');
            var instance_modal = M.Modal.getInstance(elems_modal);

            this.saving = true;
            this.error_message = null;

            api.updateCatalog(form.id.value, {
                title: form.title.value,
                parent_id: parent_id
            }).then((response) => {
                M.toast({html: 'Категорія відредагована!'})

                instance_modal.close();

                this.is_m_build = false;
                this.$router.push({ name: 'product.catalog', params: {} });
            }).catch(error => {
                this.error_message = error.response.data.message || error.message;
            }).then(() => this.saving = false);
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
                    //this.$router.go();
                    this.$router.push({ name: 'product.catalog', params: {} });
                }).catch(error => {
                    this.error_message = error.response.data.message || error.message;
                }).then(() => {this.saving = false; this.is_m_build = false;});
            }
        },
        cancelCategory(){
            this.selectedRecord = null;
        },
        setData(err, { data: catalog_items }) {
            if (err) {
                this.error = err.toString();
            } else {
                this.catalog = catalog_items;
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