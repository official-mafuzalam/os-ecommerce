<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        // --------------------
        // API Settings (dynamic)
        // --------------------
        $apis = [
            // 'openai' => [
            //     'key' => env('OPENAI_API_KEY', null),
            //     'enabled' => true,
            //     'model' => 'gpt-3.5-turbo',
            // ],
            // 'mistral' => [
            //     'key' => env('MISTRAL_API_KEY', null),
            //     'enabled' => false,
            //     'model' => 'open-mistral-8x22b',
            // ],
            // 'deepseek' => [
            //     'key' => env('DEEPSEEK_API_KEY', null),
            //     'enabled' => false,
            //     'model' => 'deepseek-chat',
            // ],
            'gemini' => [
                'key' => env('GOOGLE_API_KEY', null),
                'enabled' => false,
                'model' => 'gemini-3-flash-preview',
            ],
        ];

        foreach ($apis as $apiName => $config) {
            foreach ($config as $configKey => $configValue) {
                Setting::updateOrCreate(
                    [
                        'key' => "api_{$apiName}_{$configKey}",
                        'group' => 'apis',
                    ],
                    [
                        'value' => is_bool($configValue) ? ($configValue ? '1' : '0') : $configValue,
                        'type' => is_bool($configValue) ? 'boolean' : 'text',
                        'label' => ucfirst($apiName) . ' ' . ucfirst(str_replace('_', ' ', $configKey)),
                        'order' => 0,
                    ]
                );
            }
        }

        // --------------------
        // General Settings
        // --------------------
        $generalSettings = [
            [
                'key' => 'site_name',
                'value' => 'Octosync Ecommerce',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Name',
                'order' => 0,
            ],
            [
                'key' => 'site_title',
                'value' => 'Octosync Ecommerce - Premium AI Powered Ecommerce Solution',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Title',
                'order' => 1,
            ],
            [
                'key' => 'site_url',
                'value' => 'https://www.octosyncsoftware.com',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site URL',
                'order' => 2,
            ],
            [
                'key' => 'site_email',
                'value' => 'info@octosyncsoftware.com',
                'type' => 'email',
                'group' => 'general',
                'label' => 'Site Email',
                'order' => 3,
            ],
            [
                'key' => 'site_phone',
                'value' => '+8801621833839',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Phone Number',
                'order' => 4,
            ],
            [
                'key' => 'site_address',
                'value' => 'Hemayetpur, Savar, Dhaka',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Address',
                'order' => 5,
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
                'label' => 'Site Logo',
                'order' => 6,
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
                'label' => 'Favicon',
                'order' => 7,
            ],
            [
                'key' => 'license_key',
                'value' => '508c4dd9-2e3e-40d6-bbdd-872b28c1ea49',
                'type' => 'text',
                'group' => 'general',
                'label' => 'License Key',
                'order' => 8,
            ],
            [
                'key' => 'google_map_embed_code',
                'value' => null,
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Google Map Embed Code',
                'order' => 9,
            ]
        ];

        foreach ($generalSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // Default Layout Setting
        // --------------------
        Setting::updateOrCreate(
            ['key' => 'default_layout_type', 'group' => 'general'],
            [
                'value' => 'layout1', // default
                'type' => 'radio',
                'label' => 'Default Public Page Layout',
                'options' => json_encode([
                    'layout1' => 'Layout 1',
                    'layout2' => 'Layout 2',
                ]),
                'order' => 8,
            ]
        );

        // --------------------
        // About Us Settings
        // --------------------
        $aboutSettings = [
            // Hero Section
            [
                'key' => 'about_hero_title',
                'value' => 'The Story Behind Our Business',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Hero Section Title',
                'order' => 1
            ],
            [
                'key' => 'about_hero_subtitle',
                'value' => 'A journey of passion, craftsmanship, and style that redefines luxury fashion experiences',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Hero Section Subtitle',
                'order' => 2
            ],
            [
                'key' => 'business_start_year',
                'value' => date('Y') - 3,
                'type' => 'text',
                'group' => 'about',
                'label' => 'Business Start Year',
                'order' => 4
            ],

            // Our Journey Section
            [
                'key' => 'journey_title',
                'value' => 'Our Journey',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Journey Section Title',
                'order' => 5
            ],
            [
                'key' => 'journey_description_1',
                'value' => 'Founded in ' . (date('Y') - 3) . ', we began as a small boutique with a big vision: to bring exceptional fashion to discerning customers worldwide. What started with curated collections from local artisans has evolved into a premier destination for luxury fashion.',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Journey Description Part 1',
                'order' => 6
            ],
            [
                'key' => 'journey_description_2',
                'value' => 'Our commitment extends beyond just selling clothes; we\'re dedicated to creating memorable experiences. Each piece in our collection is selected for its quality, craftsmanship, and ability to inspire confidence and style.',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Journey Description Part 2',
                'order' => 7
            ],
            [
                'key' => 'journey_image',
                'value' => null,
                'type' => 'image',
                'group' => 'about',
                'label' => 'Journey Section Image',
                'order' => 8
            ],

            // Statistics
            [
                'key' => 'stat_customers',
                'value' => '50K+',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Number of Customers',
                'order' => 9
            ],
            [
                'key' => 'stat_products',
                'value' => '5K+',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Number of Products',
                'order' => 10
            ],
            [
                'key' => 'stat_brands',
                'value' => '120+',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Number of Brands',
                'order' => 11
            ],
            [
                'key' => 'stat_countries',
                'value' => '15+',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Countries Served',
                'order' => 12
            ],

            // Our Values
            [
                'key' => 'values_title',
                'value' => 'The Principles That Define Us',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Values Section Title',
                'order' => 13
            ],
            [
                'key' => 'values_subtitle',
                'value' => 'These core values guide every decision we make and every experience we create',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Values Section Subtitle',
                'order' => 14
            ],

            // Value 1: Quality Craftsmanship
            [
                'key' => 'value_1_title',
                'value' => 'Quality Craftsmanship',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Value 1 - Title',
                'order' => 15
            ],
            [
                'key' => 'value_1_description',
                'value' => 'Every product is meticulously crafted with attention to detail and premium materials',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Value 1 - Description',
                'order' => 16
            ],

            // Value 2: Sustainable Fashion
            [
                'key' => 'value_2_title',
                'value' => 'Sustainable Fashion',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Value 2 - Title',
                'order' => 17
            ],
            [
                'key' => 'value_2_description',
                'value' => 'Committed to ethical sourcing and environmentally conscious practices',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Value 2 - Description',
                'order' => 18
            ],

            // Value 3: Personal Style
            [
                'key' => 'value_3_title',
                'value' => 'Personal Style',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Value 3 - Title',
                'order' => 19
            ],
            [
                'key' => 'value_3_description',
                'value' => 'Helping you discover and express your unique personal style with confidence',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Value 3 - Description',
                'order' => 20
            ],

            // Value 4: Exceptional Service
            [
                'key' => 'value_4_title',
                'value' => 'Exceptional Service',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Value 4 - Title',
                'order' => 21
            ],
            [
                'key' => 'value_4_description',
                'value' => 'Dedicated to providing personalized, attentive service at every touchpoint',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Value 4 - Description',
                'order' => 22
            ],

            // Our Process
            [
                'key' => 'process_title',
                'value' => 'From Concept to Collection',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Process Section Title',
                'order' => 23
            ],

            // Process Step 1
            [
                'key' => 'process_step_1_title',
                'value' => 'Curated Selection',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Process Step 1 - Title',
                'order' => 24
            ],
            [
                'key' => 'process_step_1_description',
                'value' => 'Our fashion experts travel globally to discover emerging designers and established brands that align with our quality standards and aesthetic vision.',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Process Step 1 - Description',
                'order' => 25
            ],

            // Process Step 2
            [
                'key' => 'process_step_2_title',
                'value' => 'Quality Assurance',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Process Step 2 - Title',
                'order' => 26
            ],
            [
                'key' => 'process_step_2_description',
                'value' => 'Each product undergoes rigorous quality checks, from material inspection to craftsmanship evaluation, ensuring only the finest items reach our customers.',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Process Step 2 - Description',
                'order' => 27
            ],

            // Process Step 3
            [
                'key' => 'process_step_3_title',
                'value' => 'Styling Expertise',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Process Step 3 - Title',
                'order' => 28
            ],
            [
                'key' => 'process_step_3_description',
                'value' => 'Our styling team creates curated looks and provides fashion advice to help customers build cohesive wardrobes that reflect their personal style.',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Process Step 3 - Description',
                'order' => 29
            ],

            // Team Section
            [
                'key' => 'team_title',
                'value' => 'Meet Our Fashion Leaders',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Team Section Title',
                'order' => 30
            ],
            [
                'key' => 'team_subtitle',
                'value' => 'The creative minds shaping the future of fashion retail',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Team Section Subtitle',
                'order' => 31
            ],

            // Team Member 1
            [
                'key' => 'team_member_1_name',
                'value' => 'Isabella Rossi',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Team Member 1 - Name',
                'order' => 32
            ],
            [
                'key' => 'team_member_1_position',
                'value' => 'Creative Director & Founder',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Team Member 1 - Position',
                'order' => 33
            ],
            [
                'key' => 'team_member_1_description',
                'value' => 'With 15 years in luxury fashion, Isabella\'s vision shapes our aesthetic direction and brand identity.',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Team Member 1 - Description',
                'order' => 34
            ],
            [
                'key' => 'team_member_1_image',
                'value' => null,
                'type' => 'image',
                'group' => 'about',
                'label' => 'Team Member 1 - Image',
                'order' => 35
            ],

            // Team Member 2
            [
                'key' => 'team_member_2_name',
                'value' => 'Alexander Chen',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Team Member 2 - Name',
                'order' => 36
            ],
            [
                'key' => 'team_member_2_position',
                'value' => 'Head of Design & Merchandising',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Team Member 2 - Position',
                'order' => 37
            ],
            [
                'key' => 'team_member_2_description',
                'value' => 'Alexander\'s expertise in global fashion trends ensures our collections remain contemporary and relevant.',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Team Member 2 - Description',
                'order' => 38
            ],
            [
                'key' => 'team_member_2_image',
                'value' => null,
                'type' => 'image',
                'group' => 'about',
                'label' => 'Team Member 2 - Image',
                'order' => 39
            ],

            // Team Member 3
            [
                'key' => 'team_member_3_name',
                'value' => 'Sophia Williams',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Team Member 3 - Name',
                'order' => 40
            ],
            [
                'key' => 'team_member_3_position',
                'value' => 'Customer Experience Director',
                'type' => 'text',
                'group' => 'about',
                'label' => 'Team Member 3 - Position',
                'order' => 41
            ],
            [
                'key' => 'team_member_3_description',
                'value' => 'Sophia leads our commitment to exceptional service, ensuring every customer feels valued and understood.',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'Team Member 3 - Description',
                'order' => 42
            ],
            [
                'key' => 'team_member_3_image',
                'value' => null,
                'type' => 'image',
                'group' => 'about',
                'label' => 'Team Member 3 - Image',
                'order' => 43
            ],

            // CTA Section
            [
                'key' => 'cta_title',
                'value' => 'Ready to Experience Premium Fashion?',
                'type' => 'text',
                'group' => 'about',
                'label' => 'CTA Section Title',
                'order' => 44
            ],
            [
                'key' => 'cta_description',
                'value' => 'Join thousands of satisfied customers who trust us for their style journey',
                'type' => 'textarea',
                'group' => 'about',
                'label' => 'CTA Section Description',
                'order' => 45
            ],
        ];

        foreach ($aboutSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }


        // --------------------
        // Social Media
        // --------------------
        $socialSettings = [
            ['key' => 'facebook_url', 'value' => 'https://www.facebook.com/octosyncsoftwareltd', 'type' => 'text', 'group' => 'social', 'label' => 'Facebook URL', 'order' => 1],
            ['key' => 'tiktok_url', 'value' => 'https://www.tiktok.com/@official_mafuz', 'type' => 'text', 'group' => 'social', 'label' => 'TikTok URL', 'order' => 2],
            ['key' => 'instagram_url', 'value' => 'https://www.instagram.com/official.mafuz.alam', 'type' => 'text', 'group' => 'social', 'label' => 'Instagram URL', 'order' => 3],
            ['key' => 'youtube_url', 'value' => 'https://www.youtube.com/@mafuzalam', 'type' => 'text', 'group' => 'social', 'label' => 'Youtube URL', 'order' => 4],
            ['key' => 'whatsapp_number', 'value' => '8801621833839', 'type' => 'text', 'group' => 'social', 'label' => 'WhatsApp Number', 'order' => 5],
            ['key' => 'whatsapp_message', 'value' => 'Hello! I have a question about your products.', 'type' => 'text', 'group' => 'social', 'label' => 'Default WhatsApp Message', 'order' => 6],
            ['key' => 'whatsapp_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'social', 'label' => 'Enable WhatsApp Button', 'order' => 7],
        ];

        foreach ($socialSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // Analytics
        // --------------------
        $analyticsSettings = [
            ['key' => 'google_tag_manager_id', 'value' => null, 'type' => 'text', 'group' => 'analytics', 'label' => 'Google Tag Manager ID', 'order' => 1],
            ['key' => 'fb_pixel_id', 'value' => null, 'type' => 'text', 'group' => 'analytics', 'label' => 'Facebook Pixel ID', 'order' => 2],
            ['key' => 'facebook_access_token', 'value' => null, 'type' => 'text', 'group' => 'analytics', 'label' => 'Facebook Access Token', 'order' => 3],
            ['key' => 'facebook_test_event_code', 'value' => null, 'type' => 'text', 'group' => 'analytics', 'label' => 'Facebook Test Event Code', 'order' => 4],
            // ['key' => 'google_analytics_id', 'value' => null, 'type' => 'text', 'group' => 'analytics', 'label' => 'Google Analytics ID', 'order' => 5],
        ];

        foreach ($analyticsSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // -------------------
        // Order Settings
        // -------------------
        $orderSettings = [
            ['key' => 'order_form_bangla', 'value' => '0', 'type' => 'boolean', 'group' => 'order', 'label' => 'Order Form Language in Bangla?', 'order' => 1],
            ['key' => 'order_email_need', 'value' => '0', 'type' => 'boolean', 'group' => 'order', 'label' => 'Is Email Required in Order Form?', 'order' => 2],
            ['key' => 'order_notes_need', 'value' => '0', 'type' => 'boolean', 'group' => 'order', 'label' => 'Are Additional Notes Required in Order Form?', 'order' => 3],
            ['key' => 'delivery_charge_inside_dhaka', 'value' => '80', 'type' => 'text', 'group' => 'order', 'label' => 'Inside Dhaka Shipping Cost (TK)', 'order' => 4],
            ['key' => 'delivery_charge_outside_dhaka', 'value' => '150', 'type' => 'text', 'group' => 'order', 'label' => 'Outside Dhaka Shipping Cost (TK)', 'order' => 5],
            // ['key' => 'free_shipping_threshold', 'value' => '2000', 'type' => 'text', 'group' => 'order', 'label' => 'Free Shipping Threshold (TK)', 'order' => 6],
        ];

        foreach ($orderSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // SEO & Meta Tags
        // --------------------
        $seoSettings = [
            ['key' => 'meta_description', 'value' => null, 'type' => 'textarea', 'group' => 'seo', 'label' => 'Meta Description', 'order' => 1],
            ['key' => 'meta_keywords', 'value' => null, 'type' => 'textarea', 'group' => 'seo', 'label' => 'Meta Keywords', 'order' => 2],
            ['key' => 'meta_author', 'value' => null, 'type' => 'text', 'group' => 'seo', 'label' => 'Meta Author', 'order' => 3],
            ['key' => 'meta_language', 'value' => 'English', 'type' => 'text', 'group' => 'seo', 'label' => 'Meta Language', 'order' => 4],
        ];

        foreach ($seoSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // Open Graph (OG Tags)
        // --------------------
        $ogSettings = [
            ['key' => 'og_title', 'value' => null, 'type' => 'text', 'group' => 'opengraph', 'label' => 'OG Title', 'order' => 1],
            ['key' => 'og_description', 'value' => null, 'type' => 'textarea', 'group' => 'opengraph', 'label' => 'OG Description', 'order' => 2],
            ['key' => 'og_image', 'value' => null, 'type' => 'image', 'group' => 'opengraph', 'label' => 'OG Image', 'order' => 3],
            ['key' => 'og_url', 'value' => null, 'type' => 'text', 'group' => 'opengraph', 'label' => 'OG URL', 'order' => 4],
            ['key' => 'og_type', 'value' => 'website', 'type' => 'text', 'group' => 'opengraph', 'label' => 'OG Type', 'order' => 5],
            ['key' => 'fb_app_id', 'value' => null, 'type' => 'text', 'group' => 'opengraph', 'label' => 'Facebook App ID', 'order' => 6],
        ];

        foreach ($ogSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // Twitter Card
        // --------------------
        $twitterSettings = [
            ['key' => 'twitter_card', 'value' => 'summary_large_image', 'type' => 'text', 'group' => 'twitter', 'label' => 'Twitter Card Type', 'order' => 1],
            ['key' => 'twitter_title', 'value' => null, 'type' => 'text', 'group' => 'twitter', 'label' => 'Twitter Title', 'order' => 2],
            ['key' => 'twitter_description', 'value' => null, 'type' => 'textarea', 'group' => 'twitter', 'label' => 'Twitter Description', 'order' => 3],
            ['key' => 'twitter_image', 'value' => null, 'type' => 'image', 'group' => 'twitter', 'label' => 'Twitter Image', 'order' => 4],
        ];

        foreach ($twitterSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // Mail Settings
        // --------------------
        $mailSettings = [
            [
                'key' => 'mail_mailer',
                'value' => env('MAIL_MAILER', 'smtp'),
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail Mailer',
                'order' => 1,
            ],
            [
                'key' => 'mail_host',
                'value' => env('MAIL_HOST', 'smtp.example.com'),
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail Host',
                'order' => 2,
            ],
            [
                'key' => 'mail_port',
                'value' => env('MAIL_PORT', '587'),
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail Port',
                'order' => 3,
            ],
            [
                'key' => 'mail_username',
                'value' => env('MAIL_USERNAME', null),
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail Username',
                'order' => 4,
            ],
            [
                'key' => 'mail_password',
                'value' => env('MAIL_PASSWORD', null),
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail Password',
                'order' => 5,
            ],
            [
                'key' => 'mail_encryption',
                'value' => env('MAIL_ENCRYPTION', null),
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail Encryption',
                'order' => 6,
            ],
            [
                'key' => 'mail_from_address',
                'value' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail From Address',
                'order' => 7,
            ],
            [
                'key' => 'mail_from_name',
                'value' => env('MAIL_FROM_NAME', config('app.name')),
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail From Name',
                'order' => 8,
            ],
        ];

        foreach ($mailSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

    }
}
