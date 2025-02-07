<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class navbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('navbars')->insert([
        //     [
        //         'id' => 1,
        //         'logo_path' => 'images/logo.png',
        //         'title' => 'Cambodian Journal of Multidisciplinary Research and Innovation (CJMRI)',
        //         'background_color' => 'images/navbar-bg.jpg',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        // ]);
        DB::table('announcements')->insert([
            [
                'id' => 1,
                'content' => 'he Cambodian Journal of Educational Research (CJER), a quality peer-reviewed journal                                     published by the Cambodian Education Forum (CEF), is preparing for its upcoming                                     issues, Volume 5, Issue1 and Issue2, to be published in June and December 2025,                                     respectively.                                      If you are interested in publishing in our peer-reviewed academic journal, please                                     submit your manuscript.',
                'published_at' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
