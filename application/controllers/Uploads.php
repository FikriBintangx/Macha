<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploads extends CI_Controller {

    public function serve() {
        // Get all URI segments after 'uploads'
        $segments = $this->uri->segments;
        // Shift 'uploads'
        array_shift($segments);
        $path = implode('/', $segments);
        $filename = basename($path);
        
        // 1. Check local static uploads (committed files)
        $local_path = FCPATH . 'uploads/' . $path;
        if (is_file($local_path) && file_exists($local_path)) {
            $this->_serve_file($local_path);
            return;
        }

        // 2. Check temporary directory (Vercel uploaded files)
        $temp_dir = is_dir('/tmp') ? '/tmp/' : sys_get_temp_dir() . DIRECTORY_SEPARATOR;
        $temp_path = $temp_dir . $filename;
        if (is_file($temp_path) && file_exists($temp_path)) {
            $this->_serve_file($temp_path);
            return;
        }

        show_404();
    }

    private function _serve_file($file_path) {
        $mime = $this->_get_mime_type($file_path);
        header("Content-Type: " . $mime);
        header("Content-Length: " . filesize($file_path));
        header("Cache-Control: public, max-age=86400"); // Cache for 1 day
        readfile($file_path);
        exit;
    }

    private function _get_mime_type($file_path) {
        if (function_exists('mime_content_type')) {
            return mime_content_type($file_path);
        }
        
        $ext = pathinfo($file_path, PATHINFO_EXTENSION);
        switch (strtolower($ext)) {
            case 'jpg':
            case 'jpeg':
                return 'image/jpeg';
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            case 'webp':
                return 'image/webp';
            case 'pdf':
                return 'application/pdf';
            default:
                return 'application/octet-stream';
        }
    }
}
