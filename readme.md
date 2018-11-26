## about api demo

### requirements

* laravel >= 5.7
* php >= 7.1.3
* OpenSSL PHP 扩展
* PDO PHP 扩展
* Mbstring PHP 扩展
* Tokenizer PHP 扩展
* XML PHP 扩展
* Ctype PHP 扩展
* JSON PHP 扩展
* Redis PHP 扩展


## 生成api文档
```
apidoc -i app/Http/Controllers/Api -o public/apidoc
```

## Install

* 
```
git clone https://github.com/wuchenge/api.git

cd api

cp .env.example .env

php artisan key:generate
```

* 配置数据库，七牛，有道翻译, 阿里云等信息
* 创建数据库
```
create database if not exists fund charset utf8mb4 collate utf8mb4_general_ci;
```
* 导入后台数据
```
mysql -uroot -p fund < database/admin.sql
```
