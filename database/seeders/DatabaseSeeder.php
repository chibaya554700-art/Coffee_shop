<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::firstOrCreate(
            ['email' => 'admin@coffeeshop.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin1234'),
                'is_admin' => true,
            ]
        );

        // Test user account
        User::firstOrCreate(
            ['email' => 'user@coffeeshop.com'],
            [
                'name'     => 'Test User',
                'password' => Hash::make('user1234'),
                'is_admin' => false,
            ]
        );

        // ── Categories ───────────────────────────────────────────
        $categories = [
            ['name' => 'Hot Drinks',   'slug' => 'hot-drinks',   'icon' => '☕'],
            ['name' => 'Iced Drinks',  'slug' => 'iced-drinks',  'icon' => '🧊'],
            ['name' => 'Blended',      'slug' => 'blended',      'icon' => '🥤'],
            ['name' => 'Teas',         'slug' => 'teas',         'icon' => '🍵'],
            ['name' => 'Food',         'slug' => 'food',         'icon' => '🥐'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        $hot     = Category::where('slug', 'hot-drinks')->first();
        $iced    = Category::where('slug', 'iced-drinks')->first();
        $blended = Category::where('slug', 'blended')->first();
        $tea     = Category::where('slug', 'teas')->first();
        $food    = Category::where('slug', 'food')->first();

        // ── Products ─────────────────────────────────────────────
        $products = [
            // Hot Drinks
            ['category_id' => $hot->id, 'name' => 'Classic Espresso', 'description' => 'Bold, rich single-origin espresso shot.', 'price' => 95,  'image' => 'products/espresso.jpg',       'is_featured' => true],
            ['category_id' => $hot->id, 'name' => 'Café Latte',       'description' => 'Smooth espresso with silky steamed milk.',  'price' => 145, 'image' => 'products/cafe-latte.jpg',      'is_featured' => true],
            ['category_id' => $hot->id, 'name' => 'Cappuccino',       'description' => 'Equal parts espresso, steamed, and foamed milk.', 'price' => 145, 'image' => 'products/cappuccino.jpg', 'is_featured' => false],
            ['category_id' => $hot->id, 'name' => 'Americano',        'description' => 'Espresso diluted with hot water.',          'price' => 110, 'image' => 'products/americano.jpg',      'is_featured' => false],

            ['category_id' => $iced->id, 'name' => 'Iced Café Latte',  'description' => 'Chilled espresso over ice with cold milk.', 'price' => 160, 'image' => 'products/iced-latte.jpg',     'is_featured' => true],
            ['category_id' => $iced->id, 'name' => 'Iced Americano',   'description' => 'Espresso over ice, refreshingly smooth.',  'price' => 125, 'image' => 'products/iced-americano.jpg', 'is_featured' => false],
            ['category_id' => $iced->id, 'name' => 'Cold Brew',        'description' => '12-hour steeped cold brew concentrate.',   'price' => 170, 'image' => 'products/cold-brew.jpg',      'is_featured' => true],

            ['category_id' => $blended->id, 'name' => 'Java Chip Frappé', 'description' => 'Mocha blended with chocolate chips & cream.', 'price' => 195, 'image' => 'products/java-chip.jpg',      'is_featured' => true],
            ['category_id' => $blended->id, 'name' => 'Caramel Blaze',    'description' => 'Caramel drizzle blended with vanilla cream.', 'price' => 195, 'image' => 'products/caramel-blaze.jpg',  'is_featured' => false],

            ['category_id' => $tea->id, 'name' => 'Earl Grey Lavender', 'description' => 'Fragrant bergamot tea with calming lavender.', 'price' => 120, 'image' => 'products/earl-grey.jpg',    'is_featured' => false],
            ['category_id' => $tea->id, 'name' => 'Chamomile Honey',    'description' => 'Soothing chamomile with a drizzle of honey.', 'price' => 115, 'image' => 'products/chamomile.jpg',     'is_featured' => false],

            ['category_id' => $food->id, 'name' => 'Butter Croissant', 'description' => 'Flaky, golden-baked all-butter croissant.',              'price' => 95,  'image' => 'products/croissant.jpg',      'is_featured' => true],
            ['category_id' => $food->id, 'name' => 'Avocado Toast',    'description' => 'Sourdough topped with smashed avocado & chili flakes.',  'price' => 175, 'image' => 'products/avocado-toast.jpg',  'is_featured' => false],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                array_merge($product, ['is_available' => true])
            );
        }

        // ── Testimonials ─────────────────────────────────────────
        $testimonials = [
            ['name' => 'Maria Santos',   'message' => 'The Café Latte here is absolutely divine! Smooth, rich, and perfectly balanced. This is my go-to spot every morning.',  'rating' => 5, 'is_active' => true],
            ['name' => 'James Reyes',    'message' => 'Great ambiance, even better coffee. The Cold Brew kept me going the whole afternoon. Highly recommend!',                'rating' => 5, 'is_active' => true],
            ['name' => 'Ana Villanueva', 'message' => 'Love the variety of teas! The Earl Grey Lavender is my personal favorite. Staff is always so warm and welcoming.',      'rating' => 5, 'is_active' => true],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(['name' => $t['name']], $t);
        }

        // ── Branches ─────────────────────────────────────────────
        $branches = [
            ['name' => 'SM City Davao',    'address' => 'JP Laurel Ave, Bajada', 'city' => 'Davao City', 'phone' => '(082) 123-4567', 'hours' => '7:00 AM – 10:00 PM'],
            ['name' => 'Abreeza Mall',     'address' => 'JP Laurel Ave, Bajada', 'city' => 'Davao City', 'phone' => '(082) 234-5678', 'hours' => '8:00 AM – 9:00 PM'],
            ['name' => 'Gaisano Toril',    'address' => 'Toril District',        'city' => 'Davao City', 'phone' => '(082) 345-6789', 'hours' => '8:00 AM – 9:00 PM'],
        ];

        foreach ($branches as $b) {
            Branch::firstOrCreate(['name' => $b['name']], $b);
        }

        $this->command->info('Coffee Shop seeded successfully!');
    }
}
