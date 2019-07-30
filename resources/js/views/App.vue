<template>
    <div>
        <h1>xuexi_challenges</h1>
        <p>
            <router-link to="http://www.xuexi.cn">official site</router-link>
            <router-link :to="{ name: 'index' }">local site</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "App"
    }
</script>

<style scoped>

</style>
