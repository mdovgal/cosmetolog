<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header alert-info">Додати нового автора</div>
                    <div class="card-body">
                        <div v-if="error_message" class="alert alert-danger">{{ error_message }}</div>
                        <div v-if="message" class="alert alert-success">{{ message }}</div>
                        <form @submit.prevent="onSubmit($event)" method="post">
                        <input type="hidden"  v-model="user.role"  />
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

                            <div class="form-group row">
                                <label for="user_password" class="col-md-4 col-form-label text-md-right">
                                    Пароль
                                </label>
                                <div class="col-md-6">
                                    <input id="user_password" type="password" class="form-control" v-model="user.password" required />
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
    import api from '../api/users';

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
                    email: "",
                    password: "",
                    role: "cosmt",
                }
            };
        },
        methods: {
            onSubmit($event) {
                this.saving = true
                this.message = false;
                this.error_message = null;

                api.create(this.user).then((response) => {
                    this.message = 'Автор додан';
                    setTimeout(() => this.message = null, 1000);
                    this.$router.push({ name: 'users.edit', params: { id: response.data.data.id } });
                })
                .catch((error) => {
                    this.error_message = error.response.data.message || error.message;
                })
                .then(() => this.saving = false)
            }
        }
    };
</script>
