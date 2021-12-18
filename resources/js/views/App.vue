<template>
    <div>
        <menu>
            <router-link :to="{ name: 'product.catalog' }">Каталог Товарів</router-link> |
            <router-link :to="{ name: 'cosmetologs.list' }">Косметологи</router-link> |
            <router-link :to="{ name: 'customers.list' }">Покупці</router-link> |
            <router-link :to="{ name: 'orders' }">Замовлення</router-link>
        </menu>

        <div>
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>