[![996.icu](https://img.shields.io/badge/link-996.icu-red.svg)](https://996.icu)
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

## 预览

![QQ截图20190104154750.png](https://upload-images.jianshu.io/upload_images/5993750-efa7105bce3ea3f1.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![QQ截图20190104154810.png](https://upload-images.jianshu.io/upload_images/5993750-095b4f98baf3d11b.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![QQ截图20190104155016.png](https://upload-images.jianshu.io/upload_images/5993750-9a5d47e2d84bb313.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![QQ截图20190104155059.png](https://upload-images.jianshu.io/upload_images/5993750-0b96487364dbf9b6.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![QQ截图20190104155120.png](https://upload-images.jianshu.io/upload_images/5993750-247128ce5cbac950.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![QQ截图20190104155131.png](https://upload-images.jianshu.io/upload_images/5993750-2174a73a34d9369e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![QQ截图20190104155147.png](https://upload-images.jianshu.io/upload_images/5993750-c283087e7b373240.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![QQ截图20190104155155.png](https://upload-images.jianshu.io/upload_images/5993750-b279a7962aa2189e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![QQ截图20190104155205.png](https://upload-images.jianshu.io/upload_images/5993750-8f3c23466cb2bc91.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


## License

This framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT), [反996license](https://github.com/996icu/996.ICU/blob/master/LICENSE_CN).
