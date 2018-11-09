<template>
    <div>
        <el-alert
                title="注意：上帝组拥有至高无上的权限."
                type="info">
        </el-alert>
        <br/>
        <el-form :inline="true" :model="form" size="small">
            <el-form-item label="ID">
                <el-input v-model="form.id" placeholder="ID"></el-input>
            </el-form-item>
            <el-form-item label="组名">
                <el-input v-model="form.title" placeholder="请输入权限组名"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSearch">查询</el-button>
            </el-form-item>
        </el-form>

        <el-row>
            <el-button type="primary" size="small" @click="handleAdd" v-if="auth.canAdd">新增</el-button>
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
                    <el-button type="text" size="small" v-if="scope.row.id != 1 && auth.canEdit" @click="editGroup(scope.row)">编辑</el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog title="新增/修改权限组" :visible.sync="addNewDialog" width="35%">
            <el-form ref="saveForm" :model="saveForm" label-width="100px" size="small" :rules="rulesForm">
                <el-form-item label="管理组名称" prop="title">
                    <el-input v-model="saveForm.title" style="width: 50%"></el-input>
                </el-form-item>
                <el-form-item label="选择权限" prop="rules">
                    <el-tree
                        :data="rulesTree"
                        show-checkbox
                        node-key="id"
                        ref="tree"
                        highlight-current
                        :default-checked-keys="saveForm.rules"
                        :check-strictly="true"
                        >
                    </el-tree>
                </el-form-item>

                <el-form-item label="状态" prop="status" required>
                    <el-switch v-model="saveForm.status" active-text="开启" inactive-text="关闭"></el-switch>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">保存</el-button>
                    <el-button  @click="addNewDialog = false">取消</el-button>
                </el-form-item>
            </el-form>

        </el-dialog>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getList();
            this.getRulesTree();
        },
        data() {
            return {
                tableData: [],
                form:{},
                addNewDialog:false,
                saveForm:{
                    title:'',
                    rules:[],
                    status:true
                },
                menusTree:[],
                rulesTree:[],
                auth:{},
                rulesForm:{
                    title: [
                        { required: true, message: '请输入管理组名称', trigger: 'blur' }
                    ],
                    menus: [
                        { required: true, message: '请选择菜单', trigger: 'blur' }
                    ],
                    rules: [
                        { required: true, message: '请选择权限', trigger: 'blur' }
                    ]
                }
            }
        },
        methods:{
            onSearch() {
                this.getList();
            },
            onSubmit() {
                this.getCheckedKeys();
                
                this.$refs['saveForm'].validate((valid) => {
                    if (valid) {
                        this.$http.post('/api/system/group/save', this.saveForm).then(res => {
                            if(res.error === 0) {
                                this.$message({
                                    message: '保存成功',
                                    type: 'success'
                                });
                                this.addNewDialog = false;
                                this.getList();
                            } else {
                                this.$message({
                                    message: res.msg,
                                    type: 'error'
                                });
                            }
                        });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });

            },

            getList() {
                this.$http.get('/api/system/group/list', this.form).then(res => {
                    this.tableData = res.data.list;
                    this.auth = res.data.auth;
                });
            },
            getRulesTree() {
                this.$http.get('/api/system/rule/list',{status:1}).then(res => {
                    this.rulesTree = res.data.list;
                });
            },
            handleAdd() {
                this.addNewDialog = true;
                if(typeof(this.$refs['saveForm']) !== 'undefined') this.$refs['saveForm'].resetFields();
                this.saveForm = {
                    title:'',
                    rules:[],
                    menus:[],
                    status:true
                };
                if(typeof(this.$refs.tree) !== 'undefined') this.$refs.tree.setCheckedKeys([]);
            },
            editGroup(row) {
                this.addNewDialog = true;
                if(typeof(this.$refs['saveForm']) !== 'undefined') this.$refs['saveForm'].resetFields();

                this.saveForm = {
                    id:row.id,
                    title:row.title,
                    rules:row.rules,
                    status:row.status === 1,
                };

                if(typeof(this.$refs.tree) !== 'undefined') this.$refs.tree.setCheckedKeys(this.saveForm.rules);
            },
            getCheckedKeys() {
                this.saveForm.rules = this.$refs.tree.getCheckedKeys();
            },
        }
    }
</script>