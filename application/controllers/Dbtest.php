<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbtest extends CI_Controller {
    public function index() {
        header('Content-Type: application/json');
        
        $secret_key = getenv('XENDIT_SECRET_KEY') ?: $_ENV['XENDIT_SECRET_KEY'] ?? '';
        $key_status = empty($secret_key) ? 'empty' : 'exists (length: ' . strlen($secret_key) . ')';

        $url = 'https://api.xendit.co/v2/invoices';
        $payload = [
            'external_id' => 'TEST-' . time(),
            'amount' => 10000,
            'description' => 'Test Invoice MariMatcha',
            'success_redirect_url' => base_url(),
            'failure_redirect_url' => base_url()
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($secret_key . ':')
        ]);
        
        // Temporarily disable SSL verification to check if it's the issue
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $curl_error = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo json_encode([
            'xendit_key_status' => $key_status,
            'http_code' => $http_code,
            'curl_error' => $curl_error,
            'response' => json_decode($response, true) ?: $response
        ]);
    }
}
