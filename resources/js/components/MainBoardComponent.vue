<template>
    <el-container direction="vertical">
        <!-- Broadcast area -->
        <broadcast-area-component></broadcast-area-component>

        <!-- Message area -->
        <message-area-component></message-area-component>

        <!-- Input area -->
        <input-area-component></input-area-component>

    </el-container>
</template>

<script>
    export default {
        data () {
            return {

            }
        },
        mounted() {
            // console.log('Main board Component mounted.')
        },
        components: {
            'BroadcastAreaComponent': require('./BroadcastAreaComponent.vue'),
            'MessageAreaComponent': require('./MessageAreaComponent.vue'),
            'InputAreaComponent': require('./InputAreaComponent.vue')
        }
    }
</script>

<style scoped>

</style>