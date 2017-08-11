<?php

class Upload extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper(array('form', 'url'));

    }

    public function index()
    {
        //Empty
    }


    public function do_upload()
    {
        $beachid = $_SESSION['usr_bid'];

        $config['upload_path'] = './assets/profile_pics/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2000';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors(), 'path' => $config['upload_path']);

            print_r($error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            $_SESSION['img_path'] = $upload_data['file_path'] . $file_name;
            $_SESSION['img_file'] = $file_name;
            echo base_url() . 'assets/profile_pics/' . $file_name;


        }
    }
}
