<template>
    <div>
        <menu>
            <router-link :to="{ name: 'product.catalog' }">Каталог Товарів</router-link> |
            <router-link :to="{ name: 'cosmetologs.list' }" id="cosmetolog_section">Косметологи</router-link> |
            <router-link :to="{ name: 'customers.list' }" id="customer_section">Покупці</router-link> |
            <router-link :to="{ name: 'orders' }" id="orders_section">Замовлення</router-link>
            <!-- | <router-link :to="{ name: 'users.index' }">ALL Users</router-link> -->
        </menu>
        <div class="progress" id="general_loader">
            <div class="indeterminate"></div>
        </div>

        <div>
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>
