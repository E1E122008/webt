<?php

namespace App\Helpers;

use App\Models\Settings;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    /**
     * Get setting value by key with caching
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("website_settings.{$key}", 3600, function () use ($key, $default) {
            $settings = Settings::first();
            return $settings ? $settings->$key : $default;
        });
    }

    /**
     * Get all settings with caching
     */
    public static function getAll()
    {
        return Cache::remember('website_settings', 3600, function () {
            $settings = Settings::first();
            
            if (!$settings) {
                // Return default values if no settings exist
                return [
                    'village_name' => 'Desa Tetembomua',
                    'village_head' => 'Abdullah, SP',
                    'term_period' => '2024 - Sekarang',
                    'district' => 'Lambuya',
                    'regency' => 'Konawe',
                    'province' => 'Sulawesi Tenggara',
                    'area' => '10.54 km²',
                    'north_boundary' => 'Kecamatan Onembute',
                    'east_boundary' => 'Kecamatan Onembute',
                    'south_boundary' => 'Desa Wonua Hoa dan Asaki',
                    'west_boundary' => 'Desa Amberi',
                    'village_description' => 'Desa yang maju dan berbudaya dengan masyarakat yang ramah, produktif, dan komitmen untuk mengembangkan desa secara berkelanjutan',
                    'contact_phone' => '+62 812-3456-7890',
                    'contact_email' => 'info@desatetembomua.id',
                    'contact_address' => 'Desa Tetembomua, Kecamatan Lambuya, Kabupaten Konawe, Sulawesi Tenggara',
                    'social_media' => [
                        'facebook' => 'https://facebook.com/desatetembomua',
                        'facebook_handle' => 'DesaTetembomua',
                        'instagram' => 'https://instagram.com/desatetembomua',
                        'instagram_handle' => 'desa_tetembomua',
                        'youtube' => 'https://youtube.com/@desatetembomua',
                        'youtube_handle' => 'Desa Tetembomua',
                        'whatsapp' => 'https://wa.me/6281234567890',
                        'whatsapp_number' => '+62 812-3456-7890',
                        'tiktok' => 'https://tiktok.com/@desatetembomua',
                        'tiktok_handle' => 'desatetembomua'
                    ],
                    'website_status' => true,
                    'maintenance_mode' => false
                ];
            }

            return $settings->toArray();
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        Cache::forget('website_settings');
        
        // Clear individual key caches
        $keys = [
            'village_name', 'village_head', 'term_period',
            'district', 'regency', 'province', 'area',
            'north_boundary', 'east_boundary', 'south_boundary', 'west_boundary',
            'village_description', 'contact_phone', 'contact_email', 'contact_address',
            'social_media', 'website_status', 'maintenance_mode'
        ];

        foreach ($keys as $key) {
            Cache::forget("website_settings.{$key}");
        }
    }

    /**
     * Check if website is in maintenance mode
     */
    public static function isMaintenanceMode()
    {
        return self::get('maintenance_mode', false);
    }

    /**
     * Check if website is active
     */
    public static function isWebsiteActive()
    {
        return self::get('website_status', true);
    }
}
