<template>
    <div>
        <el-form :inline="true" :model="form" size="small">
            <el-form-item label="ID">
                <el-input v-model="form.id" placeholder="ID"></el-input>
            </el-form-item>
            <el-form-item label="登录名">
                <el-input v-model="form.username" placeholder="请输入登录名"></el-input>
            </el-form-item>
            <el-form-item label="真实姓名">
                <el-input v-model="form.realname" placeholder="请输入真实姓名"></el-input>
            </el-form-item>
            <el-form-item label="手机号">
                <el-input v-model="form.mobile" placeholder="请输入手机号"></el-input>
            </el-form-item>
            <el-form-item label="邮箱">
                <el-input v-model="form.email" placeholder="请输入邮箱"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSearch">查询</el-button>
            </el-form-item>
        </el-form>

        <el-row>
            <el-button type="primary" size="small" @click="handleAdd" v-if="auth.canAdd">新增</el-button>
        </el-row>
        <el-table :data="tableData">
            <el-table-column prop="id" label="ID" width="80"></el-table-column>
            <el-table-column prop="username" label="用户名" ></el-table-column>
            <el-table-column prop="realname" label="真实姓名"></el-table-column>
            <el-table-column prop="mobile" label="手机号"></el-table-column>
            <el-table-column prop="email" label="邮箱"></el-table-column>
            <el-table-column
                    label="用户状态"
                    width="150"
            >
                <template slot-scope="scope">
                    <el-tag type="success" v-if="scope.row.status == 1" size="small">正常</el-tag>
                    <el-tag type="info" v-if="scope.row.status == 0" size="small">禁用</el-tag>
                </template>
            </el-table-column>
            <el-table-column prop="last_login" label="最后登录时间"></el-table-column>
            <el-table-column prop="last_ip" label="登录IP"></el-table-column>
            <el-table-column prop="create_time" label="创建时间"></el-table-column>

            <el-table-column
                    fixed="right"
                    label="操作"
                    width="100">
                <template slot-scope="scope">
                    <el-button type="text" size="small" v-if="auth.canEdit" @click="editRow(scope.row)">编辑</el-button>
                </template>
            </el-table-column>
        </el-table>
        <br/>
        <el-row>
            <el-col :span="13" :offset="11">
                <el-pagination
                        background
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :current-page="form.page"
                        :page-sizes="[25, 50, 100]"
                        :page-size="form.pageSize"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total="totalItems">
                </el-pagination>
            </el-col>
        </el-row>
        <br/>


        <el-dialog title="新增/修改管理员" :visible.sync="addNewDialog" width="35%">
            <el-form ref="saveForm" :model="saveForm" label-width="100px" size="small" :rules="rulesForm">
                <el-form-item label="登录名" prop="username">
                    <el-input v-model="saveForm.username" style="width: 50%"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="password">
                    <el-input v-model="saveForm.password" style="width: 50%"></el-input>
                </el-form-item>
                <el-form-item label="用户组" prop="groups">
                    <el-select v-model="saveForm.groups" multiple placeholder="请选择" style="width: 50%">
                        <el-option
                                v-for="item in groups"
                                :key="item.id"
                                :label="item.title"
                                :value="item.id" >
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="真实姓名" prop="realname">
                    <el-input v-model="saveForm.realname" style="width: 50%"></el-input>
                </el-form-item>
                <el-form-item label="手机号" prop="mobile">
                    <el-input v-model="saveForm.mobile" style="width: 50%"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" prop="email">
                    <el-input v-model="saveForm.email" style="width: 50%"></el-input>
                </el-form-item>
                <el-form-item label="状态" prop="status" >
                    <el-switch v-model="saveForm.status" active-text="正常" inactive-text="禁用"></el-switch>
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
            this.getGroupList();
        },
        data() {
            return {
                tableData: [],
                form:{
                    page:1,
                    pageSize:20
                },
                addNewDialog:false,
                saveForm:{
                    id:'',
                    username:'',
                    password:'',
                    groups:[],
                    status:true
                },
                totalItems:0,
                groups:[],
                auth:{},
                rulesForm:{
                    username: [
                        { required: true, message: '请输入用户名称', trigger: 'blur' }
                    ],
                    realname: [
                        { required: true, message: '请输入真实姓名', trigger: 'blur' }
                    ],
                    groups:[
                        { required: true, message: '请选择用户组', trigger: 'blur' }
                    ]
                }
            }
        },
        methods:{
            onSearch() {
                this.form.page = 1;
                this.getList();
            },
            handleSizeChange(size) {
                this.form.pageSize = size;
                this.getList();
            },
            handleCurrentChange(page) {
                this.form.page = page;
                this.getList();
            },
            onSubmit() {
                this.$refs['saveForm'].validate((valid) => {
                    if (valid) {
                        if(typeof(this.saveForm.password) ===  'undefined') {
                            this.saveForm.password = '';
                        }
                        if(!this.saveForm.id && this.saveForm.password.length < 6) {
                            this.$message({
                                message: '请输入不少于6位的密码',
                                type: 'error'
                            });

                            return;
                        }
                        this.$http.post('/api/system/admin/save', this.saveForm).then(res => {
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

            getGroupList() {
                this.$http.get('/api/system/group/list', {status:1}).then(res => {
                    this.groups = res.data.list;
                });
            },

            getList() {
                this.$http.get('/api/system/admin/list', this.form).then(res => {
                    this.tableData = res.data.data;
                    this.totalItems = res.data.total;
                    this.auth = res.data.auth;
                });
            },
            handleAdd() {
                this.addNewDialog = true;
                if(typeof(this.$refs['saveForm']) !== 'undefined') this.$refs['saveForm'].resetFields();

            },
            editRow(row) {
                this.addNewDialog = true;
                if(typeof(this.$refs['saveForm']) !== 'undefined') this.$refs['saveForm'].resetFields();

                this.saveForm = {
                    id:row.id,
                    username:row.username,
                    groups:row.groups,
                    realname:row.realname,
                    mobile:row.mobile,
                    email:row.email,
                    status:row.status === 1,
                };
            },
        }
    }
</script>