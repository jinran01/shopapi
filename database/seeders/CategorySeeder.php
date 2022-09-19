<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 填充分类信息
        $categories = [
            [
                'name' => '电子数码',
                'group' => 'goods',
                'pid' => 0,
                'level' => 1,
                'children' => [
                    [
                        'name' => '手机',
                        'group' => 'goods',
                        'level' => 2,
                        'children' => [
                            [
                                'name' => '华为',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                            [
                                'name' => '小米',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                        ]
                    ],
                    [
                        'name' => '电脑',
                        'group' => 'goods',
                        'level' => 2,
                        'children' => [
                            [
                                'name' => '联想',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                            [
                                'name' => '戴尔',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                        ]
                    ],
                ]
            ],
            [
                'name' => '服装衣帽',
                'group' => 'goods',
                'pid' => 0,
                'level' => 1,
                'children' => [
                    [
                        'name' => '男装',
                        'group' => 'goods',
                        'level' => 2,
                        'children' => [
                            [
                                'name' => '海澜之家',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                            [
                                'name' => 'Nike',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                        ]
                    ],
                    [
                        'name' => '女装',
                        'group' => 'goods',
                        'level' => 2,
                        'children' => [
                            [
                                'name' => '欧时力',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                            [
                                'name' => 'Only',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                        ]
                    ],
                ]
            ],
        ];

        // 写入到数据库
        foreach ($categories as $l1) {
            $l1_tmp = $l1;
            unset($l1_tmp['children']);
            $l1_model = Category::create($l1_tmp);
            foreach ($l1['children'] as $l2) {
                $l2_tmp = $l2;
                unset($l2_tmp['children']);
                $l2_tmp['pid'] = $l1_model->id;
                $l2_model = Category::create($l2_tmp);
                $l2_model->children()->createMany($l2['children']);
            }
        }

        // 清除分类缓存
        forget_cache_category();
    }
}
