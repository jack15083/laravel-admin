<template>
    <div>
        <el-row>
            <el-col :span="12" style="border-right: 1px solid #ccc;padding: 20px;min-height:800px">
                <el-form ref="saveForm" :model="saveForm" label-width="120px" size="small" :rules="rulesForm">
                    <el-form-item label="名称" prop="title">
                        <el-input v-model="saveForm.title" style="width: 50%"></el-input>
                    </el-form-item>
                    <el-form-item label="路径" prop="name">
                        <el-autocomplete
                                class="inline-input"
                                v-model="saveForm.name"
                                :fetch-suggestions="querySearch"
                                placeholder="请输入路径"
                                :trigger-on-focus="false"
                                style="width: 50%"
                        ></el-autocomplete>
                    </el-form-item>

                    <el-form-item label="是否作为菜单"  prop="menu">
                        <el-radio-group v-model="saveForm.menu">
                            <el-radio  label="1">是</el-radio>
                            <el-radio  label="0" >否</el-radio>
                        </el-radio-group>
                    </el-form-item>

                    <el-form-item label="状态" prop="status" >
                        <el-switch v-model="saveForm.status" active-text="开启" inactive-text="关闭"></el-switch>
                    </el-form-item>
                    <el-form-item label="父级菜单" prop="pid">
                        <treeselect v-model="saveForm.pid" :multiple="false"
                                    placeholder="请选择父级菜单"
                                    :options="menusTree" :default-expand-level="1" style="width: 50%"></treeselect>
                    </el-form-item>
                    <el-form-item label="备注" prop="remark">
                        <el-input v-model="saveForm.remark" style="width: 50%"></el-input>
                    </el-form-item>
                    <el-form-item label="菜单图标" prop="icon" v-if="saveForm.menu == 1">
                        <el-input v-model="saveForm.icon" style="width: 50%"></el-input>
                    </el-form-item>
                    <el-form-item label="菜单排序" prop="icon" v-if="saveForm.menu == 1">
                        <el-input v-model="saveForm.sort" style="width: 50%"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onSubmit">新增/保存</el-button>
                        <el-button  @click="resetFields">重置</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
            <el-col :span="12" style="padding: 20px;max-height: 800px;overflow-y: scroll">
                <el-row >
                    <el-input
                            placeholder="输入关键字进行过滤"
                            v-model="filterNodeText" style="width: 250px;" size="small">
                    </el-input>
                </el-row>
                <el-row style="padding-top: 10px;">
                    <el-tree
                            :data="rulesTree"
                            :default-expanded-keys = "expandKeys"
                            node-key="id"
                            ref="tree"
                            highlight-current
                            :filter-node-method="filterNode"
                            :expand-on-click-node="false"
                            :default-expand-all="false"
                    >
                        <span class="custom-tree-node" slot-scope="{ node, data }">
                            <span>
                                <span v-if="data.menu"><i class="fa fa-list" ></i></span>
                                <span v-if="!data.menu"><i class="fa fa-file-code-o"  ></i></span>
                                <span>{{data.label}}</span>
                            </span>
                            <span>
                                <el-button type="text" size="mini" @click="() => editRule(data)" v-if="auth.canEdit">编辑</el-button>
                                <el-button type="text" size="mini" @click="() => deleteRule(data)" v-if="auth.canEdit">删除</el-button>
                            </span>
                      </span>
                    </el-tree>
                </el-row>

            </el-col>
        </el-row>
    </div>
</template>

<script>
    import Treeselect from '@riophae/vue-treeselect'
    // import the styles
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'

    export default {
        components: { Treeselect },
        watch: {
            filterNodeText(val) {
                this.$refs.tree.filter(val);
            }
        },
        mounted() {
            this.getRoutes();
            this.getMenusTree();
            this.getRulesTree();
        },
        data() {
            return {
                routes: [],
                filterNodeText:'',
                form:{},
                saveForm:{
                    title:'',
                    name:'',
                    status:true,
                    menu:"0"
                },
                menusTree:[],
                rulesTree:[],
                auth:{},
                rulesForm:{
                    title: [
                        { required: true, message: '请输入名称', trigger: 'blur' }
                    ],
                    name: [
                        { required: true, message: '请输入路径', trigger: 'blur' }
                    ],
                    remark:[],
                    icon:[],
                    pid:[]
                },
                expandKeys:[]
            }
        },
        methods:{
            onSubmit() {
                this.$refs['saveForm'].validate((valid) => {
                    if (valid) {
                        this.$http.post('/api/system/rule/save', this.saveForm).then(res => {
                            if(res.error === 0) {
                                this.$message({
                                    message: '保存成功',
                                    type: 'success'
                                });
                                this.addNewDialog = false;
                                this.getRulesTree();
                                this.getMenusTree();
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

            filterNode(value, data) {
                if (!value) return true;
                return data.label.indexOf(value) !== -1;
            },

            querySearch(queryString, cb) {
                let restaurants = this.routes;
                let results = queryString ? restaurants.filter(this.createFilter(queryString)) : restaurants;
                // 调用 callback 返回建议列表的数据
                cb(results);
            },
            createFilter(queryString) {
                return (restaurant) => {
                    return (restaurant.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
                };
            },

            getRoutes() {
                this.$http.get('/api/system/rule/routes', this.form).then(res => {
                    this.routes = res.data.map(function (item) {
                        return {value:item};
                    });
                });
            },
            getMenusTree() {
                this.$http.get('/api/system/rule/list',{menu:1, status:1}).then(res => {
                    this.menusTree = res.data.list;
                });
            },
            getRulesTree() {
                this.$http.get('/api/system/rule/list',{}).then(res => {
                    this.rulesTree = res.data.list;
                    this.rulesTree.map(row => {
                        this.expandKeys.push(row.id);
                        for(let index in row.children) {
                            this.expandKeys.push(row.children[index].id);
                        }
                        return row;
                    });
                    this.auth = res.data.auth;
                });
            },
            resetFields() {
                if(typeof(this.$refs['saveForm']) !== 'undefined') this.$refs['saveForm'].resetFields();
                this.saveForm.id = undefined;
            },
            editRule(node) {
                if(typeof(this.$refs['saveForm']) !== 'undefined') this.$refs['saveForm'].resetFields();

                this.$http.get('/api/system/rule/get',{id:node.id}).then(res => {
                    this.saveForm = res.data;
                    this.saveForm.status = res.data.status === 1;
                    this.saveForm.menu += '';
                    this.saveForm.pid = this.saveForm.pid ? this.saveForm.pid : undefined;
                });
            },
            deleteRule(node) {
                this.$confirm('你确定删除这条记录吗?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.post('/api/system/rule/delete',{id:node.id}).then(res => {
                        this.getRulesTree();
                        this.getMenusTree();
                    });
                });

            }
        }
    }
</script>
<style>
    .custom-tree-node {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        padding-right: 8px;
    }
</style>