<template>
    <div>
        <p>
            <router-link :to="{ name: 'users.index' }">Автори блогів</router-link> | ...
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>