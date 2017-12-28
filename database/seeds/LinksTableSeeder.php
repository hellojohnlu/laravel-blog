<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => '牛牛学院',
                'link_title' => '做最好的IT教育',
                'link_url' => 'http://www.newnewedu.com',
                'link_order' => 1
            ],
            [
                'link_name' => '牛牛学院论坛',
                'link_title' => '学IT，来牛牛学院',
                'link_url' => 'http://bbs.newnewedu.com',
                'link_order' => 2
            ],
            [
                'link_name' => '青蓝学院',
                'link_title' => '做最酷的艺术设计教育',
                'link_url' => 'http://www.blueedu.com',
                'link_order' => 3
            ],
            [
                'link_name' => '青蓝学院论坛',
                'link_title' => '学设计，来青蓝学院',
                'link_url' => 'http://bbs.blueedu.com',
                'link_order' => 4
            ]
        ];
        DB::table('links')->insert($data);
    }
}
