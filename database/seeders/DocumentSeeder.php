<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Document seeder for creating sample documents
 * Creates various types of statistical documents and reports
 */
class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users to assign as uploaders
        $admin = User::where('email', 'admin@insbu.bi')->first();
        $marie = User::where('email', 'marie.uwimana@insbu.bi')->first();
        $pierre = User::where('email', 'pierre.nkurunziza@insbu.bi')->first();
        $aline = User::where('email', 'aline.bukuru@insbu.bi')->first();
        $emmanuel = User::where('email', 'emmanuel.habimana@insbu.bi')->first();
        $claude = User::where('email', 'claude.bizimana@insbu.bi')->first();

        // Create sample documents
        Document::create([
            'title' => 'Quarterly Economic Analysis Q4 2023',
            'description' => 'Comprehensive economic analysis for the fourth quarter of 2023, including GDP growth, inflation rates, employment statistics, and sector performance indicators.',
            'file_name' => 'economic-analysis-q4-2023.pdf',
            'original_name' => 'Economic Analysis Q4 2023.pdf',
            'file_path' => 'documents/economic-analysis-q4-2023.pdf',
            'file_size' => 2458752, // 2.4MB
            'file_type' => 'application/pdf',
            'category' => 'Economic Reports',
            'uploaded_by' => $admin->id,
            'download_count' => 324,
            'is_public' => true,
            'created_at' => now()->subDays(5),
        ]);

        Document::create([
            'title' => 'Population Census Data 2023',
            'description' => 'Complete dataset from the national population census conducted in 2023, including demographic breakdowns by region, age groups, and socioeconomic indicators.',
            'file_name' => 'population-census-2023.xlsx',
            'original_name' => 'Population Census 2023 - Complete Dataset.xlsx',
            'file_path' => 'documents/population-census-2023.xlsx',
            'file_size' => 5242880, // 5MB
            'file_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'category' => 'Census Data',
            'uploaded_by' => $marie->id,
            'download_count' => 189,
            'is_public' => true,
            'created_at' => now()->subDays(10),
        ]);

        Document::create([
            'title' => 'Agricultural Statistics 2023',
            'description' => 'Annual agricultural statistics including crop yields, livestock data, agricultural productivity metrics, and export performance analysis.',
            'file_name' => 'agricultural-stats-2023.pdf',
            'original_name' => 'Agricultural Statistics Report 2023.pdf',
            'file_path' => 'documents/agricultural-stats-2023.pdf',
            'file_size' => 3145728, // 3MB
            'file_type' => 'application/pdf',
            'category' => 'Agriculture',
            'uploaded_by' => $pierre->id,
            'download_count' => 156,
            'is_public' => true,
            'created_at' => now()->subDays(15),
        ]);

        Document::create([
            'title' => 'Healthcare System Performance Report',
            'description' => 'Comprehensive report on healthcare system performance, including patient outcomes, resource utilization, infrastructure analysis, and health indicators.',
            'file_name' => 'healthcare-performance-2023.docx',
            'original_name' => 'Healthcare System Performance Report 2023.docx',
            'file_path' => 'documents/healthcare-performance-2023.docx',
            'file_size' => 1572864, // 1.5MB
            'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'category' => 'Healthcare',
            'uploaded_by' => $aline->id,
            'download_count' => 89,
            'is_public' => true,
            'created_at' => now()->subDays(20),
        ]);

        Document::create([
            'title' => 'Education Statistics Dashboard Data',
            'description' => 'Interactive dashboard data for education statistics including enrollment rates, graduation rates, literacy metrics, and school infrastructure data.',
            'file_name' => 'education-dashboard-data.csv',
            'original_name' => 'Education Dashboard Data 2023.csv',
            'file_path' => 'documents/education-dashboard-data.csv',
            'file_size' => 524288, // 512KB
            'file_type' => 'text/csv',
            'category' => 'Education',
            'uploaded_by' => $marie->id,
            'download_count' => 67,
            'is_public' => true,
            'created_at' => now()->subDays(28),
        ]);

        Document::create([
            'title' => 'Infrastructure Development Maps',
            'description' => 'Geographic visualization of infrastructure development projects including roads, utilities, telecommunications, and public facilities mapping.',
            'file_name' => 'infrastructure-maps-2023.png',
            'original_name' => 'Infrastructure Development Maps 2023.png',
            'file_path' => 'documents/infrastructure-maps-2023.png',
            'file_size' => 4194304, // 4MB
            'file_type' => 'image/png',
            'category' => 'Infrastructure',
            'uploaded_by' => $emmanuel->id,
            'download_count' => 134,
            'is_public' => true,
            'created_at' => now()->subDays(25),
        ]);

        Document::create([
            'title' => 'Trade Statistics Annual Report 2023',
            'description' => 'Comprehensive analysis of trade performance including import/export data, trade balance, key trading partners, and commodity analysis.',
            'file_name' => 'trade-statistics-2023.pdf',
            'original_name' => 'Trade Statistics Annual Report 2023.pdf',
            'file_path' => 'documents/trade-statistics-2023.pdf',
            'file_size' => 2097152, // 2MB
            'file_type' => 'application/pdf',
            'category' => 'Trade',
            'uploaded_by' => $claude->id,
            'download_count' => 98,
            'is_public' => true,
            'created_at' => now()->subDays(32),
        ]);

        Document::create([
            'title' => 'Labor Force Survey Results 2023',
            'description' => 'Detailed results from the national labor force survey including employment rates, unemployment statistics, wage analysis, and sector employment distribution.',
            'file_name' => 'labor-force-survey-2023.xlsx',
            'original_name' => 'Labor Force Survey Results 2023.xlsx',
            'file_path' => 'documents/labor-force-survey-2023.xlsx',
            'file_size' => 3670016, // 3.5MB
            'file_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'category' => 'Employment',
            'uploaded_by' => $admin->id,
            'download_count' => 178,
            'is_public' => true,
            'created_at' => now()->subDays(40),
        ]);

        Document::create([
            'title' => 'Gender Statistics Compendium 2023',
            'description' => 'Comprehensive collection of gender-disaggregated statistics covering education, health, economic participation, and social indicators.',
            'file_name' => 'gender-statistics-2023.pdf',
            'original_name' => 'Gender Statistics Compendium 2023.pdf',
            'file_path' => 'documents/gender-statistics-2023.pdf',
            'file_size' => 2621440, // 2.5MB
            'file_type' => 'application/pdf',
            'category' => 'Social Statistics',
            'uploaded_by' => $marie->id,
            'download_count' => 112,
            'is_public' => true,
            'created_at' => now()->subDays(35),
        ]);

        Document::create([
            'title' => 'Statistical Methodology Guidelines',
            'description' => 'Official guidelines for statistical data collection, processing, and analysis methodologies used by INSBU and partner organizations.',
            'file_name' => 'methodology-guidelines.pdf',
            'original_name' => 'Statistical Methodology Guidelines 2023.pdf',
            'file_path' => 'documents/methodology-guidelines.pdf',
            'file_size' => 1048576, // 1MB
            'file_type' => 'application/pdf',
            'category' => 'Methodology',
            'uploaded_by' => $admin->id,
            'download_count' => 245,
            'is_public' => true,
            'created_at' => now()->subDays(50),
        ]);

        // Create some private documents (admin/editor only)
        Document::create([
            'title' => 'Internal Survey Protocol 2024',
            'description' => 'Internal protocol for conducting household surveys and data collection procedures. For staff use only.',
            'file_name' => 'internal-survey-protocol-2024.docx',
            'original_name' => 'Internal Survey Protocol 2024.docx',
            'file_path' => 'documents/internal-survey-protocol-2024.docx',
            'file_size' => 786432, // 768KB
            'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'category' => 'Internal',
            'uploaded_by' => $admin->id,
            'download_count' => 23,
            'is_public' => false,
            'created_at' => now()->subDays(7),
        ]);

        Document::create([
            'title' => 'Budget Allocation Analysis Q1 2024',
            'description' => 'Confidential analysis of budget allocation and expenditure patterns for internal planning purposes.',
            'file_name' => 'budget-analysis-q1-2024.xlsx',
            'original_name' => 'Budget Allocation Analysis Q1 2024.xlsx',
            'file_path' => 'documents/budget-analysis-q1-2024.xlsx',
            'file_size' => 1310720, // 1.25MB
            'file_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'category' => 'Internal',
            'uploaded_by' => $admin->id,
            'download_count' => 12,
            'is_public' => false,
            'created_at' => now()->subDays(3),
        ]);

        // Add more documents with varied dates for better monthly statistics
        Document::create([
            'title' => 'Tourism Sector Analysis 2023',
            'description' => 'Comprehensive analysis of tourism sector performance including visitor statistics, revenue analysis, and infrastructure development.',
            'file_name' => 'tourism-analysis-2023.pdf',
            'original_name' => 'Tourism Sector Analysis 2023.pdf',
            'file_path' => 'documents/tourism-analysis-2023.pdf',
            'file_size' => 2883584, // 2.75MB
            'file_type' => 'application/pdf',
            'category' => 'Tourism',
            'uploaded_by' => $marie->id,
            'download_count' => 87,
            'is_public' => true,
            'created_at' => now()->subMonths(1)->subDays(8),
        ]);

        Document::create([
            'title' => 'Energy Sector Statistical Report 2023',
            'description' => 'Statistical overview of energy production, consumption, distribution, and renewable energy initiatives across Burundi.',
            'file_name' => 'energy-stats-2023.xlsx',
            'original_name' => 'Energy Sector Statistical Report 2023.xlsx',
            'file_path' => 'documents/energy-stats-2023.xlsx',
            'file_size' => 1966080, // 1.875MB
            'file_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'category' => 'Energy',
            'uploaded_by' => $pierre->id,
            'download_count' => 126,
            'is_public' => true,
            'created_at' => now()->subMonths(2)->subDays(12),
        ]);

        Document::create([
            'title' => 'Financial Services Market Analysis',
            'description' => 'Market analysis of financial services sector including banking, insurance, microfinance, and mobile money services.',
            'file_name' => 'financial-services-analysis.docx',
            'original_name' => 'Financial Services Market Analysis 2023.docx',
            'file_path' => 'documents/financial-services-analysis.docx',
            'file_size' => 2097152, // 2MB
            'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'category' => 'Finance',
            'uploaded_by' => $claude->id,
            'download_count' => 143,
            'is_public' => true,
            'created_at' => now()->subMonths(3)->subDays(5),
        ]);

        Document::create([
            'title' => 'Manufacturing Industry Survey Results',
            'description' => 'Survey results from manufacturing enterprises covering production capacity, employment, technology adoption, and market challenges.',
            'file_name' => 'manufacturing-survey-2023.csv',
            'original_name' => 'Manufacturing Industry Survey Results 2023.csv',
            'file_path' => 'documents/manufacturing-survey-2023.csv',
            'file_size' => 1048576, // 1MB
            'file_type' => 'text/csv',
            'category' => 'Manufacturing',
            'uploaded_by' => $aline->id,
            'download_count' => 92,
            'is_public' => true,
            'created_at' => now()->subMonths(4)->subDays(3),
        ]);

        // Recent documents for current month
        Document::create([
            'title' => 'Digital Government Services Report 2024',
            'description' => 'Comprehensive report on digital transformation in public services, citizen adoption rates, and service delivery improvements.',
            'file_name' => 'digital-government-2024.pdf',
            'original_name' => 'Digital Government Services Report 2024.pdf',
            'file_path' => 'documents/digital-government-2024.pdf',
            'file_size' => 3145728, // 3MB
            'file_type' => 'application/pdf',
            'category' => 'Technology',
            'uploaded_by' => $marie->id,
            'download_count' => 45,
            'is_public' => true,
            'created_at' => now()->subDays(5),
        ]);

        Document::create([
            'title' => 'SME Development Statistics Q1 2024',
            'description' => 'Small and Medium Enterprise development statistics including business registration, employment generation, and access to finance.',
            'file_name' => 'sme-stats-q1-2024.xlsx',
            'original_name' => 'SME Development Statistics Q1 2024.xlsx',
            'file_path' => 'documents/sme-stats-q1-2024.xlsx',
            'file_size' => 2359296, // 2.25MB
            'file_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'category' => 'Business',
            'uploaded_by' => $admin->id,
            'download_count' => 28,
            'is_public' => true,
            'created_at' => now()->subDays(2),
        ]);

        Document::create([
            'title' => 'Water and Sanitation Access Study',
            'description' => 'National study on water and sanitation access, coverage statistics, and infrastructure development needs.',
            'file_name' => 'water-sanitation-study.pdf',
            'original_name' => 'Water and Sanitation Access Study 2024.pdf',
            'file_path' => 'documents/water-sanitation-study.pdf',
            'file_size' => 4194304, // 4MB
            'file_type' => 'application/pdf',
            'category' => 'Infrastructure',
            'uploaded_by' => $emmanuel->id,
            'download_count' => 67,
            'is_public' => true,
            'created_at' => now()->subDays(8),
        ]);

        Document::create([
            'title' => 'Regional Development Indicators Map',
            'description' => 'Interactive map showing regional development indicators including economic activity, infrastructure, and social services.',
            'file_name' => 'regional-development-map.png',
            'original_name' => 'Regional Development Indicators Map 2024.png',
            'file_path' => 'documents/regional-development-map.png',
            'file_size' => 5242880, // 5MB
            'file_type' => 'image/png',
            'category' => 'Regional Development',
            'uploaded_by' => $pierre->id,
            'download_count' => 156,
            'is_public' => true,
            'created_at' => now()->subDays(12),
        ]);
    }
}
