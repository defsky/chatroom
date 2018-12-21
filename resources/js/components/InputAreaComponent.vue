<template>
    <el-main :style="'height: ' + bodyHeight + 'px'">
        <el-container direction="horizental">
            <el-input
                type="textarea"
                :rows="inputRows"
                placeholder="这里输入要发送的消息 ..."
                v-model="message"
                size="small"
                resize="false"
                :style="'width: ' + inputWidth"
                ref="inputArea">
                
            </el-input>
            <el-button type="primary" @click="sendMessage">发送</el-button>
        </el-container>
    </el-main>
</template>

<script>
    export default {
        data () {
            return {
                message: ''
            }
        },
        mounted() {
            // console.log('Input Component mounted.')
        },
        props: ['bodyHeight', 'inputWidth', 'inputRows'],
        methods: {
            sendMessage: function () {
                if (this.message) {
                    // this.$emit('send-message', this.message);
                    // this.$socket.emit('message', {message: this.message});
                    axios.post('/sendmessage', {'message': this.message})
                    this.message = ''
                }
                this.$refs.inputArea.focus()
            }
        }
    }
</script>

<style scoped>
.el-textarea__inner {
    margin: 5px;
}
</style>