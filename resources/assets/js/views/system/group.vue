<template>
    <div>
        <el-form :inline="true" :model="form" size="small">
            <el-form-item label="ID">
                <el-input v-model="form.id" placeholder="ID"></el-input>
            </el-form-item>
            <el-form-item label="组名">
                <el-input v-model="form.title" placeholder="请输入权限组名"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">查询</el-button>
            </el-form-item>
        </el-form>

        <el-row>
            <el-button type="primary" size="small">新增</el-button>
        </el-row>
        <el-table
                :data="tableData"
                style="max-width: 900px;"
        >
            <el-table-column
                    prop="id"
                    label="ID"
                    width="100"
                    >
            </el-table-column>
            <el-table-column
                    prop="title"
                    label="权限组名"
                   >
            </el-table-column>
            <el-table-column
                    label="组状态"
                    width="150"
            >
                <template slot-scope="scope">
                    <el-tag type="success" v-if="scope.row.status == 1" size="small">已启用</el-tag>
                    <el-tag type="info" v-if="scope.row.status == 0" size="small">已禁用</el-tag>
                </template>
            </el-table-column>
            <el-table-column
                    fixed="right"
                    label="操作"
                    width="100">
                <template slot-scope="scope">
                    <el-button @click="handleClick(scope.row)" type="text" size="small">授权</el-button>
                    <el-button type="text" size="small">编辑</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getList();
        },
        data() {
            return {
                tableData: [],
                form:{}
            }
        },
        methods:{
            onSubmit() {
                this.getList();
            },

            getList() {
                let that = this;
                this.$http.get('/api/system/group/list', this.form, function (res) {
                    that.tableData = res.data;
                });
            }
        }
    }
</script>