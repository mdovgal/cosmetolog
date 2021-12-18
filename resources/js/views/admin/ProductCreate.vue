<template>
    <div class="row">
        <form @submit.prevent="onSubmit($event)" method="post" enctype="multipart/form-data">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <h5 style="margin-top: 0px;">Новий продукт</h5>
                    <div class="progress" v-if="!loaded">
                        <div class="indeterminate"></div>
                    </div>

                    <div class="col s12 helper-text" v-if="error_message">{{ error_message }}</div>
                    <input id="id" type="hidden" class="validate" name="id" v-model="product.id">
                    <input id="imagefile" type="file" name="imagefile" v-on:change="onAttachmentChange" style="display:none;">
                </div>
            </div>
            <div class="row">
                <div class="col s4">
                    <div class="row">
                        <div class="col s12">
                            <div class="card-content">
                                <p style="color: #9e9e9e;">Фото продукту</p>
                            </div>
                            <label for="imagefile" style="cursor: pointer;">
                            <div class="card">
                                <div class="card-image" v-if="product.image">
                                    <img :src="product.image">
                                </div>
                                <div class="card-image" v-else>
                                    <img src="/img/product_placeholder.png">
                                </div>
                            </div>
                            </label>
                            <span class="helper-text" data-error="" data-success="">{{ product_errors.attachment }}</span>
                        </div>
                    </div>
                </div>
                <div class="col s8">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="product_name" type="text" class="validate" name="title" v-model="product.title">
                            <label for="product_name">Назва продукту</label>
                            <span class="helper-text" data-error="" data-success="">{{ product_errors.title }}</span>
                        </div>
                        <div class="input-field col s12">
                            <select id="category_id" name="category_id" class="validate" v-model="product.category_id">
                                <optgroup v-for="item in catalog" :label="item.title" :key="item.id">
                                    <option v-for="sub_item in item.children" :value="sub_item.id" :selected="sub_item.id == $route.params.catalog_id">
                                        {{sub_item.title}}
                                    </option>
                                </optgroup>
                            </select>
                            <label for="category_id">Категорія</label>
                            <span class="helper-text" data-error="" data-success="">{{ product_errors.category_id }}</span>
                        </div>
                        <div class="input-field col s12">
                            <select id="type_id" name="type_id" class="validate" v-model="product.type_id">
                                <option value=""></option>
                                <option v-for="item in product_types" :value="item.id">
                                    {{item.type_title}}
                                </option>
                            </select>
                            <label for="type_id">Тип продукту</label>
                            <span class="helper-text" data-error="" data-success="">{{ product_errors.type_id }}</span>
                        </div>
                        <div class="input-field col s12">
                            <select id="brand_id" name="brand_id" class="validate" v-model="product.brand_id">
                                <option value=""></option>
                                <option v-for="item in product_brands" :value="item.id">
                                    {{item.brand_title}} ({{item.country_title}})
                                </option>
                            </select>
                            <label for="brand_id">Бренд</label>
                            <span class="helper-text" data-error="" data-success="">{{ product_errors.brand_id }}</span>
                        </div>
                        <div class="input-field col s12">
                            <input id="price" type="text" class="validate" v-model="product.price">
                            <label for="price">Ціна, грн</label>
                            <span class="helper-text" data-error="" data-success="">{{ product_errors.price }}</span>
                        </div>
                        <div class="input-field col s12">
                            <input id="items_on_stock" type="text" class="validate" v-model="product.items_on_stock">
                            <label for="items_on_stock">Кількість в наявності</label>
                            <span class="helper-text" data-error="" data-success="">{{ product_errors.items_on_stock }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s3"><a class="active" href="#product_short_description">Стислий опис товару</a></li>
                        <li class="tab col s2"><a href="#product_description">Опис товару</a></li>
                        <li class="tab col s2"><a href="#product_composition">Склад</a></li>
                        <li class="tab col s2"><a href="#action">Дія засобу</a></li>
                        <li class="tab col s2"><a href="#other_parameters">Інші параметри</a></li>
                    </ul>
                </div>
                <div id="product_short_description" class="col s12">
                    <div class="row">
                        <div class="col s12" style="padding: 15px;">
                            <textarea id="short_description"  v-model="product.short_description"></textarea>
                            <span class="helper-text" data-error="" data-success="">{{ product_errors.short_description }}</span>
                        </div>
                    </div>
                </div>
                <div id="product_description" class="col s12">
                    <div class="row">
                        <div class="col s12" style="padding: 15px;">
                            <textarea id="description"  v-model="product.description"></textarea>
                            <span class="helper-text" data-error="" data-success="">{{ product_errors.description }}</span>
                        </div>
                    </div>
                </div>
                <div id="product_composition" class="col s12">
                    <div class="row">
                        <div class="col s12" style="padding: 15px;">
                            <textarea id="composition" name="composition" v-model="product.composition"></textarea>
                            <span class="helper-text" data-error="" data-success="">{{ product_errors.composition }}</span>
                        </div>
                    </div>
                </div>
                <div id="action" class="col s12" style="padding: 15px;">
                    <div v-for="(group,index) in product_attributes" v-if="index == 'effect'">
                        <div class="row" v-for="item in group">
                            <div class="col s3" v-for="{id, title} in item">
                                <label>
                                    <input type="checkbox" :value="id"  v-model="product.attributes"/>
                                    <span>{{title}}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="other_parameters" class="col s12">
                    <div class="row">
                        <div class="col s1"></div>
                        <div class="col s11" style="padding: 15px; color: #9e9e9e;">
                            <h6><i>Типи шкіри та косметичні дефекти, для яких цей засіб може бути корисним:</i></h6>
                        </div>
                    </div>
                    <div v-for="(group,index) in product_attributes" v-if="index == 'skin_type'">
                        <div class="row" v-for="item in group">
                            <div class="col s3" v-for="{id, title} in item">
                                <label>
                                    <input type="checkbox" :value="id"  v-model="product.attributes"/>
                                    <span>{{title}}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12">
            <div class="col s9"></div>
            <div class="col s1" style="margin: 0px 15px;">
                <a class="waves-effect waves-light btn blue-grey lighten-4" @click="returnToCategory()">
                    Скасувати
                </a>
            </div>
            <div class="col s1" style="margin: 0px 15px;">
                <button type="submit" class="waves-effect waves-light btn light-blue" :disabled="saving">
                    {{ saving ? 'Зберігається...' : 'Зберегти' }}
                </button>
            </div>
        </div>
        </form>
    </div>
</template>
<script defer="defer">
    import Vue from 'vue';
    import M from 'materialize-css';
    import 'materialize-css/dist/css/materialize.min.css';
    import axios from 'axios';
    import JQuery from 'jquery';
    let $ = JQuery;

    import api from '../../api/catalog';

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
                product_errors:{
                    category_id: '',
                    type_id: '',
                    brand_id: '',
                    title: "",
                    short_description: "",
                    description: "",
                    composition: "",
                    price: "",
                    image: "",
                    items_on_stock: "",
                    attachment: '',
                },
                message: null,
                loaded: false,
                saving: false,
                catalog: null,
                product_types: null,
                product_brands: null,
                product_attributes: null,
                product: {
                    id: null,
                    category_id: null,
                    type_id: null,
                    brand_id: null,
                    title: "",
                    short_description: "",
                    description: "",
                    composition: "",
                    price: "",
                    image: "",
                    items_on_stock: "",
                    attachment: null,
                    attributes: []
                }
            };
        },
        mounted(){
            //M.toast({html: 'M::MOUNTED!'});
            var elems_tab = document.querySelectorAll('.tabs');
            var instance_tab = M.Tabs.init(elems_tab, {duration: 0});

            M.updateTextFields();

            var ckeditorConfigNew = {
                //language: 'en',
                height: '300px',
                toolbar: [
                    { name: 'document', items: [ 'Preview', 'Source' ] },
                    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                    { name: 'basicstyles', items: [ 'Bold', 'Italic','Underline','Strike','Subscript','Superscript' ] },
                    { name: 'font', items: ['Font', 'FontSize', 'TextColor']},
                    { name: 'align', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight','JustifyBlock']},
                    { name: 'lists', items: [ 'NumberedList','BulletedList','Outdent','Indent'] },
                    { name: 'insert', items: ['Link','Unlink', '-', 'Blockquote']}
                    //{ name: 'insert', items: [ 'Image','Table','Smiley','SpecialChar'] },
                ]
            };
            CKEDITOR.replace('short_description', ckeditorConfigNew);
            CKEDITOR.replace('description', ckeditorConfigNew);
            CKEDITOR.replace('composition', ckeditorConfigNew);

            let that = this;

            CKEDITOR.instances['short_description'].on('change', function (e) {
                //$('#description').val(CKEDITOR.instances['description'].getData());
                that.product.short_description = CKEDITOR.instances['short_description'].getData();
            });
            CKEDITOR.instances['description'].on('change', function (e) {
                //$('#description').val(CKEDITOR.instances['description'].getData());
                that.product.description = CKEDITOR.instances['description'].getData();
            });

            CKEDITOR.instances['composition'].on('change', function (e) {
//                $('#composition').val(CKEDITOR.instances['composition'].getData());
                that.product.composition = CKEDITOR.instances['composition'].getData();
            });

            var elems_select = document.querySelectorAll('select');
            var instances_select = M.FormSelect.init(elems_select, {});

            setTimeout(() => {
                $("menu a").each(function(){
                    if($(this).hasClass('active')) $(this).removeClass('active');
                });
                var current_menu_item = $("menu a").first();
                if(!current_menu_item.hasClass('active'))current_menu_item.addClass('active');

                $("#general_loader").hide();
            }, 50);
        },
        updated(){
            var elems_select = document.querySelectorAll('select');
            var instances_select = M.FormSelect.init(elems_select, {});
        },
        beforeRouteEnter (to, from, next){
            getProductParams( (err, data) => {
                next(vm => vm.setParams(err, data));
            });
        },
        methods: {
            returnToCategory(){
                this.loaded = false;
                M.toast({html: 'Виконується перенаправлення до категорії'});

                this.error_message = null;
                this.product_errors.category_id = ' ';
                this.product_errors.type_id = ' ';
                this.product_errors.brand_id = ' ';
                this.product_errors.title = ' ';
                this.product_errors.short_description = ' ';
                this.product_errors.description = ' ';
                this.product_errors.composition = ' ';
                this.product_errors.price = ' ';
                this.product_errors.items_on_stock = ' ';
                this.product_errors.attachment = ' ';

                var catalog_id = this.product.category_id;

                this.$router.push({
                    path: `/admin/products/category/${catalog_id}`,
                    params: {catalog_id: catalog_id},
                    props: true
                });
            },
            onAttachmentChange (e) {
                if (window.File && window.FileList && window.FileReader) {
                    var files = event.target.files;
                    var logo_place = $(".card-image");

                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];

                        if (!file.type.match('image')) {
                            continue;}
                        var picReader = new FileReader();
                        var that = this;
                        picReader.addEventListener("load", function (event) {
                            var picFile = event.target;
//                    let tmp = '<img src="' + picFile.result + '" style="width:100%; height:100%;">';
                            let tmp = '<img src="' + picFile.result + '" style="margin: auto;height: auto;width: auto; max-width:444px; max-height:444px;">';
                            logo_place.html( tmp );

                            that.product.attachment = picFile.result;
                        });
                        picReader.readAsDataURL(file);
                    }
                }
            },
            onSubmit($event) {
                this.saving = true;
                this.message = false;
                this.error_message = null;
                this.loaded = false;

                this.product_errors.category_id = ' ';
                this.product_errors.type_id = ' ';
                this.product_errors.brand_id = ' ';
                this.product_errors.title = ' ';
                this.product_errors.short_description = ' ';
                this.product_errors.description = ' ';
                this.product_errors.composition = ' ';
                this.product_errors.price = ' ';
                this.product_errors.items_on_stock = ' ';
                this.product_errors.attachment = ' ';

                let that = this;
                axios.post('/api/product', this.product).then((response) => {
                    this.loaded = true;
                    M.toast({html: 'Продукт додан до каталогу'});
                })
                .catch((error) => {
                        this.loaded = true;
                        that.loaded = true;
                        that.saving = false;

                        this.error_message = 'Помилка даних. Виправьте помилки і знову надішліть форму.';

                        var product_errors = {
                            category_id: 'Оберіть категорію продукту',
                            type_id: 'Оберіть тип продукту',
                            brand_id: 'Оберіть бренд продукту',
                            title: "Вкажіть назву продукту",
                            short_description: "Додайте стислий опис продукту",
                            description: "Додайте повний опис продукту",
                            composition: "Додайте склад продукту",
                            price: "Вкажіть ціну продукту",
                            image: "Завантажте фото продукту",
                            items_on_stock: "Вкажіть кількість продукту",
                            attachment: "Завантажте фото продукту"
                        };
                        $.each(error.response.data.errors, function(ii, vv){
                            switch (ii) {
                                case 'category_id':
                                    that.product_errors.category_id = product_errors.category_id;
                                    break;
                                case 'type_id':
                                    that.product_errors.type_id = product_errors.type_id;
                                    break;
                                case 'brand_id':
                                    that.product_errors.brand_id = product_errors.brand_id;
                                    break;
                                case 'title':
                                    that.product_errors.title = product_errors.title;
                                    break;
                                case 'short_description':
                                    that.product_errors.short_description = product_errors.short_description;
                                    break;
                                case 'description':
                                    that.product_errors.description = product_errors.description;
                                    break;
                                case 'composition':
                                    that.product_errors.composition = product_errors.composition;
                                    break;
                                case 'price':
                                    that.product_errors.price = product_errors.price;
                                    break;
                                case 'items_on_stock':
                                    that.product_errors.items_on_stock = product_errors.items_on_stock;
                                    break;
                                case 'attachment':
                                    that.product_errors.attachment = product_errors.attachment;
                                    break;
                            }
                        })
                })
                .then(() => {
                    this.saving = false;
                    var catalog_id = this.product.category_id;
                    this.loaded = true;
                    if(!this.error_message){
                        M.toast({html: 'Виконується перенаправлення до категорії'});
                        this.loaded = false;
                        this.$router.push({
                            path: `/admin/products/category/${catalog_id}`,
                            params: {catalog_id: catalog_id},
                            props: true
                        });
                    }

                })
            },
            setParams(err, { data: params }) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.loaded = true;
                    this.product.category_id = this.$route.params.catalog_id;
                    let that = this;
                    $.each(params, function(k, v){
                        $.each(v, function(pp, vv){
                            if(pp == 'catalog'){
                                that.catalog = vv;
                            }
                            if(pp == 'types'){
                                that.product_types = vv;
                            }
                            if(pp == 'brends'){
                                that.product_brands = vv;
                            }
                            if(pp == 'attributes'){
                                that.product_attributes = vv;
                            }
                        });
                    })
                }
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
    #items_on_stock, #price, #product_name{
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
