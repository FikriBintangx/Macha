<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('base_url'))
{
    function base_url($uri = '', $protocol = NULL)
    {
        $is_vercel = (getenv('VERCEL') !== false || isset($_SERVER['VERCEL']) || !is_writable(APPPATH));
        
        if ($is_vercel && !empty($uri)) {
            $uri_str = is_array($uri) ? implode('/', $uri) : (string) $uri;
            $uri_str = ltrim($uri_str, '/');
            
            if (strpos($uri_str, 'uploads/') === 0) {
                $supabase_url = getenv('NEXT_PUBLIC_SUPABASE_URL') ?: 'https://bowoobqjaaajuthccsrm.supabase.co';
                $bucket = 'macha';
                return rtrim($supabase_url, '/') . '/storage/v1/object/public/' . $bucket . '/' . $uri_str;
            }
        }
        
        return get_instance()->config->base_url($uri, $protocol);
    }
}
