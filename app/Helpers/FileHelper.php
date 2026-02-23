<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('file_url')) {
    function file_url($path, $minutes = 60)
    {
        if (!$path) {
            return null;
        }

        try {
            return Storage::disk('s3')
                ->temporaryUrl($path, now()->addMinutes($minutes));
        } catch (\Exception $e) {
            return null;
        }
    }
}