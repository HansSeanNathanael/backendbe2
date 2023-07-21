<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Categories;
use App\Models\ProductAssets;
use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $categories = [["Elektronik"], ["Fashion Pria"], ["Fashion Wanita"], ["Handphone & Tablet"], ["Olahraga"]];
        foreach($categories as $category) {
            $newData = new Categories([
                "name" => $category[0]
            ]);
            $newData->save();
        }

        $products = [
            [1, "Logitech H111 Headset Stereo Single Jack 3.5mm", "logitech-h111-headset-stereo-single-jack-3-5mm", 80000],
            [1, "Philips Rice Cooker - Inner Pot 2L Bakuhanseki - HD3110/33", "philips-rice-cooker -inner-pot-2l-bakuhanseki-hd3110-33", 249000],
            [4, "Iphone 12 64Gb/128Gb/256Gb Garansi Resmi IBOX/TAM - Hitam 64Gb", "iphone-12-64gb-128gb-256gb-garansi-resmi-ibox-tam-hitam-64gb", 11340000],
            [5, "Papan alat bantu Push Up Rack Board Fitness Workout Gym", "papan-alat-bantu-push-up-rack-board-fitness-workout-gym", 90000],
            [2, "Jim Joker - Sandal Slide Kulit Pria Bold 2S Hitam - Hitam", "jim-joker-sandal-slide-kulit-pria-bold-2s-hitam-hitam", 305000]
        ];
        foreach($products as $product) {
            $newData = new Products([
                "category_id" => $product[0],
                "name" => $product[1],
                "slug" => $product[2],
                "price" => $product[3],
            ]);
            $newData->save();
        }

        $productAssets = [
            [1, "logitech-h111.png"],
            [1, "logitech-h111-headset-stereo-single-jack-3-5mm.png"],
            [2, "philips-rice-cooker-inner-pot-2l-bakuhanseki-hd3110-33.png"],
            [2, "philips.png"],
            [2, "philips-rice-cooker.png"],
            [3, "iphone-12-64gb-128gb-256gb.png"],
            [4, "papan-alat-bantu-push-up.png"],
            [5, "jim-joker-sandal-slide-kulit-pria-bold-2s-hitam-hitam.png"]
        ];
        foreach($productAssets as $productAsset) {
            $newData = new ProductAssets([
                "product_id" => $productAsset[0],
                "image" => $productAsset[1]
            ]);
            $newData->save();
        }

        User::create([
            "name" => "admin",
            "password" => Hash::make("admin")
        ]);
    }
}
