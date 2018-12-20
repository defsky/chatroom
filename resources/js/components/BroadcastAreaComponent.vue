<template>
    <div v-show="isBroadcastOn" :style="'height: ' + bodyHeight + 'px'">Broadcast area</div>
</template>

<script>
    export default {
        data () {
            return {
                
            }
        },
        props: ['bodyHeight', 'isBroadcastOn'],
        mounted() {
            // console.log('Broadcst Component mounted.')
        }
    }
</script>

<style scoped>

</style>