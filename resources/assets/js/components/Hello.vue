<template>
    <div>
        <h1>Hello, Laravel-Admin!</h1>
        <el-button @click="testClick">测试ajax请求</el-button>
        <el-dialog v-model="visible">
            <p>欢迎使用 Laravel-Admin</p>
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
                this.$http.get('/api/test', {}, function (res) {
                    alert(res.error);
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

