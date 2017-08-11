<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_approver extends CI_Controller
{

    /**
     * @author: Ed Lara
     * Initial Home page view for application
     */

    public function __construct()
    {

        session_start();
        parent::__construct();
        if(!isset($_SESSION['usr_bid']) || !isset($_SESSION['usr_type'])) {
            redirect('authenticate');
        }
        $this->load->model('approval_model', 'approve');
        $this->load->model('user_init_model', 'uinit');
        $this->load->helper('form');
    }

    public function index()
    {
        $bid = $_SESSION['usr_bid'];
        $data['displayname'] = $this->uinit->getusername($bid);
        $_SESSION['user-fname'] = $data['displayname'];
        $usertype = $_SESSION['usr_type'];
        $data['title'] = 'Expert Faculty Admin Panel';
        $data['approval'] = $this->approve->getAllRecords($usertype);
        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation');
        $this->load->view('template/admin/dashboard_approver',$data);
        $this->load->view('includes/footer');


    }
}
/* End of file dashboard_approver.php */
/* Location: ./application/controllers/dashboard_approver.php */
