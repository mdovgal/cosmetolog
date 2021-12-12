<template>
    <div class="users">
        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>
        <div v-if="message" class="alert alert-success">{{ message }}</div>
        <div v-if="! loaded">Завантаження...</div>

        <h3>Косметологи</h3>
    </div>
</template>
<script>
</script>
<style>
    .add_author{text-align: end;margin: 17px 0px;}
</style>