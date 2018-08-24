<?php

use Illuminate\Database\Seeder;

class UploadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('uploads')->insert([
            [
                'id' => '1',
                'image_name' => 'wine',
                'image_url' => 'https://res.cloudinary.com/fguzman/video/upload/v1533763368/wine.webm',
                'selection' => '1',
                'orden' => '1',
                'categories_id' => '1'
            ],
            [
                'id' => '2',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/cetzv1xhjlujm2iatxlm.png',
                'selection' => '1',
                'orden' => '1',
                'categories_id' => '2'
            ],
            [
                'id' => '3',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/jami0xr1cgxvc1tvv46j.png',
                'selection' => '1',
                'orden' => '2',
                'categories_id' => '2'
            ],
            [
                'id' => '4',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/g4zjpki91ifv32brnxaz.png',
                'selection' => '1',
                'orden' => '3',
                'categories_id' => '2'
            ],
            [
                'id' => '5',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/kahc9hosvpf5qrpmeglt.png',
                'selection' => '1',
                'orden' => '4',
                'categories_id' => '2'
            ],
            [
                'id' => '6',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/jhipageq2xhwpmbhronf.png',
                'selection' => '1',
                'orden' => '1',
                'categories_id' => '3'
            ],
            [
                'id' => '7',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/tiki4o9mtfmltlxgnozw.png',
                'selection' => '1',
                'orden' => '2',
                'categories_id' => '3'
            ],
            [
                'id' => '8',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/bt0nkx1n0tyxpcsnxr8n.png',
                'selection' => '1',
                'orden' => '3',
                'categories_id' => '3'
            ],
            [
                'id' => '9',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/efw5cqdgnozsezfb2k7c.png',
                'selection' => '1',
                'orden' => '4',
                'categories_id' => '3'
            ],
            [
                'id' => '10',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/yp2crxivmchmrkgpbdkv.png',
                'selection' => '1',
                'orden' => '1',
                'categories_id' => '4'
            ],
            [
                'id' => '11',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/ybmd0joi0x1osjosxwqg.png',
                'selection' => '1',
                'orden' => '2',
                'categories_id' => '4'
            ],
            [
                'id' => '12',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/nca8y0xpest1qoxnk37v.png',
                'selection' => '1',
                'orden' => '3',
                'categories_id' => '4'
            ],
            [
                'id' => '13',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/rjgh6g61baxx6qawnvc6.png',
                'selection' => '1',
                'orden' => '4',
                'categories_id' => '4'
            ],
            [
                'id' => '14',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/ikqrgpttqwylqv72rjlw.png',
                'selection' => '1',
                'orden' => '1',
                'categories_id' => '5'
            ],
            [
                'id' => '15',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/gubr3f7ba9tzabyoz1tm.png',
                'selection' => '1',
                'orden' => '2',
                'categories_id' => '5'
            ],
            [
                'id' => '16',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/tixh268d1wgntsdj8vpb.png',
                'selection' => '1',
                'orden' => '3',
                'categories_id' => '5'
            ],
            [
                'id' => '17',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/lxjkcgxnixizx8eritnv.png',
                'selection' => '1',
                'orden' => '4',
                'categories_id' => '5'
            ],
            [
                'id' => '18',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/jfuuxfr6k7d4eupsbk9w.png',
                'selection' => '1',
                'orden' => '1',
                'categories_id' => '6'
            ],
            [
                'id' => '19',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/ra9b8df6bbjwve5zv8rg.png',
                'selection' => '1',
                'orden' => '2',
                'categories_id' => '6'
            ],
            [
                'id' => '20',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/rxleqimrxcjbvmi4byyk.png',
                'selection' => '1',
                'orden' => '3',
                'categories_id' => '6'
            ],
            [
                'id' => '21',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/vyc2wskg3boaatmegqtv.png',
                'selection' => '1',
                'orden' => '4',
                'categories_id' => '6'
            ],
            [
                'id' => '22',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/mjpi5xyqtd0hy6m7gbsf.png',
                'selection' => '1',
                'orden' => '1',
                'categories_id' => '7'
            ],
            [
                'id' => '23',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/qhrf4a9l30n3xp4ojnce.png',
                'selection' => '1',
                'orden' => '2',
                'categories_id' => '7'
            ],
            [
                'id' => '24',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/m1gqpkxxpot9srmpu573.png',
                'selection' => '1',
                'orden' => '3',
                'categories_id' => '7'
            ],
            [
                'id' => '25',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/gdwte3ai45hazxlynk8d.png',
                'selection' => '1',
                'orden' => '4',
                'categories_id' => '7'
            ],
            [
                'id' => '26',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/gxqxr62y73w6no65axna.png',
                'selection' => '1',
                'orden' => '1',
                'categories_id' => '8'
            ],
            [
                'id' => '27',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/qpllfaxzhen7z2ubgguk.png',
                'selection' => '1',
                'orden' => '2',
                'categories_id' => '8'
            ],
            [
                'id' => '28',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/gp1ilqhs4exsnmufgz5p.png',
                'selection' => '1',
                'orden' => '3',
                'categories_id' => '8'
            ],
            [
                'id' => '29',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/hvtmkfwv2ipk6tunivjv.png',
                'selection' => '1',
                'orden' => '4',
                'categories_id' => '8'
            ],
            [
                'id' => '30',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/bzvq2lvyuvfn3vsx1wcp.png',
                'selection' => '1',
                'orden' => '1',
                'categories_id' => '9'
            ],
            [
                'id' => '31',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/jwckyv4chituulbkeksg.png',
                'selection' => '1',
                'orden' => '2',
                'categories_id' => '9'
            ],
            [
                'id' => '32',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/gn6i9twdinllpgvzwhwz.png',
                'selection' => '1',
                'orden' => '3',
                'categories_id' => '9'
            ],
            [
                'id' => '33',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/j4ro7ngxwygmc6tehd0e.png',
                'selection' => '1',
                'orden' => '4',
                'categories_id' => '9'
            ],
            [
                'id' => '34',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/fahpuzblhumen4vohjsq.png',
                'selection' => '1',
                'orden' => '1',
                'categories_id' => '10'
            ],
            [
                'id' => '35',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/wwiakbyuiyhmwjeoaafz.png',
                'selection' => '1',
                'orden' => '2',
                'categories_id' => '10'
            ],
            [
                'id' => '36',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/ssampql5wzaotiljopzn.png',
                'selection' => '1',
                'orden' => '3',
                'categories_id' => '10'
            ],
            [
                'id' => '37',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/jdyxg43at3hdll0fluiy.png',
                'selection' => '1',
                'orden' => '4',
                'categories_id' => '10'
            ],
            [
                'id' => '38',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/xbk3yqnj5qfcteatqpqb.png',
                'selection' => '1',
                'orden' => '5',
                'categories_id' => '10'
            ],
            [
                'id' => '39',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/ebssqefhmbvkr14dojhl.png',
                'selection' => '1',
                'orden' => '6',
                'categories_id' => '10'
            ],
            [
                'id' => '40',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/sdyarsx2fhqxh8npccoy.png',
                'selection' => '1',
                'orden' => '7',
                'categories_id' => '10'
            ],
            [
                'id' => '41',
                'image_name' => 'logoSantana',
                'image_url' => 'https://res.cloudinary.com/fguzman/image/upload/c_fit,h_697,w_800/xf8dtiov9rjpdfadqmtm.png',
                'selection' => '1',
                'orden' => '8',
                'categories_id' => '10'
            ],
        ]);
    }
}
