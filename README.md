# About ssl
- ssl是一个登录用模块，采用restful api设计思路。
- 配置文件
  - 本仓库应用使用 MySQL8.0, .env 文件里的数据库连接设置之类，请自行生成。
- 数据库创建
  - 直接运行 php artisan migration，框架自带迁移文件已删除。
- vendor 第三方包
  - 启动服务之前请自行运行 composer update | composer install 更新或安装必要第三方包。
# Important
- 本仓库站点需要一个单独的ip来启动服务，例如，如果使用本地开发模式，其他站点使用了 127.0.0.1 启动服务之后，本服务请使用 127.0.0.2 或者其他ip来启动。