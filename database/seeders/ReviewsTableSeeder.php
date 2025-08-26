<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $reviews = collect([
                    ['rv_comment' => 'The quality of this jacket is amazing. It\'s soft, warm, and perfect for winter.'],
                    ['rv_comment' => 'My daughter says it\'s the most comfortable shirt she owns.'],
                    ['rv_comment' => 'Arrived earlier than expected! Great service.'],
                    ['rv_comment' => 'Size runs a bit small. I\'d recommend ordering one size up.'],
                    ['rv_comment' => 'The stitching feels sturdy and durable. Definitely not cheap material.'],
                    ['rv_comment' => 'So comfy, my son didn\'t want to take it off!'],
                    ['rv_comment' => 'Delivery was delayed by two days, but the product made up for it.'],
                    ['rv_comment' => 'True to size and fits perfectly on my 6-year-old.'],
                    ['rv_comment' => 'Fabric is breathable and gentle on the skin — ideal for sensitive kids.'],
                    ['rv_comment' => 'Impressed with the attention to detail. Looks just like the photos.'],
                    ['rv_comment' => 'Color didn\'t fade after washing, which is a big plus.'],
                    ['rv_comment' => 'A little loose on the waist, but otherwise fits well.'],
                    ['rv_comment' => 'Perfect for active toddlers — doesn\'t restrict movement.'],
                    ['rv_comment' => 'Fast shipping and came neatly packed.'],
                    ['rv_comment' => 'Feels soft but durable. Great for everyday wear.'],
                    ['rv_comment' => 'Love the patterns and bright colors. My kid loves picking it out!'],
                    ['rv_comment' => 'Was skeptical at first, but the quality surprised me.'],
                    ['rv_comment' => 'Order arrived quickly, and everything was exactly as described.'],
                    ['rv_comment' => 'The hoodie is thick and cozy. Great for chilly mornings.'],
                    ['rv_comment' => 'Fit is snug but not tight. Just right.'],
                    ['rv_comment' => 'Material feels premium and washes well.'],
                    ['rv_comment' => 'Comfortable even after a full day of wear.'],
                    ['rv_comment' => 'Pants are a bit long but easily rolled up.'],
                    ['rv_comment' => 'Very lightweight — great for summer days.'],
                    ['rv_comment' => 'Everything fits as expected. Sizing chart is accurate.'],
                    ['rv_comment' => 'Not too tight, not too loose. Just perfect.'],
                    ['rv_comment' => 'Seams are clean, and there\'s no loose thread.'],
                    ['rv_comment' => 'My child loves how soft it feels against the skin.'],
                    ['rv_comment' => 'Shipped fast with no issues. Great experience!'],
                    ['rv_comment' => 'A bit pricey but the quality justifies it.'],
                    ['rv_comment' => 'Nice stretch in the fabric — allows freedom to move.'],
                    ['rv_comment' => 'Good thickness — not see-through at all.'],
                    ['rv_comment' => 'I ordered two sizes to be safe. Kept the one that fit best.'],
                    ['rv_comment' => 'Excellent value for the price.'],
                    ['rv_comment' => 'Didn\'t shrink in the wash. That\'s a win.'],
                    ['rv_comment' => 'Perfect layering piece for fall.'],
                    ['rv_comment' => 'Super cute design and fits just right.'],
                    ['rv_comment' => 'No complaints — everything from order to delivery was smooth.'],
                    ['rv_comment' => 'Bought this for my niece — her mom loved it!'],
                    ['rv_comment' => 'Definitely buying more from this brand.'],
                    ['rv_comment' => 'My son is very picky and he actually likes this one.'],
                    ['rv_comment' => 'Very soft and stretchy. Great for playdates.'],
                    ['rv_comment' => 'The print didn\'t peel after washing, which is great.'],
                    ['rv_comment' => 'Tagless label makes it even more comfortable.'],
                    ['rv_comment' => 'Pleased with the durability after several washes.'],
                    ['rv_comment' => 'Exactly what I expected.'],
                    ['rv_comment' => 'Cute and functional — a rare combo.'],
                    ['rv_comment' => 'Wore it to daycare and teachers asked where I got it.'],
                    ['rv_comment' => 'The material feels cool and smooth, great for summer.'],
                    ['rv_comment' => 'Waistband is soft and doesn\'t leave marks.'],
                    ['rv_comment' => 'Would recommend to other parents.'],
                    ['rv_comment' => 'My daughter wore it to a birthday party and got so many compliments.'],
                    ['rv_comment' => 'Ordering a second one in a different color!'],
                    ['rv_comment' => 'Worked well as a gift — great packaging too.'],
                    ['rv_comment' => 'My kid spilled juice and it washed right out.'],
                    ['rv_comment' => 'Not itchy at all, which is rare with wool blends.'],
                    ['rv_comment' => 'The zipper is smooth and doesn\'t catch.'],
                    ['rv_comment' => 'Can be dressed up or down. Very versatile.'],
                    ['rv_comment' => 'It looks expensive but was affordable.'],
                    ['rv_comment' => 'The fabric doesn\'t wrinkle easily, even after nap time.'],
                    ['rv_comment' => 'Colors are vibrant and don\'t fade.'],
                    ['rv_comment' => 'Breathable enough for warmer climates.'],
                    ['rv_comment' => 'Runs true to size. Trust the size chart!'],
                    ['rv_comment' => 'Easy to mix and match with other clothes.'],
                    ['rv_comment' => 'Not a fan of the buttons, but overall nice.'],
                    ['rv_comment' => 'Great quality for the price point.'],
                    ['rv_comment' => 'Didn\'t shrink or lose shape in the dryer.'],
                    ['rv_comment' => 'Great for layering during colder months.'],
                    ['rv_comment' => 'The hoodie lining is super soft!'],
                    ['rv_comment' => 'My toddler loves putting this on by herself.'],
                    ['rv_comment' => 'Nice breathable fabric that keeps cool.'],
                    ['rv_comment' => 'Happy with the craftsmanship. Feels handmade.'],
                    ['rv_comment' => 'It fits great now and still has room to grow.'],
                    ['rv_comment' => 'Stretchy but doesn\'t lose its shape.'],
                    ['rv_comment' => 'Washed several times and still looks new.'],
                    ['rv_comment' => 'Got compliments from other parents at preschool.'],
                    ['rv_comment' => 'Simple and stylish. Exactly what I wanted.'],
                    ['rv_comment' => 'Lining is cozy but not too thick.'],
                    ['rv_comment' => 'Perfect balance of cute and practical.'],
                    ['rv_comment' => 'Lightweight but warm — perfect for in-between seasons.'],
                    ['rv_comment' => 'Packaging was thoughtful and eco-friendly.'],
                    ['rv_comment' => 'Color is true to what\'s shown online.'],
                    ['rv_comment' => 'Would recommend for kids with sensitive skin.'],
                    ['rv_comment' => 'No chemical smell out of the package.'],
                    ['rv_comment' => 'Great everyday piece — my child wears it constantly.'],
                    ['rv_comment' => 'Easy for kids to put on themselves.'],
                    ['rv_comment' => 'The drawstring isn\'t functional but still looks cute.'],
                    ['rv_comment' => 'My kid calls it their “cozy shirt.”'],
                    ['rv_comment' => 'Holding up well even with rough play.'],
                    ['rv_comment' => 'Love the gender-neutral style.'],
                    ['rv_comment' => 'Didn\'t expect much but was pleasantly surprised!'],
                    ['rv_comment' => 'Wish they made this in adult sizes too!'],
                    ['rv_comment' => 'No loose threads or uneven seams.'],
                    ['rv_comment' => 'My child usually hates tags but this one didn\'t bother her.'],
                    ['rv_comment' => 'Fits great even after washing and drying.'],
                    ['rv_comment' => 'We\'ve already ordered a second set.'],
                    ['rv_comment' => 'Great choice for school uniforms.'],
                    ['rv_comment' => 'Perfect for photoshoots and special events.'],
                    ['rv_comment' => 'Would definitely buy again from this store.'],
                    ['rv_comment' => 'It was a hit at the birthday party!'],
                ]
            );

        Review::factory()
            ->count(count($reviews))
            ->state(new Sequence(...$reviews))
            ->create();
    }
}
