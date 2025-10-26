<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AiStylistController extends Controller
{
    /**
     * Handle face image upload and return stub AI outfit recommendations.
     */
    public function recommend(Request $request)
    {
        $validated = $request->validate([
            'face' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $path = $request->file('face')->store('public/ai/faces');
        $url = Storage::url($path);

        // Stubbed AI output. Replace later by calling a real AI service.
        $suggestions = [
            [
                'title' => 'Minimalist Monochrome',
                'category' => 'Womenswear',
                'fit' => 'Slim fit blazer + straight trousers',
                'price' => 129.99,
                'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1600&auto=format&fit=crop',
            ],
            [
                'title' => 'Weekend Casual',
                'category' => 'Menswear',
                'fit' => 'Denim jacket + tee + chinos',
                'price' => 89.99,
                'image' => 'https://images.unsplash.com/photo-1503342452485-86ff0a4b0674?q=80&w=1600&auto=format&fit=crop',
            ],
            [
                'title' => 'Summer Breeze',
                'category' => 'Womenswear',
                'fit' => 'Linen dress + straw hat',
                'price' => 74.50,
                'image' => 'https://images.unsplash.com/photo-1520975682031-137a6c5a7831?q=80&w=1600&auto=format&fit=crop',
            ],
        ];

        return back()->with([
            'ai_recommendation' => [
                'face' => $url,
                'items' => $suggestions,
            ],
            'status' => 'AI recommendations are ready.',
        ]);
    }
}
