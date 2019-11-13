# ScarecrowBlog

#### 介绍
ScarecrowBlog 个人技术博客

#### 软件架构
本博客采用前Laravel框架开发完成。
前端地址:http://host/
后端地址:http://host/back/index
后端初始账号:scarecrow
后端初始密码:123456789

#### 安装教程
1、下载本博客之后解压到服务器根目录。
2、在目录中运行composer install
3、指定域名到public目录下即可

在.env文件中配置邮件相关配置（默认用的QQ的SMTP协议）
MAIL_USERNAME=xxxxxxxxx@qq.com
MAIL_FROM_ADDRESS=xxxxxxxx@qq.com
MAIL_FROM_NAME=Scarecrow
MAIL_PASSWORD=xxxxxxxxx
MAIL_ENCRYPTION=SSL

此配置是配置过滤来源网站只有在此处配置了的网站请求资源才能请求到（即输入你博客的域名，也可以是多个用都好隔开）
ALL_GET_SRC_HOST_LIST=blog.scarecrow.top,www.scarecrow.top,www.blog.com

#### 使用说明
本博客目前只支持留言交互其他的不支持任何形式的交互。所以本博客是一个纯的展示类型博客，简单而大气！

#### 参与贡献
Scarecrow:https://github.com/scarecrowpqs 或 https://gitee.com/scarecrowpqs

# 再次声明
## 本博客没有任何的后门，以及不会进行维护和升级，需要其他功能请自行开发.
