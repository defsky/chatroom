<template>
    <el-tree
        :props="props1"
        :load="loadNode1"
        lazy
        highlight-current: true
        :style="styleObject">
    </el-tree>
</template>

<script>
    export default {
        data() {
            return {
                props1: {
                    label: 'name',
                    children: 'zones',
                    isLeaf: 'leaf'
                },
                styleObject: {
                    'background-color': 'rgb(54, 59, 58)',
                    height: '100%',
                    color: '#ffffff'
                }
            };
        },
        mounted() {
            
            // console.log('Left-side-bar Component mounted.')
        },
        methods: {
            loadNode1(node, resolve) {
                if (node.level === 0) {
                    return resolve([{ name: 'region' }]);
                }
                if (node.level > 1) return resolve([]);

                setTimeout(() => {
                    const data = [{
                    name: 'leaf',
                    leaf: true
                    }, {
                    name: 'zone',
                    leaf: false
                    }];

                    resolve(data);
                }, 500);
            }
        },
        computed: {
            
        }
    };
</script>

<style scoped>

</style>