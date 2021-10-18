
## 项目概述

+ 项目名称：iliweii API
+ 官方地址：https://api.redcountry.top/

## 运行环境

+ Nginx 1.8+ / Apache 2.4+
+ PHP 7.0+
+ Mysql 5.7+

## 开发环境部署/安装

本项目代码使用 PHP 框架 [Laravel 5.4](https://learnku.com/docs/laravel/5.4) 开发，依赖于[Composer](https://getcomposer.org/)

如果未安装Composer请先安装Composer

**1.克隆代码**

```bash
$ git clone git@github.com:iliweii/api.git
```

**2.安装/更新扩展包依赖**

```bash
$ composer config repo.packagist composer https://mirrors.aliyun.com/composer/
$ composer install
$ composer update
```

**3.生成配置文件**

```bash
$ cp .env.example .env
```

**4.生成密钥**

```bash
$ php artisan key:generate
```

```bash
$ php artisan jwt:secret
```

