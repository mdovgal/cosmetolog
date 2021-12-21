<template>
    <div class="users">
        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>
        <div v-if="message" class="alert alert-success">{{ message }}</div>
        <div class="progress" v-if="!loaded">
            <div class="indeterminate"></div>
        </div>

        <div class="col-md-12 add_author">
            <router-link :to="{ name: 'users.create' }" tag="button" class="btn btn-primary blue" :disabled="saving">Новий аккаунт</router-link>
        </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Ім'я косметологу</th>
                <th scope="col">email</th>
                <th scope="col">К-ть статтей</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody v-if="users">
            <tr v-for="{ id, name, email, role, articles } in users">
                <td style="vertical-align: top;">{{ name }}</td>
                <td style="vertical-align: top;">{{ email }}</td>
                <td style="vertical-align: top;">{{ count_articles(articles) }}</td>
                <td>
                    <router-link :to="{ name: 'users.edit', params: { id } }"  tag="button" class="btn btn-success blue" :disabled="saving" >
                        Редагувати</router-link>
                    <button @click="onDelete({ id })" class="btn blue" :disabled="saving" >Видалити</button><br />
                    <div v-if="count_articles(articles)">
                        <h6><b>Статті:</b></h6>
                        <ul >
                            <li v-for="{ title } in articles">{{ title }}</li>
                        </ul>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import Vue from 'vue';
    import M from 'materialize-css';
    import 'materialize-css/dist/css/materialize.min.css';
    import axios from 'axios';
    import JQuery from 'jquery';
    let $ = JQuery;

    const getUsers = (page, callback) => {
        const params = { page };

        axios
            .get('/api/users', { params })
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
                users: null,
                meta: null,
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null,
                },
                error: null,
            };
        },
        computed: {
            nextPage() {
                if (! this.meta || this.meta.current_page === this.meta.last_page) {
                    return;
                }

                return this.meta.current_page + 1;
            },
            prevPage() {
                if (! this.meta || this.meta.current_page === 1) {
                    return;
                }

                return this.meta.current_page - 1;
            },
            paginatonCount() {
                if (! this.meta) {
                    return;
                }

                const { current_page, last_page } = this.meta;

                return `${current_page} of ${last_page}`;
            },
        },
        beforeRouteEnter (to, from, next){
            getUsers(to.query.page, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        beforeRouteUpdate (to, from, next) {
            this.users = this.links = this.meta = null
            getUsers(to.query.page, (err, data) => {
                this.setData(err, data);
                next();
            });
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
            count_articles: function(articles){
                return articles.length;
            },
            goToNext() {
                this.$router.push({
                    query: {
                        page: this.nextPage,
                    },
                });
            },
            goToPrev() {
                this.$router.push({
                    name: 'users.index',
                    query: {
                        page: this.prevPage,
                    }
                });
            },
            onDelete(obj){
                if(confirm('Ви дійсно бажаєте видалити аккаунт та його статті?')){
                    this.saving = true;
                    this.loaded = false;
                    axios
                        .delete(`/api/users/` + obj.id)
                        .then(response => {
                            M.toast({html: 'Аккаунт виделен'})
                            this.loaded = true;
                            setTimeout(() => {this.message = null; this.saving}, 1500);
                            this.$router.go();
                        });
                    ;
                }
            },
            setData(err, { data: users, links, meta }) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.users = users;
                    this.links = links;
                    this.meta = meta;
                }
            },
        }
    }
</script>
<style>
    .add_author{text-align: end;margin: 17px 0px;}
</style>