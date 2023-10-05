<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouleursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $couleurs = [
            [
                'nom' => 'argent',
                'type' => 'M',
                'hexadecimal' => '#EFEFEF'
            ],
            [
                'nom' => 'or',
                'type' => 'M',
                'hexadecimal' => '#FCEF3C'
            ],
            [
                'nom' => 'azur',
                'type' => 'E',
                'hexadecimal' => '#0F47AF'
            ],
            [
                'nom' => 'gueules',
                'type' => 'E',
                'hexadecimal' => '#DA121A'
            ],
            [
                'nom' => 'sable',
                'type' => 'E',
                'hexadecimal' => '#020202'
            ],
            
            [
                'nom' => 'sinople',
                'type' => 'E',
                'hexadecimal' => '#078930'
            ],
            [
                'nom' => 'carnation',
                'type' => 'E',
                'hexadecimal' => '#F2A772'
            ],
            [
                'nom' => 'pourpre',
                'type' => 'E',
                'hexadecimal' => '#9116A1'
            ],
            [
                'nom' => 'celeste',
                'type' => 'E',
                'hexadecimal' => '#89c5E3'
            ],
            [
                'nom' => 'cendré',
                'type' => 'E',
                'hexadecimal' => '#999999'
            ],
            [
                'nom' => 'tanné',
                'type' => 'E',
                'hexadecimal' => '#9d5333'
            ],
            [
                'nom' => 'sanguine',
                'type' => 'E',
                'hexadecimal' => '#a41619'
            ],
            [
                'nom' => 'mûre',
                'type' => 'E',
                'hexadecimal' => '#570b63'
            ],
        ];
        DB::table('couleurs')->insert($couleurs);
    }
}
