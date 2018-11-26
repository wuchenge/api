/*
* @Author: wuchenge
* @Date:   2018-11-26 16:05:00
* @Last Modified by:   wuchenge
* @Last Modified time: 2018-11-26 16:05:19
*/

create database if not exists api charset utf8mb4 collate utf8mb4_general_ci;

mysqldump -uroot -p -t api admin_menu admin_permissions admin_role_menu admin_role_permissions admin_role_users admin_roles admin_user_permissions admin_users errors > database/admin.sql

mysql -uroot -p api < database/admin.sql

/*清空表*/
truncate admin_menu;
truncate admin_menu;
truncate admin_permissions;
truncate admin_role_menu;
truncate admin_role_permissions;
truncate admin_role_users;
truncate admin_roles;
truncate admin_user_permissions;
truncate admin_users;
truncate errors;
