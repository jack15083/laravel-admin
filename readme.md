## Laravel-Admin 简介

Laravel-Admin 是用 laravel + elementUi前端框架前后端分离写成的后台脚手架，自带用户组权限系统。

## 安装

- composer install  
- 配置nginx 本地域名local.admin.com(如需更换域名，需要在webpack.mix.js更换配置域名) 指向/public目录 
- npm install
- 导入/laravel-admin.sql 数据库
- 将.env.example 重命名为.env后修改数据库配置文件
- npm run dev


## 使用

默认两个后台管理测试账号 god/123456 , test/123456

npm run watch 可在开发时运行，实时兼控前端文件修改
npm run prod 生产环境打包

## 注意

设置新的权限后需要重新登录才会生效。

本项目未经严格测试，可能存在bug，仅供参考学习。

如果感觉此项目帮助了您，请给颗星支持一下。


## 预览

![QQ截图20190104154750.png](https://upload-images.jianshu.io/upload_images/5993750-efa7105bce3ea3f1.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![QQ截图20190104154810.png](https://upload-images.jianshu.io/upload_images/5993750-095b4f98baf3d11b.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![local.admin.com_ (1).png](https://upload-images.jianshu.io/upload_images/5993750-a7d8e236d40f9aae.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![local.admin.com_ (2).png](https://upload-images.jianshu.io/upload_images/5993750-828a05bbed3e6147.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![local.admin.com_ (3).png](https://upload-images.jianshu.io/upload_images/5993750-2a0cf73c76182630.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![local.admin.com_ (4).png](https://upload-images.jianshu.io/upload_images/5993750-e9f82bf6dd4a91d6.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![local.admin.com_ (5).png](https://upload-images.jianshu.io/upload_images/5993750-eb09998fe5f3b241.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![local.admin.com_.png](https://upload-images.jianshu.io/upload_images/5993750-d6842511602b283e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

## License

This framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
