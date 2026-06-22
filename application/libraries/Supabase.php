<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supabase {

    protected $url;
    protected $key;

    public function __construct()
    {
        $this->url = getenv('NEXT_PUBLIC_SUPABASE_URL') ?: 'https://bowoobqjaaajuthccsrm.supabase.co';
        $this->key = getenv('NEXT_PUBLIC_SUPABASE_PUBLISHABLE_KEY') ?: 'sb_publishable_OHZmdTt5jRTfUOWjHPKXyw_4UXwELIN';
    }

    /**
     * Upload a local file to Supabase Storage bucket.
     *
     * @param string $local_path Absolute path to local file.
     * @param string $filename Name of the file on Supabase.
     * @param string $folder Sub-folder path inside the bucket.
     * @param string $bucket Name of the bucket.
     * @return bool
     */
    public function upload($local_path, $filename, $folder = 'uploads', $bucket = 'macha')
    {
        if (!file_exists($local_path)) {
            log_message('error', 'Supabase Upload: File does not exist at ' . $local_path);
            return FALSE;
        }

        $file_data = file_get_contents($local_path);
        if ($file_data === FALSE) {
            log_message('error', 'Supabase Upload: Cannot read file contents of ' . $local_path);
            return FALSE;
        }

        $mime_type = 'application/octet-stream';
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $local_path);
            finfo_close($finfo);
        }

        $upload_url = rtrim($this->url, '/') . '/storage/v1/object/' . $bucket . '/' . $folder . '/' . $filename;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $upload_url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'apikey: ' . $this->key,
            'Authorization: Bearer ' . $this->key,
            'Content-Type: ' . $mime_type,
            'x-upsert: true'
        ));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            return TRUE;
        }

        log_message('error', 'Supabase Upload: Failed with status ' . $http_code . '. Response: ' . $response);
        return FALSE;
    }
}
