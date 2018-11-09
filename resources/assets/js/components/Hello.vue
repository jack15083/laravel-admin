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
                this.$http.get('/api/test', {}).then(res => {
                    console.log(res);
                    this.visible = true;
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

