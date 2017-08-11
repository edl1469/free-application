<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_seed extends CI_Controller
{
    public function __construct()
    {

        session_start();
        parent::__construct();
        if (!isset($_SESSION['usr_bid'])) {
            redirect('authenticate');
        }
        $this->load->helper('url');

        $this->load->model('seed_model', 'seed');
    }

    public function index()
    {
        $data = array();
        $bid = $_SESSION['usr_bid'];
        $data['divisions'] = $this->seed->SeedDivisions();
        $data['count'] = $this->uri->segment(3);
        $this->load->view('includes/header');
        $this->load->view('includes/admin/navigation');
        $this->load->view('template/admin/dashboard_seed',$data);
        
        $this->load->view('includes/footer');
    }
    public function upload(){


        $config['upload_path'] = './uploads/csv/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '2000';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);


        if (!$this->upload->do_upload('csvfile')) {
            $error = array('error' => $this->upload->display_errors(), 'path' => $config['upload_path']);

            print_r($error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            $_SESSION['img_path'] = $upload_data['file_path'] . $file_name;
            $_SESSION['img_file'] = $file_name;
            echo base_url() . 'uploads/csv/' . $file_name;

            $file_name = $upload_data['file_name'];
            $this->seed->seedUrls($file_name);
        }



    }

}
