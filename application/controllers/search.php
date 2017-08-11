<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller
{

    /**
     * @author: Ed Lara
     * Initial Home page view for application
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->model('search_model');
        $this->load->helper('url');
        $this->load->helper('form');

    }

    public function index()
    {
        
        //
        $data['division'] = $this->search_model->getDivisionData();
        //$data['expert'] = $this->search_model->get_list_items();

        $this->load->view('template/header');
        $this->load->view('search', $data);

        $this->load->view('template/footer');

    }

    public function search_experts()
    {

        $this->load->model('search_model');

        $data = $this->search_model->search_users();
        $this->load->view('details.php');
    }
    public function get_departments()
    {   $this->load->helper('url');
        $this->load->helper('form');


        $div = $this->input->post('divs');
        $this->load->model('search_model');
        $data['deps'] = $this->search_model->get_local_depts($div);

    }
    public function get_details()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $id =  $this->input->post('id');
        $this->load->model('search_model');
        $data['dets'] = $this->search_model->getdetails($id);

    }
}