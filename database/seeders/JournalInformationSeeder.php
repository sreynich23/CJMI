<?php

namespace Database\Seeders;

use App\Models\JournalInformation;
use Illuminate\Database\Seeder;

class JournalInformationSeeder extends Seeder
{
    public function run()
    {
        JournalInformation::create([
            'journal_name' => 'Cambodian Journal of Multidisciplinary Research and Innovation',
            'telegram' => '+855 312228888',
            'email' => 'cjmri.journal@gmail.com',
            'editorial_office' => 'Battambang, Cambodia',
            'license_text' => 'This work is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.',
            'developer' => 'LONG SREYNICH',
            'publisher' => 'Cambodian Education Forum'
        ]);
    }
}
