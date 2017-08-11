<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_utility extends CI_Controller
{
	/**
     * @author: Ed Lara
     * Initial Home page view for application
     */

    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        
        
    }

public function reset()
    {
        if (isset($_SESSION['usr_type'])){
        unset ($_SESSION['usr_type']);
        $usertype = 'approver';
        $_SESSION['usr_type'] = $usertype;
        $data['user'] = $usertype;

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation');
        $this->load->view('template/admin/dashboard_approver',$data);
        $this->load->view('includes/footer');
    }
}

}