<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                    <h5>Редагувати аккаунт косметолога</h5>
                    <div class="progress" v-if="!loaded">
                        <div class="indeterminate"></div>
                    </div>

                    <div class="card-body">
                        <div v-if="error_message" class="alert alert-danger">{{ error_message }}</div>
                        <div v-if="message" class="alert alert-success">{{ message }}</div>
                        <form @submit.prevent="onSubmit($event)" v-else>
                            <div class="form-group row">
                                <label for="user_name" class="col-md-4 col-form-label text-md-right">
                                    Ім'я
                                </label>
                                <div class="col-md-6">
                                    <input id="user_name" type="text" class="form-control" v-model="user.name" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="user_email" class="col-md-4 col-form-label text-md-right">
                                    Email
                                </label>
                                <div class="col-md-6">
                                    <input id="user_email" type="text" class="form-control" v-model="user.email" required />
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4 .right-align">
                                    <button type="submit" class="btn _btn-primary_ btn-success blue" :disabled="saving">Зберегти</button>
                                    <button class="btn btn-danger blue" :disabled="saving" @click.prevent="onDelete($event)">Видалити</button>
                                    <button class="btn btn-link blue" :disabled="saving" @click.prevent="onReturn($event)">Повернутися</button>
                                </div>
                            </div>
                        </form>
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

    import api from '../../api/users';

    export default {
        data() {
            return {
                error_message: null,
                message: null,
                loaded: false,
                saving: false,
                user: {
                    id: null,
                    name: "",
                    email: ""
                }
            };
        },
        mounted(){
            setTimeout(() => {
                $("menu a").each(function(){
                    if($(this).hasClass('active')) $(this).removeClass('active');
                });
                var current_menu_item = $("#cosmetolog_section");
                if(!current_menu_item.hasClass('active'))current_menu_item.addClass('active');

                $("#general_loader").hide();
            }, 50);
        },
        methods: {
            onSubmit(event){
                this.saving = true;
                this.loaded = false;
                this.error_message = null;

                api.update(this.user.id, {
                    name: this.user.name,
                    email: this.user.email,
                }).then((response) => {
                    this.loaded = true;
                    M.toast({html: 'Аккаунт відредагован'});
                    setTimeout(() => this.message = null, 2000);
                    this.user = response.data.data;
                }).catch(error => {
                    this.error_message = error.response.data.message || error.message;
                }).then(() => this.saving = false);
            },
            onDelete() {
                if(confirm('Ви дійсно бажаєте видалити аккаунт та його статті?')){
                    this.saving = true;
                    this.loaded = false;

                    api.delete(this.user.id)
                        .then((response) => {
                        M.toast({html: 'Аккаунт виделен'});
                        this.loaded = true;
                        this.$router.push({ name: 'users.index' });
                    });
                }
            },
            onReturn(){
                this.saving = true;
                this.loaded = false;
                this.$router.push({ name: 'cosmetologs.list' });
            }
        },
        created(){
            api.find(this.$route.params.id).then((response) => {
                this.loaded = true;
                this.user = response.data.data;
            }).catch((err) => {
                this.$router.push({ name: '404' });
            });
        }
    };
</script>
<style>
    #user_name, #user_email{
        border-bottom: 1px solid lightgrey !important;
        box-shadow: 0 1px 0 0 lightgrey !important;
    }
</style>
