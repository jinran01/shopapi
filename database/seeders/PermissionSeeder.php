<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //清空缓存
        app()['cache']->forget('spatie.permission.cache');

        //添加权限
        $permissions = [
            //有关用户权限
            ['name' => 'users.index','cn_name' => '用户列表','guard_name' => 'api'],
            ['name' => 'users.show','cn_name' => '用户详情','guard_name' => 'api'],
            ['name' => 'users.lock','cn_name' => '用户禁用启用','guard_name' => 'api'],
            //有关分类权限
            ['name' => 'category.status','cn_name' => '分类禁用启用','guard_name' => 'api'],
            ['name' => 'category.index','cn_name' => '分类列表','guard_name' => 'api'],
            ['name' => 'category.store','cn_name' => '添加分类','guard_name' => 'api'],
            ['name' => 'category.show','cn_name' => '分类详情','guard_name' => 'api'],
            ['name' => 'category.update','cn_name' => '更新分类','guard_name' => 'api'],
            //有关商品权限
            ['name' => 'goods.on','cn_name' => '商品禁用启用','guard_name' => 'api'],
            ['name' => 'goods.recommend','cn_name' => '商品推荐','guard_name' => 'api'],
            ['name' => 'goods.index','cn_name' => '商品列表','guard_name' => 'api'],
            ['name' => 'goods.store','cn_name' => '添加商品','guard_name' => 'api'],
            ['name' => 'goods.show','cn_name' => '商品详情','guard_name' => 'api'],
            ['name' => 'goods.update','cn_name' => '更新商品','guard_name' => 'api'],
            //有关评论权限
            ['name' => 'comments.index','cn_name' => '评论列表','guard_name' => 'api'],
            ['name' => 'comments.show','cn_name' => '评论详情','guard_name' => 'api'],
            ['name' => 'comments.reply','cn_name' => '评论回复','guard_name' => 'api'],
            //有关订单权限
            ['name' => 'orders.index','cn_name' => '订单列表','guard_name' => 'api'],
            ['name' => 'orders.show','cn_name' => '订单详情','guard_name' => 'api'],
            ['name' => 'orders.post','cn_name' => '订单发货','guard_name' => 'api'],
            //有关轮播图权限
            ['name' => 'slides.index','cn_name' => '轮播图列表','guard_name' => 'api'],
            ['name' => 'slides.show','cn_name' => '轮播图详情','guard_name' => 'api'],
            ['name' => 'slides.store','cn_name' => '轮播图添加','guard_name' => 'api'],
            ['name' => 'slides.update','cn_name' => '轮播图更新','guard_name' => 'api'],
            ['name' => 'slides.destroy','cn_name' => '轮播图删除','guard_name' => 'api'],
            ['name' => 'slides.seq','cn_name' => '轮播图排序','guard_name' => 'api'],
            //有关菜单权限
            ['name' => 'menus','cn_name' => '菜单列表','guard_name' => 'api'],

        ];
        foreach ($permissions as $p){
            Permission::create($p);
        }
        //添加角色
        $role = Role::create([
            'name' => 'super_admin',
            'cn_name' => '超级管理员',
            'guard_name' => 'api',
        ]);

        //为角色添加权限
        $role ->givePermissionTo(Permission::all());
    }
}
