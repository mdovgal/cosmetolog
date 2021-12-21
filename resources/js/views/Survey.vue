<template>
    <div class="row survey">
        <div class="row" v-if="catalog">
            <div class="col s12">
                <div class="row">
                    <div class="col s12">
                        <blockquote style="border-left: 5px solid #80d8ff">
                            <h5 style="margin-top: 42px;">Рекомендовані наступні засоби для догляду за шкірою обличчя</h5>
                        </blockquote>
                    </div>

                    <ul class="collapsible">
                        <li v-for="(product_type, index) in catalog">
                            <div class="collapsible-header"><i class="material-icons">filter_drama</i>{{ index }}</div>
                            <div class="collapsible-body">

                                <div class="row products_row" v-for="row in product_type">
                                    <div class="col s4" v-for="{id, image, title, short_description, price, items_on_stock} in row">
                                        <div class="card">
                                            <div class="card-image">
                                                <img v-if="image" :src="image">
                                                <img v-else src="/img/product_placeholder.png">

                                                <router-link :to="{ name: 'product.view', params: { id } }" target="_blank" class="btn-floating halfway-fab waves-effect waves-light blue delete" >
                                                    <i class="material-icons">description</i>
                                                </router-link>

                                            </div>
                                            <div class="card-content">
                                                <h6><b>{{title}}</b></h6>
                                                <div class="row short_description" v-html="short_description"></div>
                                                <div class="row price" v-if="items_on_stock">
                                                    <div class="col s6"></div>
                                                    <div class="col s6">Ціна, грн</div>
                                                </div>
                                                <div class="row price">
                                                    <div class="col s6"></div>
                                                    <div v-if="items_on_stock" class="col s6"><b>{{ price }}</b></div>
                                                    <div v-else class="col s6 red-text">Немає на складі</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="col s2" style="margin: 0px 15px;">
                <a class="waves-effect waves-light btn blue lighten-4" @click="returnToCategory()">
                Повернутись до каталогу
                </a>
            </div>
        </div>
        <div class="row" v-if="!catalog">
            <form @submit.prevent="onSubmit($event)" method="post" enctype="multipart/form-data">
            <div class="col s12">
                <div class="row">
                    <div class="col s12">
                        <blockquote style="border-left: 5px solid #80d8ff">
                            <h5 style="margin-top: 42px;">Анкета для підбору догляду за шкірою обличчя</h5>
                        </blockquote>
                    </div>
                    <div class="col s12">
                            <h6 style="margin-top: 42px;">Ваша вікова група</h6>
                    </div>
                    <div class="row">
                          <div class="col" v-for="item in survey.q1">
                              <label>
                                  <input class="with-gap" name="q1" :value="item.id" type="radio"   v-model="survey.attr1"/>
                                  <span>{{ item.title }}</span>
                              </label>
                          </div>
                    </div>
                    <div class="col s12">
                            <h6 style="margin-top: 42px;">Ваш тип шкіри</h6>
                    </div>
                    <div class="row">
                          <div class="col" v-for="item in survey.q2">
                              <label>
                                  <input class="with-gap" name="q2" :value="item.id" type="radio"  v-model="survey.attr2"/>
                                  <span>{{ item.title }}</span>
                              </label>
                          </div>
                    </div>
                    <div class="col s12">
                            <h6 style="margin-top: 42px;">Поточні проблеми</h6>
                    </div>
                    <div class="row"  v-for="row in survey.q3">
                          <div class="col" v-for="(item, index) in row">
                              <label>
                                  <input type="checkbox" :value="item.id"  v-model="survey.attr3"/>
                                  <span>{{ item.title }}</span>
                              </label>
                          </div>
                    </div>
                    <div class="col s12">
                        <h6 style="margin-top: 42px;">Алергічні реакції</h6>
                    </div>
                    <div class="row">
                        <div class="col" v-for="item in survey.q4">
                            <label>
                                <input class="with-gap" name="q4" :value="item.id" type="radio"  v-model="survey.attr4"/>
                                <span>{{ item.title }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">

                <div class="col s2" style="margin: 0px 15px;">
                    <a class="waves-effect waves-light btn blue-grey lighten-4" @click="returnToCategory()">
                    Повернутись до каталогу
                    </a>
                </div>
                <div class="col s2" style="margin: 0px 15px;">
                    <button type="submit" class="waves-effect waves-light btn light-blue" :disabled="saving">
                        {{ saving ? 'Відправляється...' : 'Відправити анкету' }}
                    </button>
                </div>
            </div>
            </form>
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

    export default {
        data(){
            return {
                error_message: null,
                message: null,
                is_updated: false,
                saving: false,
                catalog:null,
                survey: {
                    attr1:null,
                    attr2:null,
                    attr3:[],
                    attr4:null,
                    q1:[{title:'Юна', id:29},{title:'Середньої зрілості', id:30},{title:'Зріла', id:3},{title:'З ознаками старіння', id:11}],
                    q2:[{title:'Нормальна', id:6},{title:'Суха', id:8},{title:'Жирна', id:1},{title:'Комбінована', id:5}],
                    q3:[[{title:'Зморшки', id:27},{title:'Тускла шкіра', id:28},{title:'Набряклість', id:26},{title:'Зниження тонусу', id:25},{title:'Пігментація', id:20}],
                        [{title:'Судинні зірочки', id:23},{title:'Рроздратування шкіри', id:16},{title:'Великі пори', id:32},{title:'Зневодненість', id:18},{title:'Прищі', id:21}]],
                    q4:[{title:'Так', id:''},{title:'Ні', id:''}],
                }
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
        },
        methods:{
            onSubmit($event) {
                this.saving = true;

                axios
                .post('/api/survey', this.survey).then((response) => {
                    this.loaded = true;
                    this.saving = false;
console.log('~~~> POST RESPONSE: ', response);
                    this.catalog = response.data.data;
                })
                .catch((error) => {
                    this.saving = false;
                })
            },
            returnToCategory(){
                this.loaded = false;
                M.toast({html: 'Виконується перенаправлення до продуктового каталогу'});

                this.$router.push({ name: 'product.catalog' })
            }
        }
    }
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

    .row.survey .row.products_row .card{ width: 440px; min-height: 539px;}
    .row.survey .row.products_row .card-image{width: 442px;}
    .row.survey .btn-floating.halfway-fab.delete{right: 19px;}
</style>