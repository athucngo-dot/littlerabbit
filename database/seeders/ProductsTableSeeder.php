<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use \App\Models\Deal;
use \App\Models\Season;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nameNDescs = collect([
                ['name' => 'Bright Cotton Shirt', 'description' => 'This bright cotton shirt is perfect for playtime and keeps kids cool and comfortable all day.',
                'features' => json_encode([
                        "Lightweight breathable cotton",
                        "Machine washable for easy care",
                        "Button-up front closure",
                        "Available in multiple colors"
                    ])],
                ['name' => 'Comfy Denim Jeans', 'description' => 'Durable and stylish denim jeans that can withstand all the adventures of active kids.',
                'features' => json_encode([
                        "Reinforced knees for extra durability",
                        "Adjustable waistband for growing kids",
                        "Classic five-pocket design",
                        "Available in various washes"
                    ])],
                ['name' => 'Cozy Hoodie Sweatshirt', 'description' => 'A cozy hoodie sweatshirt that provides warmth and comfort during cooler days.',
                'features' => json_encode([
                        "Soft fleece lining",
                        "Front kangaroo pocket",
                        "Adjustable drawstring hood",
                        "Ribbed cuffs and hem"
                    ])],
                ['name' => 'Cozy Denim Jacket', 'description' => 'A cozy denim jacket designed to keep your child warm during cooler days with style and comfort.',
                'features' => json_encode([
                        "Soft fleece lining for warmth",
                        "Classic button-front design",
                        "Adjustable cuffs for a perfect fit",
                        "Durable denim fabric"
                    ])],
                ['name' => 'Durable Canvas Sneakers', 'description' => 'Durable canvas sneakers that are perfect for everyday wear and outdoor play.',
                'features' => json_encode([
                        "Breathable canvas upper",
                        "Rubber outsole for traction",  
                        "Padded collar for comfort",
                        "Available in various colors"
                    ])],
                ['name' => 'Soft Fleece Pants', 'description' => 'Soft fleece pants that allow free movement while keeping little legs warm during outdoor activities.',
                'features' => json_encode([
                        "Soft fleece fabric",
                        "Elastic waistband with drawstring",
                        "Ribbed cuffs for a snug fit",
                        "Machine washable"
                    ])],
                ['name' => 'Warm Wool Sweater', 'description' => 'A warm wool sweater that provides insulation and comfort during chilly days.',
                'features' => json_encode([
                        "100% wool for warmth",
                        "Ribbed neckline, cuffs, and hem",
                        "Classic knit pattern",
                        "Available in various colors"
                    ])],
                ['name' => 'Colorful Graphic Tee', 'description' => 'A colorful graphic tee with fun designs that kids will love to wear on casual days.',
                'features' => json_encode([
                        "Soft cotton fabric",
                        "Vibrant graphic prints",
                        "Crew neckline",
                        "Available in multiple sizes"
                    ])],
                ['name' => 'Light Cotton Dress', 'description' => 'A light cotton dress that is breathable and comfortable for warm weather activities.',
                'features' => json_encode([
                        "Lightweight cotton fabric",
                        "Elastic waistband for a comfortable fit",
                        "Flared skirt design",
                        "Available in various patterns"
                    ])],
                ['name' => 'Soft Cotton Pajamas', 'description' => 'Soft cotton pajamas that ensure a comfortable and restful night\'s sleep for kids.',
                'features' => json_encode([
                        "100% soft cotton fabric",
                        "Elastic waistband for comfort",
                        "Fun prints and patterns",
                        "Machine washable"
                    ])],
                ['name' => 'Durable Rain Boots', 'description' => 'Durable rain boots that keep little feet dry and comfortable during wet weather.',
                'features' => json_encode([
                        "Waterproof rubber construction",
                        "Non-slip sole for safety",
                        "Easy pull-on design",
                        "Available in various colors"
                    ])],
                ['name' => 'Lightweight Hoodie Sweatshirt', 'description' => 'This lightweight hoodie sweatshirt is great for layering and provides extra warmth without bulk.',
                'features' => json_encode([
                        "Lightweight fabric for layering",
                        "Front kangaroo pocket",
                        "Adjustable drawstring hood",
                        "Ribbed cuffs and hem"
                    ])],
                ['name' => 'Casual Cotton Shorts', 'description' => 'Casual cotton shorts that are perfect for warm weather and outdoor play.',
                'features' => json_encode([
                        "Lightweight cotton fabric",
                        "Elastic waistband with drawstring",
                        "Multiple pockets for convenience",
                        "Available in various colors"
                    ])],
                ['name' => 'Warm Fleece Jacket', 'description' => 'A warm fleece jacket that provides insulation and comfort during chilly days.',
                'features' => json_encode([
                        "Soft fleece fabric",
                        "Full front zipper",
                        "Side pockets for storage",
                        "Ribbed cuffs and hem"
                    ])],
                ['name' => 'Striped Cotton Socks', 'description' => 'Comfortable striped cotton socks that fit snugly and keep feet dry during playtime.',
                'features' => json_encode([
                        "Soft cotton blend",
                        "Elastic arch support",
                        "Reinforced heel and toe",
                        "Available in fun colors"
                    ])],
                ['name' => 'Bright Graphic Hoodie', 'description' => 'A bright graphic hoodie that combines warmth with playful style kids love.',
                'features' => json_encode([
                        "Soft fleece lining",
                        "Vibrant graphic prints",
                        "Adjustable drawstring hood",
                        "Ribbed cuffs and hem"
                    ])],
                ['name' => 'Durable Cargo Shorts', 'description' => 'Durable cargo shorts with plenty of pockets, perfect for adventurous kids on the go.'],
                ['name' => 'Soft Jersey Dress', 'description' => 'A soft jersey dress designed for comfort and easy movement, ideal for school or playdates.'],
                ['name' => 'Warm Winter Coat', 'description' => 'Keep kids warm during the cold months with this insulated winter coat that blocks wind and snow.'],
                ['name' => 'Playful Animal Pajamas', 'description' => 'Cozy pajamas featuring playful animal prints that make bedtime fun and comfortable.'],
                ['name' => 'Classic Polo Shirt', 'description' => 'A classic polo shirt made from breathable fabric, perfect for casual or semi-formal occasions.'],
                ['name' => 'Stretchy Leggings', 'description' => 'Stretchy leggings that fit comfortably and allow kids to run, jump, and play without restrictions.'],
                ['name' => 'Waterproof Rain Jacket', 'description' => 'Stay dry in rainy weather with this waterproof rain jacket, complete with a hood for extra protection.'],
                ['name' => 'Comfy Sweatpants', 'description' => 'Comfy sweatpants perfect for lounging at home or active play outdoors.'],
                ['name' => 'Fun Patterned Skirt', 'description' => 'A fun patterned skirt that combines style with comfort, great for casual outings.'],
                ['name' => 'Light Cotton Shorts', 'description' => 'Light cotton shorts that keep kids cool during warm weather activities.'],
                ['name' => 'Warm Knit Sweater', 'description' => 'A warm knit sweater made to keep kids cozy during chilly afternoons.'],
                ['name' => 'Cute Hooded Vest', 'description' => 'A cute hooded vest that adds a layer of warmth without restricting movement.'],
                ['name' => 'Casual Denim Jeans', 'description' => 'Casual denim jeans built tough to withstand all the fun and rough play kids get into.'],
                ['name' => 'Soft Cotton Tank Top', 'description' => 'A soft cotton tank top perfect for layering or wearing alone on hot days.'],
                ['name' => 'Striped Pajama Set', 'description' => 'A comfortable striped pajama set made with breathable fabric for restful nights.'],
                ['name' => 'Durable Overalls', 'description' => 'Durable overalls made for active kids who love to explore and play outside.'],
                ['name' => 'Light Rain Boots', 'description' => 'Light rain boots that keep feet dry and comfortable during wet weather.'],
                ['name' => 'Soft Knit Hat', 'description' => 'A soft knit hat that keeps little heads warm and cozy in cool weather.'],
                ['name' => 'Bright Graphic Hoodie', 'description' => 'A bright graphic hoodie that combines warmth with playful style kids love.'],
                ['name' => 'Comfy Cotton Pajamas', 'description' => 'Comfy cotton pajamas perfect for bedtime with soft fabric and fun prints.'],
                ['name' => 'Durable Sports Shorts', 'description' => 'Durable sports shorts designed for active kids who love to run and play games.'],
                ['name' => 'Classic Button-Up Shirt', 'description' => 'A classic button-up shirt that works well for casual or dressier occasions.'],
                ['name' => 'Warm Fleece Gloves', 'description' => 'Warm fleece gloves that keep little hands protected from the cold.'],
                ['name' => 'Soft Cotton Dress', 'description' => 'A soft cotton dress that offers comfort and style for everyday wear.'],
                ['name' => 'Lightweight Running Shoes', 'description' => 'Lightweight running shoes made for speed and comfort during playtime.'],
                ['name' => 'Cozy Wool Socks', 'description' => 'Cozy wool socks that provide warmth and cushioning for little feet.'],
                ['name' => 'Fun Printed Tights', 'description' => 'Fun printed tights that add color and warmth to any outfit.'],
                ['name' => 'Casual Hoodie', 'description' => 'A casual hoodie made from soft fabric that kids love to wear all day.'],
                ['name' => 'Durable Denim Jacket', 'description' => 'Durable denim jacket perfect for layering and outdoor adventures.'],
                ['name' => 'Warm Knit Scarf', 'description' => 'A warm knit scarf that keeps children comfortable in chilly weather.'],
                ['name' => 'Striped Cotton Shirt', 'description' => 'Striped cotton shirt that is breathable and perfect for everyday wear.'],
                ['name' => 'Soft Jersey Shorts', 'description' => 'Soft jersey shorts designed for comfort during sports and play.'],
                ['name' => 'Bright Winter Hat', 'description' => 'Bright winter hat that provides warmth and adds a pop of color to winter outfits.'],
                ['name' => 'Light Raincoat', 'description' => 'Light raincoat to keep kids dry while staying comfortable during rainy days.'],
                ['name' => 'Cozy Pajama Pants', 'description' => 'Cozy pajama pants perfect for a comfortable and restful night’s sleep.'],
                ['name' => 'Casual Cotton Sweater', 'description' => 'Casual cotton sweater that keeps kids warm while allowing freedom of movement.'],
                ['name' => 'Soft Fleece Vest', 'description' => 'Soft fleece vest that adds warmth without bulk, perfect for layering.'],
                ['name' => 'Durable Canvas Shoes', 'description' => 'Durable canvas shoes built to withstand daily play and adventures.'],
                ['name' => 'Fun Graphic T-shirt', 'description' => 'Fun graphic t-shirt featuring playful designs loved by kids.'],
                ['name' => 'Light Cotton Dress', 'description' => 'Light cotton dress that is breathable and comfortable for summer days.'],
                ['name' => 'Warm Knit Mittens', 'description' => 'Warm knit mittens that keep little hands cozy during cold weather.'],
                ['name' => 'Cozy Hooded Sweatshirt', 'description' => 'Cozy hooded sweatshirt perfect for layering on cool days.'],
                ['name' => 'Striped Cotton Leggings', 'description' => 'Striped cotton leggings that are stretchy and comfortable for active kids.'],
                ['name' => 'Durable Denim Overalls', 'description' => 'Durable denim overalls great for outdoor play and adventures.'],
                ['name' => 'Soft Cotton Pajama Set', 'description' => 'Soft cotton pajama set made for cozy nights and sweet dreams.'],
                ['name' => 'Bright Cotton T-shirt', 'description' => 'Bright cotton t-shirt perfect for casual wear and fun in the sun.'],
                ['name' => 'Lightweight Running Shorts', 'description' => 'Lightweight running shorts designed for speed and comfort.'],
                ['name' => 'Warm Wool Sweater', 'description' => 'Warm wool sweater that keeps kids cozy during chilly days.'],
                ['name' => 'Casual Cotton Pants', 'description' => 'Casual cotton pants that are breathable and great for everyday wear.'],
                ['name' => 'Fun Printed Hoodie', 'description' => 'Fun printed hoodie featuring colorful designs that kids enjoy.'],
                ['name' => 'Soft Fleece Jacket', 'description' => 'Soft fleece jacket that provides warmth and comfort.'],
                ['name' => 'Durable Cotton Shorts', 'description' => 'Durable cotton shorts designed for active play and adventures.'],
                ['name' => 'Cozy Knit Sweater', 'description' => 'Cozy knit sweater perfect for layering during cold weather.'],
                ['name' => 'Light Cotton Tights', 'description' => 'Light cotton tights that keep legs warm and comfortable.'],
                ['name' => 'Bright Graphic Socks', 'description' => 'Bright graphic socks that add fun to any outfit.'],
                ['name' => 'Casual Denim Jeans', 'description' => 'Casual denim jeans made for durability and style.'],
                ['name' => 'Soft Cotton Hoodie', 'description' => 'Soft cotton hoodie great for chilly mornings and outdoor play.'],
                ['name' => 'Warm Fleece Pants', 'description' => 'Warm fleece pants that keep kids cozy and comfortable.'],
                ['name' => 'Striped Cotton Shirt', 'description' => 'Striped cotton shirt that is breathable and easy to wear.'],
                ['name' => 'Cozy Pajama Set', 'description' => 'Cozy pajama set designed for a restful night’s sleep.'],
                ['name' => 'Durable Canvas Sneakers', 'description' => 'Durable canvas sneakers perfect for everyday adventures.'],
                ['name' => 'Fun Graphic T-shirt', 'description' => 'Fun graphic t-shirt with playful prints kids love.'],
                ['name' => 'Light Cotton Dress', 'description' => 'Light cotton dress great for warm weather and comfort.'],
                ['name' => 'Warm Knit Gloves', 'description' => 'Warm knit gloves that keep hands protected from the cold.'],
                ['name' => 'Cozy Hooded Jacket', 'description' => 'Cozy hooded jacket perfect for layering and warmth.'],
                ['name' => 'Striped Cotton Leggings', 'description' => 'Striped cotton leggings that are stretchy and comfortable.'],
                ['name' => 'Durable Denim Overalls', 'description' => 'Durable denim overalls ideal for play and outdoor fun.'],
                ['name' => 'Soft Cotton Pajamas', 'description' => 'Soft cotton pajamas made for comfort and cozy nights.'],
                ['name' => 'Bright Cotton T-shirt', 'description' => 'Bright cotton t-shirt perfect for casual and active days.'],
                ['name' => 'Lightweight Running Shorts', 'description' => 'Lightweight running shorts designed for comfort and speed.'],
                ['name' => 'Warm Wool Sweater', 'description' => 'Warm wool sweater that keeps children cozy on cold days.'],
                ['name' => 'Casual Cotton Pants', 'description' => 'Casual cotton pants perfect for everyday comfort.'],
                ['name' => 'Fun Printed Hoodie', 'description' => 'Fun printed hoodie with colorful designs kids enjoy.'],
                ['name' => 'Soft Fleece Jacket', 'description' => 'Soft fleece jacket that offers warmth and comfort.'],
                ['name' => 'Durable Cotton Shorts', 'description' => 'Durable cotton shorts great for active kids.'],
                ['name' => 'Cozy Knit Sweater', 'description' => 'Cozy knit sweater perfect for cold weather layering.'],
                ['name' => 'Light Cotton Tights', 'description' => 'Light cotton tights that keep legs warm.'],
                ['name' => 'Bright Graphic Socks', 'description' => 'Bright graphic socks that add fun and color.'],
                ['name' => 'Casual Denim Jeans', 'description' => 'Casual denim jeans built for durability and style.'],
                ['name' => 'Soft Cotton Hoodie', 'description' => 'Soft cotton hoodie ideal for chilly days.'],
                ['name' => 'Warm Fleece Pants', 'description' => 'Warm fleece pants for comfort and warmth.'],
                ['name' => 'Striped Cotton Shirt', 'description' => 'Striped cotton shirt breathable and stylish.'],
                ['name' => 'Cozy Pajama Set', 'description' => 'Cozy pajama set perfect for bedtime.'],
                ['name' => 'Durable Canvas Sneakers', 'description' => 'Durable canvas sneakers for everyday wear.'],
                ['name' => 'Fun Graphic T-shirt', 'description' => 'Fun graphic t-shirt with playful designs.'],
                ['name' => 'Light Cotton Dress', 'description' => 'Light cotton dress for warm weather comfort.'],
                ['name' => 'Warm Knit Gloves', 'description' => 'Warm knit gloves to keep hands cozy.'],
                ['name' => 'Cozy Hooded Jacket', 'description' => 'Cozy hooded jacket for warmth and style.'],
                ['name' => 'Striped Cotton Leggings', 'description' => 'Striped cotton leggings stretchy and comfortable.'],
                ['name' => 'Durable Denim Overalls', 'description' => 'Durable denim overalls for outdoor fun.'],
                ['name' => 'Soft Cotton Pajamas', 'description' => 'Soft cotton pajamas for a restful night’s sleep.'],
                ['name' => 'Bright Cotton T-shirt', 'description' => 'Bright cotton t-shirt perfect for casual wear.'],
                ['name' => 'Lightweight Running Shorts', 'description' => 'Lightweight running shorts designed for comfort and speed.'],
                ['name' => 'Warm Wool Sweater', 'description' => 'Warm wool sweater that keeps kids cozy during chilly days.'],
                ['name' => 'Casual Cotton Pants', 'description' => 'Casual cotton pants that are breathable and great for everyday wear.'],
                ['name' => 'Fun Printed Hoodie', 'description' => 'Fun printed hoodie featuring colorful designs that kids enjoy.'],
                ['name' => 'Soft Fleece Jacket', 'description' => 'Soft fleece jacket that provides warmth and comfort.'],
                ['name' => 'Durable Cotton Shorts', 'description' => 'Durable cotton shorts designed for active play and adventures.'],
                ['name' => 'Cozy Knit Sweater', 'description' => 'Cozy knit sweater perfect for layering during cold weather.'],
                ['name' => 'Light Cotton Tights', 'description' => 'Light cotton tights that keep legs warm and comfortable.'],
                ['name' => 'Bright Graphic Socks', 'description' => 'Bright graphic socks that add fun to any outfit.'],
                ['name' => 'Casual Denim Jeans', 'description' => 'Casual denim jeans made for durability and style.'],
                ['name' => 'Soft Cotton Hoodie', 'description' => 'Soft cotton hoodie great for chilly mornings and outdoor play.'],
                ['name' => 'Warm Fleece Pants', 'description' => 'Warm fleece pants that keep kids cozy and comfortable during colder days.'],
                ['name' => 'Striped Cotton Shirt', 'description' => 'Striped cotton shirt that is breathable and easy to wear for everyday activities.'],
                ['name' => 'Cozy Pajama Set', 'description' => 'Cozy pajama set designed for a restful night’s sleep with soft fabric and fun prints.'],
                ['name' => 'Durable Canvas Sneakers', 'description' => 'Durable canvas sneakers perfect for everyday adventures and playtime.'],
                ['name' => 'Fun Graphic T-shirt', 'description' => 'Fun graphic t-shirt with playful prints that    kids love to wear.'],
                ['name' => 'Light Cotton Dress', 'description' => 'Light cotton dress great for warm weather and comfort, perfect for casual outings.'],
                ['name' => 'Warm Knit Gloves', 'description' => 'Warm knit gloves that keep little hands cozy during cold weather.'],
                ['name' => 'Cozy Hooded Jacket', 'description' => 'Cozy hooded jacket perfect for layering and warmth during chilly days.'],
                ['name' => 'Striped Cotton Leggings', 'description' => 'Striped cotton leggings that are stretchy and comfortable for active kids.'],
                ['name' => 'Durable Denim Overalls', 'description' => 'Durable denim overalls ideal for play and outdoor fun, built to last.'],
                ['name' => 'Soft Cotton Pajamas', 'description' => 'Soft cotton pajamas made for comfort and cozy nights, ensuring sweet dreams.'],
                ['name' => 'Bright Cotton T-shirt', 'description' => 'Bright cotton t-shirt perfect for casual and active days, adding a pop of color.'],
                ['name' => 'Lightweight Running Shorts', 'description' => 'Lightweight running shorts designed for comfort and speed during sports activities.'],
                ['name' => 'Warm Wool Sweater', 'description' => 'Warm wool sweater that keeps children cozy on cold days, ideal for layering.'],
                ['name' => 'Casual Cotton Pants', 'description' => 'Casual cotton pants perfect for everyday comfort, breathable and easy to wear.'],
                ['name' => 'Fun Printed Hoodie', 'description' => 'Fun printed hoodie with colorful designs that kids enjoy wearing on casual outings.'],
                ['name' => 'Soft Fleece Jacket', 'description' => 'Soft fleece jacket that offers warmth and comfort, great for outdoor adventures.'],
                ['name' => 'Durable Cotton Shorts', 'description' => 'Durable cotton shorts great for active kids who love to run and play outdoors.'],
                ['name' => 'Cozy Knit Sweater', 'description' => 'Cozy knit sweater perfect for cold weather layering, providing warmth without bulk.'],
                ['name' => 'Light Cotton Tights', 'description' => 'Light cotton tights that keep legs warm while allowing freedom of movement.'],
                ['name' => 'Bright Graphic Socks', 'description' => 'Bright graphic socks that add fun and color to any outfit, making them a favorite among kids.'],
                ['name' => 'Casual Denim Jeans', 'description' => 'Casual denim jeans built for durability and style, perfect for everyday wear.'],
                ['name' => 'Soft Cotton Hoodie', 'description' => 'Soft cotton hoodie ideal for chilly days, providing comfort and warmth.'],
                ['name' => 'Warm Fleece Pants', 'description' => 'Warm fleece pants for comfort and warmth, great for lounging or outdoor play.'],
                ['name' => 'Striped Cotton Shirt', 'description' => 'Striped cotton shirt that is breathable and stylish, perfect for casual outings.'],
                ['name' => 'Cozy Pajama Set', 'description' => 'Cozy pajama set perfect for bedtime, made with soft fabric for a restful night’s sleep.'],
                ['name' => 'Durable Canvas Sneakers', 'description' => 'Durable canvas sneakers for everyday wear, designed to withstand active play.'],
                ['name' => 'Fun Graphic T-shirt', 'description' => 'Fun graphic t-shirt with playful designs that kids love to wear on casual days.'],
                ['name' => 'Light Cotton Dress', 'description' => 'Light cotton dress great for warm weather comfort, perfect for casual outings.'],
                ['name' => 'Warm Knit Gloves', 'description' => 'Warm knit gloves to keep hands cozy during cold weather activities.'],
                ['name' => 'Cozy Hooded Jacket', 'description' => 'Cozy hooded jacket for warmth and style, ideal for layering in cooler months.'],
                ['name' => 'Striped Cotton Leggings', 'description' => 'Striped cotton leggings that are stretchy and comfortable, perfect for active kids.'],
                ['name' => 'Durable Denim Overalls', 'description' => 'Durable denim overalls ideal for outdoor fun and adventures, built to last.'],
                ['name' => 'Soft Cotton Pajamas', 'description' => 'Soft cotton pajamas made for comfort and cozy nights, ensuring sweet dreams.'],
                ['name' => 'Bright Cotton T-shirt', 'description' => 'Bright cotton t-shirt perfect for casual wear and active days, adding a pop of color.'],
                ['name' => 'Lightweight Running Shorts', 'description' => 'Lightweight running shorts designed for comfort and speed during sports activities.'],
                ['name' => 'Warm Wool Sweater', 'description' => 'Warm wool sweater that keeps kids cozy during chilly days, ideal for layering.'],
                ['name' => 'Casual Cotton Pants', 'description' => 'Casual cotton pants that are breathable and great for everyday wear, providing comfort and style.'],
                ['name' => 'Fun Printed Hoodie', 'description' => 'Fun printed Hoodie with colorful designs that kids enjoy wearing on casual outings.'],
                ['name' => 'Soft Fleece Jacket', 'description' => 'Soft fleece jacket that offers warmth and comfort, great for outdoor adventures.'],
                ['name' => 'Durable Cotton Shorts', 'description' => 'Durable cotton shorts great for active kids who love to run and play outdoors.'],
                ['name' => 'Cozy Knit Sweater', 'description' => 'Cozy knit sweater perfect for cold weather layering, providing warmth without bulk.'],
                ['name' => 'Light Cotton Tights', 'description' => 'Light cotton tights that keep legs warm while allowing freedom of movement.'],
                ['name' => 'Bright Graphic Socks', 'description' => 'Bright graphic socks that add fun and color to any outfit, making them a favorite among kids.'],
                ['name' => 'Casual Denim Jeans', 'description' => 'Casual denim jeans built for durability and style, perfect for everyday wear.'],
                ['name' => 'Soft Cotton Hoodie', 'description' => 'Soft cotton hoodie ideal for chilly days, providing comfort and warmth.'],
                ['name' => 'Warm Fleece Pants', 'description' => 'Warm fleece pants for comfort and warmth, great for lounging or outdoor play.'],
                ['name' => 'Striped Cotton Shirt', 'description' => 'Striped cotton shirt that is breathable and stylish, perfect for casual outings.'],
                ['name' => 'Cozy Pajama Set', 'description' => 'Cozy pajama set perfect for bedtime, made with soft fabric for a restful night’s sleep.'],
                ['name' => 'Durable Canvas Sneakers', 'description' => 'Durable canvas sneakers for everyday wear, designed to withstand active play.'],
                ['name' => 'Fun Graphic T-shirt', 'description' => 'Fun graphic t-shirt with playful designs that kids love to wear on casual days.'],
                ['name' => 'Light Cotton Dress', 'description' => 'Light cotton dress great for warm weather comfort, perfect for casual outings.'],
                ['name' => 'Warm Knit Gloves', 'description' => 'Warm knit gloves to keep hands cozy during cold weather activities.'],
                ['name' => 'Cozy Hooded Jacket', 'description' => 'Cozy hooded jacket for warmth and style, ideal for layering in cooler months.'],
                ['name' => 'Striped Cotton Leggings', 'description' => 'Striped cotton leggings that are stretchy and comfortable, perfect for active kids.'],
                ['name' => 'Durable Denim Overalls', 'description' => 'Durable denim overalls ideal for outdoor fun and adventures, built to last.'],
                ['name' => 'Soft Cotton Pajamas', 'description' => 'Soft cotton pajamas made for comfort and cozy nights, ensuring sweet dreams.'],
                ['name' => 'Bright Cotton T-shirt', 'description' => 'Bright cotton t-shirt perfect for casual wear and active days, adding a pop of color.'],
                ['name' => 'Lightweight Running Shorts', 'description' => 'Lightweight running shorts designed for comfort and speed during sports activities.'],
                ['name' => 'Warm Wool Sweater', 'description' => 'Warm wool sweater that keeps kids cozy during chilly days, ideal for layering.'],
                ['name' => 'Casual Cotton Pants', 'description' => 'Casual cotton pants that are breathable and great for everyday wear, providing comfort and style.'],
                ['name' => 'Fun Printed Hoodie', 'description' => 'Fun printed hoodie with colorful designs that kids enjoy wearing on casual outings.'],
                ['name' => 'Soft Fleece Jacket', 'description' => 'Soft fleece jacket that offers warmth and comfort, great for outdoor adventures.'],
                ['name' => 'Durable Cotton Shorts', 'description' => 'Durable cotton shorts great for active kids who love to run and play outdoors.'],
                ['name' => 'Cozy Knit Sweater', 'description' => 'Cozy knit sweater perfect for cold weather layering, providing warmth without bulk.'],
                ['name' => 'Light Cotton Tights', 'description' => 'Light cotton tights that keep legs warm while allowing freedom of movement.'],
                ['name' => 'Bright Graphic Socks', 'description' => 'Bright graphic socks that add fun and color to any outfit, making them a favorite among kids.'],
                ['name' => 'Casual Denim Jeans', 'description' => 'Casual denim jeans built for durability and style, perfect for everyday wear.'],
                ['name' => 'Soft Cotton Hoodie', 'description' => 'Soft cotton hoodie ideal for chilly days, providing comfort and warmth.'],
                ['name' => 'Warm Fleece Pants', 'description' => 'Warm fleece pants for comfort and warmth, great for lounging or outdoor play.'],
            ]
        );
            
        // seeding products with specific names and descriptions
        Product::factory()
            ->count(count($nameNDescs))
            ->state(new Sequence(...$nameNDescs)) // assigns the first product the first name/description, second product the second, etc.
            ->create();

        // setting 4 random active products to be shown on homepage
        Product::where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->update(['homepage_show' => true]);

        // seeding products with random sizes
        // all products will have at least one size
        Product::all()->each(function ($product) {
            $sizes = Size::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $product->sizes()->attach($sizes);
        });

        // seeding products with random colors
        // all products will have at least one color
        Product::all()->each(function ($product) {
            $colors = Color::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $product->colors()->attach($colors);
        });

        // seeding products with random deals
        Product::all()->each(function ($product) {
            $deals = Deal::inRandomOrder()->take(rand(0, 2))->pluck('id');
            $product->deals()->attach($deals);
        });

        // seeding products with random seasons
        Product::all()->each(function ($product) {
            $seasons = Season::inRandomOrder()->take(rand(0, 2))->pluck('id');
            $product->seasons()->attach($seasons);
        });
    }
}
