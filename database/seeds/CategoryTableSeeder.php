<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([

            [
              'title' => 'Video',
              'slug' =>  'video'
            ],
            [
                'title' => 'Alquiler de Sillas',
                'slug' =>  'alquiler-de-sillas'
            ],
            [
                'title' => 'Organizacion de Eventos',
                'slug' =>  'organizacion-de-eventos'
            ],
            [
                'title' => 'Alquiler de Mesas',
                'slug' =>  'alquiler-de-mesas'
            ],
            [
                'title' => 'Decoracion',
                'slug' =>  'decoracion'
            ],
            [
                'title' => 'Organizacion de Cumpleaños',
                'slug' =>  'organizacion-de-cumpleaños'
            ],
            [
                'title' => 'Organizacion de Quinceaños',
                'slug' =>  'organizacion-de-quinceaños'
            ],
            [
                'title' => 'Buffet',
                'slug' =>  'buffet'
            ],
            [
                'title' => 'Alquiler de Utensilios',
                'slug' =>  'alquiler-de-utensilios'
            ],
            [
                'title' => 'Presentador Deslizable',
                'slug' =>  'presentador-deslizable'
            ],

            ]);
    }
}
