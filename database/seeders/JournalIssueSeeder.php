<?php

namespace Database\Seeders;

use App\Models\JournalIssue;
use Illuminate\Database\Seeder;

class JournalIssueSeeder extends Seeder
{
    public function run()
    {
        JournalIssue::create([
            'journal_name' => 'Cambodian Journal of Multidisciplinary Research and Innovation',
            'current_volume' => 1,
            'current_issue' => 1,
            'issues' => [1, 2],
            'description' => 'A multidisciplinary research journal'
        ]);
    }
}
