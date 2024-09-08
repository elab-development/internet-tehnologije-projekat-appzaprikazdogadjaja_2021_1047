<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Location;
use App\Models\Category;
use App\Models\Reference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = [
            "https://bgdmarathon.org/wp-content/uploads/2023/03/LiveProduction3BgMaratonHajlajt-5-scaled.jpg",
            "https://www.serbian-metal.org/images/2023/10/rammstein-bina.jpg",
            "https://n1info.rs/wp-content/uploads/2021/08/10/1628632409-Tan2021-8-10_224655371_0-750x500.jpg",
            "https://cdn.apollo.audio/one/media/6143/5c47/4699/e084/4af2/94a1/ed-sheeran-2022-tour.jpg?quality=80&format=jpg&crop=0,0,843,1500&resize=crop",
            "https://goout.rs/_next/image/?url=https%3A%2F%2Ffirebasestorage.googleapis.com%2Fv0%2Fb%2Fsakimizaci-android.appspot.com%2Fo%2Fhost_main_photos%252FLokali%2B2%2B%252826%2529.jpg%3Falt%3Dmedia&w=828&q=75",
        ];
    
        
        $imageCount = count($images);
    
        static $currentIndex = 0;
    
        $selectedImage = $images[$currentIndex];
    
        $currentIndex = ($currentIndex + 1) % $imageCount;
    
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->dateTimeBetween('-1 months', '+1 months'),
            'end_date' => $this->faker->dateTimeBetween('now', '+2 months'),
            'location_id' => Location::factory(),
            'category_id' => Category::factory(),
            'reference_id' => Reference::factory(),
            'url' => $this->faker->url,
            'image' => $selectedImage,
        ];
    }
}
