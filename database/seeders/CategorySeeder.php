<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Websites',
                'description' => 'Complete website solutions',
                'icon' => 'fas fa-globe',
                'subcategories' => [
                    'E-Commerce',
                    'Portfolio', 
                    'Blog',
                    'Business',
                    'Landing Page'
                ]
            ],
            [
                'name' => 'Apps',
                'description' => 'Mobile and web applications',
                'icon' => 'fas fa-mobile-alt',
                'subcategories' => [
                    'Mobile',
                    'Web App',
                    'Desktop',
                    'Progressive Web App'
                ]
            ],
            [
                'name' => 'Templates',
                'description' => 'Ready-to-use templates',
                'icon' => 'fas fa-file-code',
                'subcategories' => [
                    'HTML',
                    'WordPress',
                    'Shopify',
                    'React',
                    'Vue.js'
                ]
            ],
            [
                'name' => 'Plugins',
                'description' => 'Extensions and plugins',
                'icon' => 'fas fa-plug',
                'subcategories' => [
                    'WordPress',
                    'Browser Extension',
                    'Premiere Pro',
                    'After Effects'
                ]
            ],
            [
                'name' => 'UI Kits',
                'description' => 'User interface components',
                'icon' => 'fas fa-palette',
                'subcategories' => [
                    'Web UI',
                    'Mobile UI',
                    'Dashboard',
                    'Admin Panel'
                ]
            ],
            [
                'name' => 'Services',
                'description' => 'Digital services',
                'icon' => 'fas fa-handshake',
                'subcategories' => [
                    'Development',
                    'Design',
                    'Consultation',
                    'Maintenance'
                ]
            ],
            [
                'name' => 'Illustrations',
                'description' => 'Digital artwork and illustrations',
                'icon' => 'fas fa-paint-brush',
                'subcategories' => [
                    'Vector',
                    'Raster',
                    '3D Models',
                    'Icons'
                ]
            ],
            [
                'name' => 'Icon Sets',
                'description' => 'Icon collections',
                'icon' => 'fas fa-icons',
                'subcategories' => [
                    'Line Icons',
                    'Solid Icons',
                    'Colored Icons',
                    'Animated Icons'
                ]
            ]
        ];

        foreach ($categories as $index => $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'description' => $categoryData['description'],
                'icon' => $categoryData['icon'],
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);

            foreach ($categoryData['subcategories'] as $subIndex => $subName) {
                $slug = Str::slug($subName);
                $originalSlug = $slug;
                $counter = 1;
                
                // Ensure unique slug
                while (Subcategory::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                
                Subcategory::create([
                    'category_id' => $category->id,
                    'name' => $subName,
                    'slug' => $slug,
                    'sort_order' => $subIndex + 1,
                    'is_active' => true,
                ]);
            }
        }
    }
}