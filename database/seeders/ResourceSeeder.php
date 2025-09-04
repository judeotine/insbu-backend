<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

/**
 * Resource seeder for creating sample resources and useful links
 */
class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            [
                'title' => 'INSBU Official Website',
                'description' => 'Official website of Institut National de Santé Publique du Burundi',
                'url' => 'https://insbu.bi',
                'category' => 'official',
                'sort_order' => 1,
            ],
            [
                'title' => 'WHO Health Guidelines',
                'description' => 'World Health Organization guidelines and resources',
                'url' => 'https://www.who.int/publications/guidelines',
                'category' => 'health',
                'sort_order' => 2,
            ],
            [
                'title' => 'Ministry of Health Burundi',
                'description' => 'Official Ministry of Health website and resources',
                'url' => 'https://minisante.bi',
                'category' => 'government',
                'sort_order' => 3,
            ],
            [
                'title' => 'Public Health Research Database',
                'description' => 'Access to public health research papers and studies',
                'url' => 'https://pubmed.ncbi.nlm.nih.gov',
                'category' => 'research',
                'sort_order' => 4,
            ],
            [
                'title' => 'Health Data Analytics Tools',
                'description' => 'Statistical tools for health data analysis',
                'url' => 'https://www.r-project.org',
                'category' => 'tools',
                'sort_order' => 5,
            ],
            [
                'title' => 'Epidemiological Surveillance Guidelines',
                'description' => 'Guidelines for disease surveillance and reporting',
                'url' => 'https://www.cdc.gov/surveillance',
                'category' => 'guidelines',
                'sort_order' => 6,
            ],
            [
                'title' => 'Global Health Observatory',
                'description' => 'WHO Global Health Observatory data repository',
                'url' => 'https://www.who.int/data/gho',
                'category' => 'data',
                'sort_order' => 7,
            ],
            [
                'title' => 'Health Information Systems',
                'description' => 'Resources for health information management',
                'url' => 'https://www.healthdatacollaborative.org',
                'category' => 'systems',
                'sort_order' => 8,
            ],
            [
                'title' => 'Burundi Health Statistics Portal',
                'description' => 'National health statistics and indicators',
                'url' => 'https://statistics.insbu.bi',
                'category' => 'statistics',
                'sort_order' => 9,
            ],
            [
                'title' => 'Emergency Response Protocols',
                'description' => 'Health emergency response guidelines and protocols',
                'url' => 'https://www.who.int/emergencies',
                'category' => 'emergency',
                'sort_order' => 10,
            ]
        ];

        foreach ($resources as $resource) {
            Resource::create($resource);
        }
    }
}
