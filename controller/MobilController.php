<?php

class MobilController extends Controller {
    public function __construct() {
        include_once("./model/MobilModel.php");
    }

    public function home_graph() {
        $model = new MobilModel();

        $data = array();
        $data['jenis'] = $model->get_jumlah_jenis_mobil_tranversal(0);
        $data['countJenis'] = $model->get_jumlah_jenis_mobil_tranversal(1);
        $data['countMobilReady'] = $model->get_jumlah_mobil_tersedia();
        $data['countMobilNotReady'] = $model->get_jumlah_mobil_sedang_dipakai();

        $this->view("home/index", $data);
    }

    public function index() {
        $model = new MobilModel();

        $data['pageTitle'] = "Daftar Mobil";
        $data['semuaMobil'] = $model->get_semua_mobil();

        $this->view("templates/navbar", $data);
        $this->view("mobil/index", $data);
    }

    public function cari() {
        $model = new MobilModel();

        $search_param = $_GET['cari_mobil'];

        $data['pageTitle'] = "Pencarian '" . $search_param . "'";
        $data['semuaMobil'] = $model->cari_mobil($search_param);
        $data['searchParam'] = $search_param;

        $this->view("templates/navbar", $data);
        $this->view("mobil/index", $data);
    }

    public function tambah() {
        $model = new MobilModel();

        $result = $model->tambah_mobil($_POST);
        
        header("Location: " .base_url ."/mobil");
    }

    public function showDetail() {
        $model = new MobilModel();

        // $data = array();
        $data['pageTitle'] = "Daftar Mobil";
        $data['detail'] = $model->detail_mobil($_POST['manipulate_id_mobil']);
        // $data['semuaMobil'] = $model->get_semua_mobil();

        return $data;
    }
    
    public function show_mobil_prop_to_edit() {
        $model = new MobilModel();

        $dataEditMobil = $model->get_specific_mobil($_POST['manipulate_id_mobil']);

        return $dataEditMobil;
    }

    public function edit_then_update() {
        $namaMobil = $_POST['nama_mobil'];
        $tahun = $_POST['tahun'];
        $transmisi = $_POST['transmisi'];
        $platNomor = $_POST['plat_nomor'];
        $jenisMobil = $_POST['jenis_mobil'];
        $kapasitasPenumpang = $_POST['kapasitas_pnp'];
        $hargaSewa = $_POST['harga_sewa'];
        $status = $_POST['status_mobil'];

        $id_mobil_to_edit = $_POST['edit_id_mobil'];

        $model = new MobilModel();
        $result = $model->update_mobil($id_mobil_to_edit, $namaMobil, $tahun, $transmisi, $platNomor, $jenisMobil, $kapasitasPenumpang, $hargaSewa, $status);

        header("Location: " .base_url ."/mobil");
    }

    public function delete_confirm() {
        $model = new MobilModel();

        $result = $model->delete_mobil($_POST['manipulate_id_mobil']);

        header("Location: " .base_url ."/mobil");
    }
}