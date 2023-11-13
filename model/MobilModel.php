<?php

class MobilModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function get_jenis_mobil() {
        $result = $this->db->db()->query("SELECT jenis FROM jenis_mobil");

        return $result;
    }

    public function get_jumlah_jenis_mobil($param) {
        $result = $this->db->db()->query("SELECT COUNT(*) AS HITUNG FROM view_mobil_" . $param);

        return $result->fetch_row();
    }

    public function get_jumlah_jenis_mobil_tranversal(int $choice) {
        $jenis = $this->get_jenis_mobil();

        $jenisName = array();
        $jenisQtty = array();
        while ($row = $jenis->fetch_assoc()) {
            $jenisName[] = $row['jenis']; 
            $res = $this->get_jumlah_jenis_mobil($row['jenis']);
            $jenisQtty[] = $res[0];
        }

        return $choice == 0 ? $jenisName : $jenisQtty;
    }

    public function get_jumlah_mobil_tersedia() {
        $result = $this->db->db()->query("SELECT COUNT(*) AS HITUNG FROM view_mobil_tersedia")->fetch_row();

        return $result[0];
    }

    public function get_jumlah_mobil_sedang_dipakai() {
        $result = $this->db->db()->query("SELECT COUNT(*) AS HITUNG FROM view_mobil_sedang_dipakai")->fetch_row();

        return $result[0];
    }

    public function get_semua_mobil() {
        $result = $this->db->db()->query("SELECT * FROM view_semua_mobil");

        return $result->fetch_all();
    }

    public function cari_mobil($searchParam) {
        $result = $this->db->db()->query("SELECT M.id_mobil, M.nama_mobil, M.tahun, M.transmisi, M.plat_nomor, JM.jenis, M.kapasitas_penumpang, M.harga_sewa, M.status
                                            FROM mobil M
                                            INNER JOIN jenis_mobil JM ON M.id_jenis = JM.id_jenis
                                            WHERE M.nama_mobil LIKE CONCAT('%', '$searchParam', '%')
                                            OR M.plat_nomor LIKE CONCAT('%', '$searchParam', '%')
                                            OR M.tahun LIKE CONCAT('%', '$searchParam', '%')
                                            ORDER BY M.id_mobil"
                                        );
        
        return $result->fetch_all();
    }

    public function tambah_mobil($data) {
        $namaMobil = $data['nama_mobil'];
        $tahun = $data['tahun'];
        $transmisi = $data['transmisi'];
        $platNomor = $data['plat_nomor'];
        $jenisMobil = $data['jenis_mobil'];
        $kapasitasPenumpang = $data['kapasitas_pnp'];
        $hargaSewa = $data['harga_sewa'];
        $status = $data['status_mobil'];

        $result = $this->db->db()->query("CALL TambahMobilBaru('$namaMobil', '$tahun', '$platNomor', '$jenisMobil', '$kapasitasPenumpang', '$hargaSewa', '-', '$status', '$transmisi')");
        // $result = true;
        return $result ?? false;
    }

    public function detail_mobil($id_mobil) {
        $out = array();

        $out['data_detail_mobil'] = $this->db->db()->query("SELECT * FROM mobil WHERE id_mobil = '$id_mobil'")->fetch_assoc();
        $out['diorder_brp_kali'] = $this->db->db()->query("SELECT getCountOrderMobil ('$id_mobil') as HITUNG")->fetch_assoc();

        return $out;
    }

    public function get_specific_mobil($id_mobil) {
        $result = $this->db->db()->query("CALL ShowMobilByID('$id_mobil')");

        return $result->fetch_row();
    }

    public function update_mobil($id_mobil_to_edit, $namaMobil, $tahun, $transmisi, $platNomor, $jenisMobil, $kapasitasPenumpang, $hargaSewa, $status) {
        $result = $this->db->db()->query("CALL UpdateDataMobil ('$id_mobil_to_edit', '$namaMobil', '$tahun', '$transmisi', '$platNomor', '$jenisMobil', '$kapasitasPenumpang', '$hargaSewa', '$status')");
        // $result = true;
        return $result ?? false;
    }
}