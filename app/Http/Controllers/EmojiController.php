<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmojiService;

class EmojiController extends Controller
{
    public function getCategories()
    {
        return response()->json([
            'categories' => EmojiService::getCategories()
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q', '');
        
        return response()->json([
            'emojis' => EmojiService::search($keyword)
        ]);
    }

    public function getPopular()
    {
        return response()->json([
            'emojis' => EmojiService::getPopular()
        ]);
    }
}