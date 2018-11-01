<template>
    <div>
        <el-container>
            <el-header style="height: 50px;padding:0" class="main-header">
                <!-- Logo -->
                <a href="index2.html" class="logo" :style="logoStyle">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini" v-if="isCollapse"><b>LA</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg" v-if="!isCollapse"><b>Laravel</b>-Admin</span>
                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" :style="navbarStyle">
                    <el-row>
                        <el-col :span="4">
                            <a type="text" class="sidebar-toggle" data-toggle="offcanvas" @click="switchNav">&nbsp;</a>
                        </el-col>
                        <el-col :span="20" style="float:right">
                            <el-row style="float: right">
                                <!-- Navbar Right Menu -->
                                <el-dropdown trigger="click" class="user-info-menu" >
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                                        <img src="/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                        <span class="hidden-xs">Super-Admin</span>
                                    </a>
                                    <el-dropdown-menu slot="dropdown" class="dropdown-menu">
                                        <el-dropdown-item class="user-header" >
                                            <img src="/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                            <p>
                                                Super-Admin - 高级管理员<br/>
                                                <small>Member since Nov. 2018</small>
                                            </p>
                                        </el-dropdown-item>

                                        <el-dropdown-item class="user-footer" :divided="true">
                                            <div class="pull-left">
                                                <el-button type="text">设置</el-button>
                                            </div>
                                            <div class="pull-right">
                                                <el-button type="text">退出</el-button>
                                            </div>
                                        </el-dropdown-item>

                                    </el-dropdown-menu>
                                </el-dropdown>
                            </el-row>

                        </el-col>
                    </el-row>

                </nav>
            </el-header>
            <el-container class="main-container">
                <el-aside :width="asideWidth">
                    <el-menu
                            default-active="4-3"
                            class="el-menu-custom"
                            :collapse="isCollapse"
                            :router="true"
                            text-color="#fff"
                            active-text-color="#ffd04b"
                            style="border-right: 0"
                    >

                        <el-submenu index="1">
                            <template slot="title">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </template>

                            <el-menu-item-group>
                                <template slot="title">分组一</template>
                                <el-menu-item index="1-1">选项1</el-menu-item>
                                <el-menu-item index="1-2">选项2</el-menu-item>
                            </el-menu-item-group>
                            <el-menu-item-group title="分组2">
                                <el-menu-item index="1-3">选项3</el-menu-item>
                            </el-menu-item-group>
                            <el-submenu index="1-4">
                                <template slot="title">选项4</template>
                                <el-menu-item index="1-4-1">选项1</el-menu-item>
                            </el-submenu>
                        </el-submenu>
                        <el-submenu index="4">
                            <template slot="title">
                                <i class="fa fa-gear"></i>
                                <span>系统设置</span>
                            </template>
                            <el-menu-item index="4-1" route="/system/group">个人设置</el-menu-item>
                            <el-menu-item index="4-2" route="/system/group">管理员列表</el-menu-item>
                            <el-menu-item index="4-3" route="/system/group">管理组列表</el-menu-item>
                            <el-menu-item index="4-4" route="/hello">权限点列表</el-menu-item>
                            <el-menu-item index="4-4" route="/hello">操作日志</el-menu-item>
                        </el-submenu>
                        <el-menu-item index="2">
                            <i class="el-icon-menu"></i>
                            <span slot="title">导航二</span>
                        </el-menu-item>
                        <el-menu-item index="3" disabled>
                            <i class="el-icon-document"></i>
                            <span slot="title">导航三</span>
                        </el-menu-item>

                    </el-menu>
                </el-aside>
                <el-container>
                    <el-main class="main-content">
                        <el-breadcrumb separator="/">
                            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                            <el-breadcrumb-item><a href="/">系统设置</a></el-breadcrumb-item>
                            <el-breadcrumb-item>管理组列表</el-breadcrumb-item>

                        </el-breadcrumb>
                        <hr style="color:#ccc;"/>
                        <router-view></router-view>
                    </el-main>
                    <el-footer class="main-footer" style="padding:15px"><strong>Copyright © 2018 <a href="http://xxx">Laravel-Admin</a>.</strong>  All rights reserved.</el-footer>
                </el-container>
            </el-container>
        </el-container>

    </div>
</template>

<script>
    export default {
        name: 'app',
        data() {
            return {
                isCollapse:false,
                asideWidth:'230px',
                logoStyle:'',
                navbarStyle:'',
            }
        },
        methods: {
            switchNav() {
                this.isCollapse = !this.isCollapse;
                if(this.isCollapse) {
                    this.asideWidth = '64px';
                    this.logoStyle = 'width:64px';
                    this.navbarStyle = 'margin-left:64px;'
                } else {
                    this.asideWidth = '230px';
                    this.logoStyle = 'width:230px';
                    this.navbarStyle = 'margin-left:230px;'
                }
            },
        }
    }
</script>

<style>

</style>
