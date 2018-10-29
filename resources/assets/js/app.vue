<template>
    <div>
        <el-container>
            <el-header style="height: 50px;" class="main-header">
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
                            <el-button type="text" class="sidebar-toggle" data-toggle="offcanvas" @click="switchNav">&nbsp;</el-button>
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
                            default-active="2"
                            class="el-menu-custom"
                            :collapse="isCollapse"
                            background-color="#2C3B41"
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
                        <el-menu-item index="4">
                            <i class="fa fa-gear"></i>
                            <span slot="title">系统设置</span>
                        </el-menu-item>
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
                            <el-breadcrumb-item><a href="/">活动管理</a></el-breadcrumb-item>
                            <el-breadcrumb-item>活动列表</el-breadcrumb-item>
                            <el-breadcrumb-item>活动详情</el-breadcrumb-item>
                        </el-breadcrumb>
                        <router-view></router-view>
                    </el-main>
                    <el-footer class="main-footer"><strong>Copyright © 2018 <a href="http://xxx">Laravel-Admin</a>.</strong>  All rights reserved.</el-footer>
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
    a {
        text-decoration: none;
        color: #3c8dbc;
    }

    .main-container {
        background-color: #222D32;
        position: absolute;
        top:50px;
        left:0;
        right:0;
        bottom: 0;
        overflow-y:auto;
    }
    .main-content, .main-footer {
        background-color: #fff;
    }

    .el-menu-custom .fa {
        margin-right: 5px;
        width: 24px;
        text-align: center;
        font-size: 18px;
        vertical-align: middle;
    }
    .main-header {
        padding:0;
    }
    .main-header .logo {
        background-color: #008749;
        color: #fff;
        border-bottom: 0 solid transparent;
    }

    .main-header .logo {
        -webkit-transition: width .3s ease-in-out;
        -o-transition: width .3s ease-in-out;
        transition: width .3s ease-in-out;
        display: block;
        float: left;
        height: 50px;
        font-size: 20px;
        line-height: 50px;
        text-align: center;
        width: 230px;
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        padding: 0;
        font-weight: 300;
        overflow: hidden;
        text-decoration: none;
    }

    .main-header .navbar {
        background-color: #00a65a;
    }

    .main-header .navbar {
        -webkit-transition: margin-left .3s ease-in-out;
        -o-transition: margin-left .3s ease-in-out;
        transition: margin-left .3s ease-in-out;
        margin-bottom: 0;
        margin-left: 230px;
        border: none;
        min-height: 50px;
        border-radius: 0;
        display: block;
        position: relative;
        padding:0;
        margin-top:0;

    }
    .navbar-static-top {
        z-index: 1000;
    }
    .el-aside {
         height: 100%;
     }

    .skin-blue .sidebar-form {
        border-radius: 3px;
        border: 1px solid #374850;
        margin: 10px 10px;
    }


    .input-group {
        position: relative;
        display: table;
        border-collapse: separate;
    }

    .main-header .sidebar-toggle {
        float: left;
        background-color: transparent;
        background-image: none;
        padding: 15px 15px;
        font-family: fontAwesome;
        color:#fff;
    }

    .main-header .sidebar-toggle:before {
        content: "\f0c9";
    }

    .navbar-custom-menu>.navbar-nav>li {
        position: relative;
        float:left;
    }
    .dropdown-toggle {
        color:#fff;
        position: relative;
        display: block;
        padding: 15px 15px;
        line-height: 20px;
    }


    .el-dropdown-menu .popper__arrow {
        display: none;
    }
    .dropdown-menu {
        padding:0;
        margin-top:0;
    }
    .dropdown-menu[x-placement^=bottom] {
        margin-top:0;
    }

    .navbar .user-image {
        float: left;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        margin-right: 10px;
        margin-top: -2px;
    }
    .main-footer {
        background: #fff;
        padding: 15px;
        color: #444;
        border-top: 1px solid #d2d6de;
        font-size: 14px;
    }

    .user-header {
        height: 175px;
        padding: 10px;
        text-align: center;
    }

    .main-header .el-dropdown:hover {
        background-color: #009551;
    }

    .user-header>img {
        z-index: 5;
        height: 90px;
        width: 90px;
        border: 3px solid;
        border-color: transparent;
        border-color: rgba(255,255,255,0.2);
        border-radius: 50%;
        vertical-align: middle;
    }

    .user-header>p {
        z-index: 5;
        font-size: 15px;
        margin-top: 10px;
        line-height: 24px;
    }

    .dropdown-menu {
        margin-right: 5px;
    }


</style>
