<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploads extends CI_Controller {

    public function serve($filename = NULL)
    {
        echo "SERVE_CALLED_WITH:" . $filename; exit;
        if (empty($filename)) {
            show_404();
        }

        $is_vercel = (getenv('VERCEL') !== false || isset($_SERVER['VERCEL']) || !is_writable(APPPATH));

        // If not on Vercel and file exists locally (e.g. during local development)
        if (!$is_vercel) {
            $local_path = FCPATH . 'uploads/' . $filename;
            if (file_exists($local_path) && is_file($local_path)) {
                $this->load->helper('file');
                $mime = get_mime_by_extension($local_path) ?: 'application/octet-stream';
                header("Content-Type: " . $mime);
                readfile($local_path);
                exit;
            }
        }

        // If file does not exist locally (e.g. on Vercel), redirect to Supabase Storage
        $supabase_url = getenv('NEXT_PUBLIC_SUPABASE_URL') ?: 'https://bowoobqjaaajuthccsrm.supabase.co';
        $bucket = 'macha';
        
        $redirect_url = rtrim($supabase_url, '/') . '/storage/v1/object/public/' . $bucket . '/uploads/' . $filename;
        
        $this->load->helper('url');
        redirect($redirect_url, 'location', 302);
    }
}
