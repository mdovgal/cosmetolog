<template>
    <div class="users">
        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>
        <div v-if="message" class="alert alert-success">{{ message }}</div>
        <div v-if="! loaded">Завантаження...</div>

        <div class="col-md-12 add_author">
            <router-link :to="{ name: 'users.create' }" tag="button" class="btn btn-primary" :disabled="saving">Новий автор</router-link>
        </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Автор</th>
                <th scope="col">email</th>
                <th scope="col">К-ть статтей</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody v-if="users">
            <tr v-for="{ id, name, email, role, articles } in users">
                <th scope="row">{{ id }}</th>
                <td>{{ name }}</td>
                <td>{{ email }}</td>
                <td>{{ count_articles(articles) }}</td>
                <td>
                    <router-link :to="{ name: 'article.add', params: { id } }"  tag="button" class="btn btn-primary" :disabled="saving" >
                        Додати статтю</router-link>
                    <router-link :to="{ name: 'users.edit', params: { id } }"  tag="button" class="btn btn-success" :disabled="saving" >
                        Редагувати</router-link>
                    <button @click="onDelete({ id })" class="btn btn-danger" :disabled="saving" >Видалити</button><br />
                    <div v-if="count_articles(articles)">
                        <span>Статті автора:</span>
                        <ul >
                            <li v-for="{ title } in articles">{{ title }}</li>
                        </ul>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" :disabled="! prevPage" @click.prevent="goToPrev">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">
                    {{ paginatonCount }}
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#" :disabled="! nextPage" @click.prevent="goToNext">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>
<script>
    import axios from 'axios';

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
                if(confirm('Ви дійсно бажаєте видалити автора та його статті?')){
                    this.saving = true;
                    axios
                        .delete(`/api/users/` + obj.id)
                        .then(response => {
                            this.message = 'Автор виделен';
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