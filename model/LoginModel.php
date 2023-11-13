<?php

class LoginModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function cek_valid($data) {
        $p_username = $data['username'];
        $p_password = $data['password'];

        $is_valid = $this->db->db()->query("SELECT cekLoginPegawai('$p_username', '$p_password') AS cekLoginPegawai")->fetch_assoc();

        return $is_valid['cekLoginPegawai'];
    }

    public function get_user_credential($username) {
        $user = $this->db->db()->query("SELECT id_pegawai, username, isOwner FROM pegawai WHERE username = '$username'")->fetch_assoc();

        return $user;
    }
}