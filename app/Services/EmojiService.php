<?php

namespace App\Services;

class EmojiService
{
    /**
     * Get all emoji categories
     */
    public static function getCategories()
    {
        return config('emojis.categories');
    }

    /**
     * Get emojis by category
     */
    public static function getByCategory(string $category)
    {
        return config("emojis.categories.{$category}.emojis", []);
    }

    /**
     * Search emojis by keyword
     */
    public static function search(string $keyword)
    {
        $keyword = strtolower($keyword);
        
        $keywords = [
            'happy' => ['😀', '😃', '😄', '😁', '😊', '🙂', '😍', '🥰'],
            'sad' => ['😢', '😭', '😞', '😔', '😟', '🙁', '☹️'],
            'love' => ['❤️', '💕', '💖', '💗', '💓', '💞', '💝', '😍', '🥰'],
            'angry' => ['😠', '😡', '🤬', '😤', '💢'],
            'laugh' => ['😂', '🤣', '😆', '😄', '😁'],
            'heart' => ['❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎'],
            'fire' => ['🔥', '💥', '⚡', '✨'],
            'thumbs' => ['👍', '👎', '👌'],
            'hand' => ['👋', '🤚', '🖐️', '✋', '👏', '🙌'],
            'food' => ['🍎', '🍕', '🍔', '🍟', '🍰', '🎂', '🍪'],
            'animal' => ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼'],
        ];

        return $keywords[$keyword] ?? self::getPopular();
    }

    /**
     * Get popular emojis
     */
    public static function getPopular()
    {
        return [
            '😀', '😂', '❤️', '😍', '👍', '🔥', '😊', '😭',
            '🙏', '😘', '💕', '😩', '👌', '😁', '💯', '🎉',
            '💪', '✨', '🤔', '😎', '🙄', '💖', '🤗', '😴'
        ];
    }
}