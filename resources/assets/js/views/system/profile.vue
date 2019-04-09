<template>
    <div>
        <el-alert
                title="个人资料"
                type="info">
        </el-alert>
        <br/><br/>
        <el-row>
            <el-col >
                <el-form  label-width="100px" style="width: 600px;margin-right: auto;margin-left: auto">
                    <el-form-item label="上传头像" prop="pass">
                        <el-upload
                                class="avatar-uploader"
                                action="/api/system/admin/avatar/upload"
                                :show-file-list="false"
                                :on-success="handleAvatarSuccess"
                                :before-upload="beforeAvatarUpload">
                            <img v-if="imageUrl" :src="imageUrl" class="upload-avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>

                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="saveAvatar">保存</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
        <el-alert
                title="修改密码"
                type="info">
        </el-alert>
        <br/><br/>
        <el-row>
            <el-col >

                <el-form :model="saveForm" status-icon :rules="rules" ref="saveForm" label-width="100px"
                         style="width: 600px;margin-right: auto;margin-left: auto">
                    <el-form-item label="原密码" prop="old_password">
                        <el-input type="password" v-model="saveForm.old_password" style="width: 300px;" autocomplete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="新密码" prop="password">
                        <el-input type="password" v-model="saveForm.password" style="width: 300px;" autocomplete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="确认密码" prop="check_password">
                        <el-input type="password" v-model="saveForm.check_password" style="width: 300px;" autocomplete="off"></el-input>
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" @click="onSubmit('saveForm')">提交</el-button>
                        <el-button @click="resetForm('saveForm')">重置</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getProfile();
        },
        data() {
            const validatePass = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入密码'));
                } else if(value.length < 6) {
                    callback(new Error('密码不能少于6位'));
                }
                else {
                    if (this.saveForm.check_password !== '') {
                        this.$refs.saveForm.validateField('check_password');
                    }
                    callback();
                }
            };
            const validatePass2 = (rule, value, callback) => {
                    if (value === '') {
                        callback(new Error('请再次输入密码'));
                    } else if (value !== this.saveForm.password) {
                        callback(new Error('两次输入密码不一致!'));
                    } else {
                        callback();
                    }
            };

            return {
                saveForm: {
                    old_password:'',
                    check_password:'',
                    password:''
                },
                rules: {
                    old_password: [
                        { required:true,  message: '请输入原密码', trigger: 'blur' }
                    ],
                    password: [
                        { validator: validatePass, trigger: 'blur' }
                    ],
                    check_password: [
                        { validator: validatePass2, trigger: 'blur' }
                    ]
                },
                imageUrl: ''
            }
        },
        methods:{
            onSubmit(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$http.post('/api/system/admin/password/change', this.saveForm).then(res => {
                            if(res.error === 0) {
                                this.$message({
                                    message: '保存成功',
                                    type: 'success'
                                });
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
            getProfile() {
                this.$http.get('/api/system/admin/profile/get', {}).then(res => {
                    if(res.error === 0) {
                        this.imageUrl = res.data.avatar;
                    }
                });
            },

            saveAvatar() {
                if(!this.imageUrl) {
                    this.$message.error('请上传头像！');
                    return false;
                }

                this.$http.post('/api/system/admin/avatar/save', {avatar: this.imageUrl}).then(res => {
                    if(res.error === 0) {
                        this.$message({
                            message: '保存成功',
                            type: 'success'
                        });

                    } else {
                        this.$message({
                            message: res.msg,
                            type: 'error'
                        });
                    }
                });

            },

            resetForm(formName) {
                this.$refs[formName].resetFields();
            },

            handleAvatarSuccess(res, file) {
                this.imageUrl = res.data.img_path;
            },
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG) {
                    this.$message.error('上传头像图片只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            }
        }
    }
</script>

<style>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .upload-avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>