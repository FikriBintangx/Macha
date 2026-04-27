<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeGateway {

    public function check_visit() {
        $CI =& get_instance();
        $class = strtolower($CI->router->fetch_class());
        $method = strtolower($CI->router->fetch_method());
        
        if (is_cli()) return;

        // Jika sedang mengakses home/index (halaman muka awal) diizinkan bebas
        if ($class === 'home' && $method === 'index') {
            return;
        }

        // Ambil jejak halaman sebelumnya (HTTP REFERER)
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

        // Jika referer KOSONG, artinya URL diketik langsung pake keyboard / di-copy-paste!
        // if (empty($referer)) {
        //     redirect(base_url('home'));
        // }
    }

}
