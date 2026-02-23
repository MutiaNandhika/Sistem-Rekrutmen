<?php

if (!function_exists('file_url')) {
    function file_url($path)
    {
        if (!$path) {
            return null;
        }

        return url('file/' . ltrim($path, '/'));
    }
}