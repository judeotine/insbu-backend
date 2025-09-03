<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * News seeder for creating sample news articles
 * Creates various types of statistical reports and announcements
 */
class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users to assign as authors
        $admin = User::where('email', 'admin@insbu.bi')->first();
        $marie = User::where('email', 'marie.uwimana@insbu.bi')->first();
        $pierre = User::where('email', 'pierre.nkurunziza@insbu.bi')->first();
        $claude = User::where('email', 'claude.bizimana@insbu.bi')->first();

        // Create sample news articles
        News::create([
            'title' => 'Quarterly Economic Report Q4 2023 Released',
            'body' => '<h2>Executive Summary</h2>
                      <p>The Institute of National Statistics of Burundi (INSBU) is pleased to announce the release of our comprehensive Quarterly Economic Report for Q4 2023. This report provides detailed analysis of key economic indicators and trends that shaped Burundi\'s economy during the final quarter of 2023.</p>
                      
                      <h3>Key Highlights</h3>
                      <ul>
                        <li>GDP growth reached 3.2% year-over-year, exceeding projections</li>
                        <li>Inflation rate stabilized at 4.1%, within the central bank\'s target range</li>
                        <li>Employment rate improved to 68.5%, up from 66.2% in Q3</li>
                        <li>Agricultural sector showed strong performance with 15% growth</li>
                        <li>Manufacturing sector expanded by 8.3%</li>
                      </ul>
                      
                      <h3>Detailed Analysis</h3>
                      <p>The fourth quarter of 2023 demonstrated remarkable resilience in Burundi\'s economy, with several sectors showing robust growth. The agricultural sector, which remains the backbone of our economy, benefited from favorable weather conditions and improved farming techniques.</p>
                      
                      <p>The manufacturing sector also showed significant improvement, driven by increased domestic demand and expanded export opportunities. Small and medium enterprises (SMEs) contributed substantially to this growth, highlighting the importance of supporting local businesses.</p>
                      
                      <h3>Looking Forward</h3>
                      <p>Based on current trends and policy initiatives, INSBU projects continued positive growth momentum into 2024. Key factors supporting this outlook include ongoing infrastructure investments, improved business environment, and strengthened regional trade partnerships.</p>',
            'excerpt' => 'INSBU releases comprehensive Q4 2023 economic report showing 3.2% GDP growth and improved employment rates across key sectors.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=800',
            'category' => 'Economic Reports',
            'author_id' => $admin->id,
            'published_at' => now()->subDays(3),
            'created_at' => now()->subDays(5),
        ]);

        News::create([
            'title' => 'Population Census 2023: Preliminary Results Available',
            'body' => '<h2>Census Overview</h2>
                      <p>The Institute of National Statistics of Burundi has completed the data collection phase of the 2023 National Population and Housing Census. Preliminary results are now available, providing crucial insights into Burundi\'s demographic landscape.</p>
                      
                      <h3>Key Findings</h3>
                      <ul>
                        <li>Total population estimated at 12.8 million, up from 10.9 million in 2018</li>
                        <li>Average annual growth rate of 3.2%</li>
                        <li>Urban population now represents 14.2% of total population</li>
                        <li>Median age increased to 19.5 years</li>
                        <li>Literacy rate improved to 73.1%</li>
                      </ul>
                      
                      <h3>Regional Distribution</h3>
                      <p>The census reveals significant regional variations in population distribution and growth patterns. Bujumbura Mairie continues to be the most densely populated area, while rural provinces show varying growth rates reflecting migration patterns and economic opportunities.</p>
                      
                      <h3>Data Quality and Methodology</h3>
                      <p>The 2023 census employed modern data collection techniques, including digital enumeration and GPS mapping. Quality assurance measures were implemented throughout the process to ensure data accuracy and completeness.</p>
                      
                      <h3>Next Steps</h3>
                      <p>Detailed analysis and final results will be published in the coming months. The data will inform policy decisions and development planning at national and local levels.</p>',
            'excerpt' => 'Preliminary results from the 2023 National Population Census show Burundi\'s population has reached 12.8 million with improved literacy rates.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800',
            'category' => 'Census Data',
            'author_id' => $marie->id,
            'published_at' => now()->subDays(7),
            'created_at' => now()->subDays(10),
        ]);

        News::create([
            'title' => 'Agricultural Statistics 2023: Record Harvest Reported',
            'body' => '<h2>Agricultural Performance Overview</h2>
                      <p>The agricultural statistics for 2023 reveal a record-breaking year for Burundi\'s agricultural sector. Favorable weather conditions, improved farming techniques, and government support programs contributed to exceptional harvests across multiple crops.</p>
                      
                      <h3>Crop Production Highlights</h3>
                      <ul>
                        <li>Coffee production increased by 28% to 35,000 tons</li>
                        <li>Tea output rose by 15% to 8,200 tons</li>
                        <li>Rice production reached 95,000 tons, up 22%</li>
                        <li>Maize harvest improved by 18% to 385,000 tons</li>
                        <li>Bean production grew by 12% to 425,000 tons</li>
                      </ul>
                      
                      <h3>Livestock Sector</h3>
                      <p>The livestock sector also showed strong performance with cattle population increasing by 8% to 780,000 head. Goat and sheep populations grew by 12% and 15% respectively, reflecting improved animal husbandry practices.</p>
                      
                      <h3>Export Performance</h3>
                      <p>Agricultural exports, particularly coffee and tea, contributed significantly to foreign exchange earnings. Coffee exports alone generated $85 million in revenue, representing a 35% increase from 2022.</p>
                      
                      <h3>Challenges and Opportunities</h3>
                      <p>While celebrating these achievements, INSBU notes ongoing challenges including climate variability and market access. However, continued investment in agricultural technology and infrastructure presents significant opportunities for sustained growth.</p>',
            'excerpt' => 'Agricultural statistics for 2023 show record harvests with coffee production up 28% and significant growth across all major crops.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=800',
            'category' => 'Agriculture',
            'author_id' => $pierre->id,
            'published_at' => now()->subDays(12),
            'created_at' => now()->subDays(15),
        ]);

        News::create([
            'title' => 'Healthcare System Performance Analysis 2023',
            'body' => '<h2>Healthcare System Overview</h2>
                      <p>The annual healthcare system performance analysis provides comprehensive insights into the state of healthcare delivery across Burundi. The report examines key indicators including access, quality, and health outcomes.</p>
                      
                      <h3>Key Performance Indicators</h3>
                      <ul>
                        <li>Infant mortality rate decreased to 42 per 1,000 live births</li>
                        <li>Maternal mortality ratio improved to 548 per 100,000 live births</li>
                        <li>Immunization coverage reached 89% for basic vaccines</li>
                        <li>Healthcare facility accessibility improved by 15%</li>
                        <li>Doctor-to-patient ratio increased to 1:15,000</li>
                      </ul>
                      
                      <h3>Disease Prevention and Control</h3>
                      <p>Significant progress was made in disease prevention and control programs. Malaria incidence decreased by 23%, while HIV prevalence remained stable at 1.1%. Tuberculosis treatment success rate improved to 85%.</p>
                      
                      <h3>Healthcare Infrastructure</h3>
                      <p>The year 2023 saw substantial investments in healthcare infrastructure with 25 new health centers constructed and 15 existing facilities upgraded. Telemedicine initiatives expanded to serve remote areas.</p>
                      
                      <h3>Challenges and Recommendations</h3>
                      <p>Despite improvements, challenges remain in areas such as specialist care availability and medical equipment maintenance. The report recommends continued investment in healthcare workforce development and infrastructure.</p>',
            'excerpt' => 'Healthcare system analysis shows significant improvements in key indicators including reduced infant mortality and increased immunization coverage.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=800',
            'category' => 'Healthcare',
            'author_id' => $claude->id,
            'published_at' => now()->subDays(18),
            'created_at' => now()->subDays(20),
        ]);

        News::create([
            'title' => 'Education Statistics Dashboard Launch',
            'body' => '<h2>New Interactive Dashboard</h2>
                      <p>INSBU is excited to announce the launch of our new interactive Education Statistics Dashboard. This innovative platform provides real-time access to comprehensive education data and analytics.</p>
                      
                      <h3>Dashboard Features</h3>
                      <ul>
                        <li>Real-time enrollment and attendance tracking</li>
                        <li>Interactive maps showing school distribution</li>
                        <li>Graduation rate analytics by region and school type</li>
                        <li>Teacher-to-student ratio monitoring</li>
                        <li>Infrastructure and resource allocation tracking</li>
                      </ul>
                      
                      <h3>Key Education Statistics</h3>
                      <p>Current data shows primary school enrollment at 98.2%, with significant improvements in gender parity. Secondary school enrollment reached 45.6%, up from 41.3% in 2022.</p>
                      
                      <h3>User Access</h3>
                      <p>The dashboard is accessible to education policymakers, researchers, and development partners. Training sessions will be conducted to maximize the platform\'s utility for evidence-based decision making.</p>',
            'excerpt' => 'INSBU launches interactive Education Statistics Dashboard providing real-time access to comprehensive education data and analytics.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1497486751825-1233686d5d80?w=800',
            'category' => 'Education',
            'author_id' => $marie->id,
            'published_at' => now()->subDays(25),
            'created_at' => now()->subDays(28),
        ]);

        // Create a draft article
        News::create([
            'title' => 'Infrastructure Development Progress Report 2023',
            'body' => '<h2>Infrastructure Overview</h2>
                      <p>This draft report will cover the major infrastructure development achievements in 2023...</p>
                      
                      <h3>Key Projects</h3>
                      <ul>
                        <li>Road network expansion</li>
                        <li>Energy infrastructure improvements</li>
                        <li>Water and sanitation projects</li>
                        <li>Telecommunications infrastructure</li>
                      </ul>',
            'excerpt' => 'Comprehensive review of infrastructure development progress and key achievements in 2023.',
            'status' => 'draft',
            'category' => 'Infrastructure',
            'author_id' => $pierre->id,
            'created_at' => now()->subDays(2),
        ]);

        // Create a pending article
        News::create([
            'title' => 'Trade Statistics Monthly Update - January 2024',
            'body' => '<h2>Trade Performance</h2>
                      <p>January 2024 trade statistics show continued positive trends in both imports and exports...</p>',
            'excerpt' => 'Monthly trade statistics update showing import/export trends and economic indicators for January 2024.',
            'status' => 'pending',
            'category' => 'Trade',
            'author_id' => $claude->id,
            'created_at' => now()->subDay(),
        ]);

        // Add more articles with varied dates to ensure statistical data
        News::create([
            'title' => 'Tourism Statistics 2023: Growing Sector Shows Promise',
            'body' => '<h2>Tourism Growth Overview</h2>
                      <p>The tourism sector in Burundi showed remarkable growth in 2023, with international visitors increasing by 45% compared to 2022. This growth was driven by improved security, better infrastructure, and targeted marketing campaigns.</p>
                      
                      <h3>Key Tourism Statistics</h3>
                      <ul>
                        <li>International arrivals: 315,000 visitors (+45%)</li>
                        <li>Tourism revenue: $42 million (+38%)</li>
                        <li>Average stay: 5.2 days</li>
                        <li>Hotel occupancy rate: 68%</li>
                        <li>New tourism jobs created: 2,300</li>
                      </ul>
                      
                      <h3>Popular Destinations</h3>
                      <p>Lake Tanganyika remains the top destination, followed by Kibira National Park and Rusizi National Park. Cultural tourism sites in Gitega and historical sites in Bujumbura also saw increased visitor numbers.</p>
                      
                      <h3>Future Outlook</h3>
                      <p>With continued investment in tourism infrastructure and marketing, INSBU projects further growth in 2024, targeting 400,000 international visitors.</p>',
            'excerpt' => 'Tourism sector shows 45% growth in 2023 with increased international visitors and revenue generation.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
            'category' => 'Tourism',
            'author_id' => $marie->id,
            'published_at' => now()->subMonths(1)->subDays(5),
            'created_at' => now()->subMonths(1)->subDays(8),
        ]);

        News::create([
            'title' => 'Energy Production Statistics Q3 2023',
            'body' => '<h2>Energy Sector Performance</h2>
                      <p>The third quarter of 2023 marked significant progress in Burundi\'s energy sector, with increased production capacity and improved distribution networks.</p>
                      
                      <h3>Production Highlights</h3>
                      <ul>
                        <li>Hydroelectric generation: 285 GWh (+12%)</li>
                        <li>Solar installations: 45 MW new capacity</li>
                        <li>Grid connection rate: 12.3% (+1.8%)</li>
                        <li>Rural electrification projects: 156 villages</li>
                        <li>Energy efficiency improvements: 8%</li>
                      </ul>
                      
                      <h3>Renewable Energy Progress</h3>
                      <p>Renewable energy sources now account for 94% of total electricity production. New solar and micro-hydro projects are contributing to increased energy access in rural areas.</p>',
            'excerpt' => 'Q3 2023 energy statistics show 12% increase in hydroelectric generation and expanded rural electrification.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=800',
            'category' => 'Energy',
            'author_id' => $admin->id,
            'published_at' => now()->subMonths(2)->subDays(10),
            'created_at' => now()->subMonths(2)->subDays(12),
        ]);

        News::create([
            'title' => 'Financial Services Sector Analysis 2023',
            'body' => '<h2>Banking and Finance Overview</h2>
                      <p>The financial services sector continued its expansion in 2023, with increased banking penetration and growth in mobile financial services.</p>
                      
                      <h3>Banking Statistics</h3>
                      <ul>
                        <li>Bank branches: 187 (+15 new branches)</li>
                        <li>Account holders: 1.2 million (+18%)</li>
                        <li>Credit portfolio: $890 million (+22%)</li>
                        <li>Deposits: $1.3 billion (+16%)</li>
                        <li>ATM network: 245 machines (+35)</li>
                      </ul>
                      
                      <h3>Mobile Money Growth</h3>
                      <p>Mobile money services saw explosive growth with 3.8 million active users, representing 30% of the adult population. Transaction values increased by 65% to $2.1 billion.</p>',
            'excerpt' => 'Financial services sector shows strong growth with 18% increase in bank account holders and 65% growth in mobile money.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800',
            'category' => 'Finance',
            'author_id' => $pierre->id,
            'published_at' => now()->subMonths(3)->subDays(2),
            'created_at' => now()->subMonths(3)->subDays(5),
        ]);

        News::create([
            'title' => 'Manufacturing Sector Growth Report 2023',
            'body' => '<h2>Industrial Production Analysis</h2>
                      <p>The manufacturing sector demonstrated robust growth in 2023, driven by increased domestic demand and export opportunities.</p>
                      
                      <h3>Production Statistics</h3>
                      <ul>
                        <li>Manufacturing output index: 112.5 (+8.3%)</li>
                        <li>Food processing: 235,000 tons (+15%)</li>
                        <li>Textile production: 12 million meters (+22%)</li>
                        <li>Construction materials: +18%</li>
                        <li>New manufacturing jobs: 8,500</li>
                      </ul>
                      
                      <h3>Export Performance</h3>
                      <p>Manufactured exports reached $125 million, with textiles and processed foods leading the growth. New markets in the East African region contributed significantly to this expansion.</p>',
            'excerpt' => 'Manufacturing sector posts 8.3% growth with strong performance in food processing and textiles.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800',
            'category' => 'Manufacturing',
            'author_id' => $claude->id,
            'published_at' => now()->subMonths(4)->subDays(8),
            'created_at' => now()->subMonths(4)->subDays(11),
        ]);

        // Add recent articles for current month
        News::create([
            'title' => 'Digital Transformation in Public Services 2024',
            'body' => '<h2>E-Government Progress</h2>
                      <p>The government\'s digital transformation initiative has made significant progress in modernizing public services and improving citizen access to government information.</p>
                      
                      <h3>Digital Services Launched</h3>
                      <ul>
                        <li>Online business registration portal</li>
                        <li>Digital tax filing system</li>
                        <li>Electronic passport application</li>
                        <li>Online land registry services</li>
                        <li>Digital health records system</li>
                      </ul>
                      
                      <h3>Usage Statistics</h3>
                      <p>Over 85,000 citizens have used the new digital services, with a 92% satisfaction rate. Processing times have been reduced by an average of 65%.</p>',
            'excerpt' => 'Government digital transformation shows strong progress with 85,000+ citizens using new e-services.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800',
            'category' => 'Technology',
            'author_id' => $marie->id,
            'published_at' => now()->subDays(1),
            'created_at' => now()->subDays(3),
        ]);

        News::create([
            'title' => 'Small Business Development Statistics 2024',
            'body' => '<h2>SME Sector Growth</h2>
                      <p>Small and medium enterprises continue to be the backbone of Burundi\'s economy, showing resilient growth and job creation in early 2024.</p>
                      
                      <h3>Current Statistics</h3>
                      <ul>
                        <li>Registered SMEs: 45,600 (+12% from 2023)</li>
                        <li>New business registrations: 3,200 (Q1 2024)</li>
                        <li>SME employment: 340,000 people</li>
                        <li>Access to credit: 28% of SMEs</li>
                        <li>Digital adoption: 42% use digital tools</li>
                      </ul>
                      
                      <h3>Support Programs</h3>
                      <p>Government support programs have provided training to 8,500 entrepreneurs and facilitated access to $15 million in credit facilities.</p>',
            'excerpt' => 'SME sector shows 12% growth with 45,600 registered businesses and strong job creation.',
            'status' => 'published',
            'image_url' => 'https://images.unsplash.com/photo-1556761175-4b46a572b786?w=800',
            'category' => 'Business',
            'author_id' => $admin->id,
            'published_at' => now(),
            'created_at' => now()->subHours(6),
        ]);
    }
}
