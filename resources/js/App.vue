<template>
    <el-container>
        <el-header :style="'height: ' + headerHeight + 'px'">
            <header-component />
        </el-header>
        <el-container>
            <el-aside  v-show="isLeftSideBarOn">
                <left-side-bar-component />
            </el-aside>
            
            <el-main :style="'height: ' + mainHeight + 'px'">
                    <el-container direction="vertical">
                        <!-- Broadcast area -->
                        <broadcast-area-component :isBroadcastOn = "isBroadcastOn" :bodyHeight="broadcastHeight"></broadcast-area-component>

                        <!-- Message area -->
                        <message-area-component :bodyHeight="messageAreaHeight"></message-area-component>

                        <!-- Input area -->
                        <input-area-component :bodyHeight="inputHeight"  :inputWidth="inputWidth" :inputRows="inputRows" @send-message="sendMessage"></input-area-component>

                    </el-container>
            </el-main>
            <el-aside v-show="isRightSideBarOn">
                <right-side-bar-component />
            </el-aside>
        </el-container>
        <el-footer v-show="isFooterOn" :style="'height: ' + footerHeight + 'px'">
            <footer-component />
        </el-footer>
    </el-container>
</template>

<script>
    export default {
        data () {
            return {
                headerHeight: 50,
                footerHeight: 30,
                inputHeight: 50,
                inputRows:2,
                broadcastHeight: 50,
                uiWidth: 800,
                uiHeight: 600,
                messages:[]
            }
        },
        created () {
            this.resizeUI()
        },
        mounted () {
            window.onresize = this.resizeUI

            /* setTimeout(() => {
                axios.post('/userlogin')
            }, 1000); */
            console.log('App Component mounted.')
        },
        methods: {
            sendMessage: function (data) {
                this.messages.push(data)
            },
            resizeUI: function () {
                this.uiWidth = window.innerWidth
                this.uiHeight = window.innerHeight
            }
        },
        computed: {
            mainHeight: function () {
                if (this.uiWidth < 700) {
                    return this.uiHeight - this.headerHeight
                } else {
                    return this.uiHeight - this.headerHeight - this.footerHeight
                }
            },
            messageAreaHeight: function () {
                if (this.isBroadcastOn) {
                    return this.mainHeight - this.inputHeight - this.broadcastHeight
                } else {
                    return this.mainHeight - this.inputHeight
                }
            },
            inputWidth: function () {
                if (this.uiWidth < 1000) {
                    return '100%'
                } else {
                    return '70%'
                }
            },
            isRightSideBarOn: function () {
                if (this.uiWidth >= 1000) {
                    return true
                } else {
                    return false
                }
            },
            isLeftSideBarOn: function () {
                if (this.uiWidth >= 700) {
                    return true
                } else {
                    return false
                }
            },
            isFooterOn: function () {
                if (this.uiWidth >= 700) {
                    return true
                } else {
                    return false
                }
            },
            isBroadcastOn: function () {
                return false
            }
        },
        components: {
            'HeaderComponent': require('./components/HeaderComponent'),
            'LeftSideBarComponent': require('./components/LeftSideBarComponent'),
            'RightSideBarComponent': require('./components/RightSideBarComponent'),
            'BroadcastAreaComponent': require('./components/BroadcastAreaComponent.vue'),
            'MessageAreaComponent': require('./components/MessageAreaComponent.vue'),
            'InputAreaComponent': require('./components/InputAreaComponent.vue'),
            'FooterComponent': require('./components/FooterComponent.vue')
        }
    }
</script>

<style scoped>
.el-header {
    padding: 0px 0px;
    background-color: rgb(54, 59, 58);
}
.el-aside {
    background-color:rgb(64, 146, 167);
}
.el-main {
    padding: 0px 0px;
}
.el-footer {
    padding: 0px 0px;
    background-color:rgb(64, 146, 167);
}
</style>
