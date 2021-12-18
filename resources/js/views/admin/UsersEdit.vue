<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header alert-info">Редагувати автора</div>
                    <div class="card-body">
                        <div v-if="error_message" class="alert alert-danger">{{ error_message }}</div>
                        <div v-if="message" class="alert alert-success">{{ message }}</div>
                        <div v-if="! loaded">Завантаження...</div>
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
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn _btn-primary_ btn-success" :disabled="saving">Зберегти</button>
                                    <button class="btn btn-danger" :disabled="saving" @click.prevent="onDelete($event)">Видалити</button>
                                    <button class="btn btn-link" :disabled="saving" @click.prevent="onReturn($event)">Повернутися</button>
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
        methods: {
            onSubmit(event){
                this.saving = true;
                this.error_message = null;

                api.update(this.user.id, {
                    name: this.user.name,
                    email: this.user.email,
                }).then((response) => {
                    this.message = 'Автор відредагован';
                    setTimeout(() => this.message = null, 2000);
                    this.user = response.data.data;
                }).catch(error => {
                    this.error_message = error.response.data.message || error.message;
                }).then(() => this.saving = false);
            },
            onDelete() {
                if(confirm('Ви дійсно бажаєте видалити автора та його статті?')){
                    this.saving = true;

                    api.delete(this.user.id)
                        .then((response) => {
                        this.message = 'Автор виделен';
                        this.$router.push({ name: 'users.index' });
                    });
                }
            },
            onReturn(){
                this.saving = true;
                this.$router.push({ name: 'users.index' });
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
