<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Seeder;

class RulesSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        $metadata = [
            'author' => 'Your Name',
            'version' => '1.0',
            'license' => 'MIT',
        ];

        $attributes = [
            'title' => 'CompactToVariablesRector',
            'type' => 'free',
            'downloads' => 0,
            'rating' => 1,
            'category_id' => 1,
            'status' => 'active',
            'description' => 'change compact() call to own array',
            'metadata' => json_encode($metadata),
        ];

        Rule::query()->create($attributes);
    }
}
