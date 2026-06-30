<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('base_url'))
{
    function base_url($uri = '', $protocol = NULL)
    {
        if (!empty($uri)) {
            $uri_str = is_array($uri) ? implode('/', $uri) : (string) $uri;
            $uri_str = ltrim($uri_str, '/');
            
            if (strpos($uri_str, 'uploads/') === 0) {
                $filename = basename($uri_str);
                if (!empty($filename) && file_exists(FCPATH . 'assets/img/' . $filename)) {
                    return get_instance()->config->base_url('assets/img/' . $filename, $protocol);
                }
            }
        }
        
        return get_instance()->config->base_url($uri, $protocol);
    }
}
