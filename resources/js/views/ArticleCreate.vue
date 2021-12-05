<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header alert-info">Додати статтю</div>
                    <div class="card-body">
                        <div v-if="error_message" class="alert alert-danger">{{ error_message }}</div>
                        <div v-if="message" class="alert alert-success">{{ message }}</div>
                        <form @submit.prevent="onSubmit($event)" method="post">
                            <input type="hidden"  v-model="article.author_id"  />
                            <div class="form-group row">
                                <label for="article_title" class="col-md-4 col-form-label text-md-right">
                                    Назва статті
                                </label>
                                <div class="col-md-6">
                                    <input id="article_title" type="text" class="form-control" v-model="article.title" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="category_id" class="col-md-4 col-form-label text-md-right">
                                    Категорія
                                </label>
                                <div class="col-md-6">
                                    <select id="category_id" v-model="article.category_id" class="form-control">
                                            <option v-for="category in categories" v-bind:value="category.id">{{category.title}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="article_text" class="col-md-4 col-form-label text-md-right">
                                    Текст
                                </label>
                                <div class="col-md-6">
                                    <textarea id="article_text" class="form-control" v-model="article.text" required ></textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn _btn-primary_ btn-success" :disabled="saving">
                                        {{ saving ? 'Зберігається...' : 'Додати' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                error_message: null,
                message: null,
                loaded: false,
                saving: false,
                article: {
                    id: null,
                    author_id: null,
                    category_id: null,
                    text: ""
                },
                categories: null,
                error: null
            };
        },
        beforeRouteEnter (to, from, next){
            axios
                .get('/api/category')
                .then(response => {
                    next(vm => {
                        vm.setCategoryData(response);
                        vm.article.author_id = to.params.id;
                    })
                }).catch(error => {
                    //error
                });
        },
        methods: {
            setCategoryData(response){
                this.categories = response.data.data;
            },
            onSubmit($event) {
                this.saving = true
                this.message = false;
                this.error_message = null;

                axios.post('/api/article', this.article).then((response) => {
                    this.message = 'Стаття додана';
                    setTimeout(() => this.message = null, 1500);
                    this.$router.push({ name: 'users.index'});
                })
                .catch((error) => {
                    this.error_message = error.response.data.message || error.message;
                })
                .then(() => this.saving = false)
            }
        }
    };
</script>
