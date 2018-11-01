<template>
    <div>
        <h1>Hello, Laravel-Admin!</h1>
        <el-button @click="testClick">测试ajax请求</el-button>
        <el-dialog :visible.sync="visible" title="提示" :close-on-click-modal="false">
            <p>欢迎使用 Laravel-Admin. </p>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                visible: false
            }
        },
        methods: {
            testClick() {
                var that = this;
                this.$http.get('/api/test', {}, function (res) {
                    that.visible = true;
                });
            }
        }
    }
</script>

<style>
    .hello {
        font-size: 2em;
        color: green;
    }
</style>

