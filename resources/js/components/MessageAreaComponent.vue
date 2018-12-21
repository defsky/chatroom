<template>
    <el-main :style="'height: ' + bodyHeight + 'px'" ref="messageList">
        <ul class="message-list">
            <li v-for="message in messages">
                <div class="message-title" v-if="message.title" v-html="message.title"></div>
                <div class="message-body" v-if="message.body" v-html="message.body"></div>
            </li>
        </ul>
    </el-main>
</template>

<script>
    export default {
        data () {
            return {
                messages: []
            }
        },
        created() {
            const channel = 'public'

        },
        mounted() {
            // console.log('Message Component mounted.')
        },
        props: ['bodyHeight'],
        computed: {

        },
        methods: {
            appendMessage: function (message) {
                this.messages.push(message);
            }
        },
        watch: {
            messages () {
                this.$nextTick(() => {
                    // var container = this.$el.querySelector('#messageList')
                    var component = this.$refs.messageList
                    component.$el.scrollTop = component.$el.scrollHeight
                    console.log('scrolled')
                })
            }
        },
        sockets: {
            "public:user.login" : function (data) {
                //console.log(data);
                var username = data.user.name ? data.user.name : data.user.id
                var message = {
                    title: data.user.name + '(' + data.user.id + ') 加入群聊',
                    body: ''
                }
                this.appendMessage(message)
            },
            "public:user.logout" : function (data) {
                //console.log(data);
                var message = {
                    title: data.user.name + '(' + data.user.id + ') 退出群聊',
                    body: ''
                }
                this.appendMessage(message)
            },
            "public:user.message" : function (data) {
                var message = {
                    title: data.user.name + '('+ data.user.id + ') ' + (new Date()).toLocaleTimeString(),
                    body: data.message.replace(/\n/g, '<br>')
                }
                this.appendMessage(message)
            },
            disconnect: function () {
                axios.post('/userlogout')
                console.log('disconnected')
            }
        }
    }
</script>

<style scoped>
.el-main {
    border-top: 1px solid rgb(64, 146, 167);
    border-bottom: 1px solid rgb(64, 146, 167);
}
.message-list {
    list-style: none;
    padding: 5px;
}
.message-title {
    color: rgb(119, 121, 121)
}
.message-body {
    color:black
}
</style>