<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    /**
     * @author: Ed Lara
     * Initial Home page view for application
     */

    public function __construct()
    {

        session_start();
        parent::__construct();
        if(!isset($_SESSION['usr_bid'])) {
            redirect('authenticate');
        }
        $this->load->helper('url');
        $this->load->model('authenticate_model', 'auth');
        $this->load->model('user_init_model', 'uinit');
    }

    public function index()
    {   $bid = $_SESSION['usr_bid'];

        $data['title'] = '- Dashboard';
        $data['displayname'] = $this->uinit->getusername($bid);
        $_SESSION['user-fname'] = $data['displayname'];
        $data['records'] = $this->uinit->getuserdata($bid);
        $data['image'] = $this->uinit->getuserimage($bid);
        $data['rscacontent'] = $this->uinit->getrscacontent($bid);
        $usertype = $this->uinit->setusertype($bid);
        if (!isset($_SESSION['prev_usr'])){
            $_SESSION['usr_type'] = 'user';
        }
        else{
            $_SESSION['usr_type'] = $usertype;
        }
        
        //$_SESSION['update'] = false;
        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation');
        switch($usertype){
            case "user":
                $userview = 'dashboard';
                break;
            case "approver":
                $userview = 'dashboard_approver';
                break;
            case "admin":
                $userview = 'dashboard_admin';
                break;
            case "seeder":
                $userview = 'dashboard_seed';
                break;
            default:
                $userview = 'dashboard';

        }
        $this->load->view('template/admin/'.$userview,$data);
        $this->load->view('includes/footer');


    }
    public function admin_user(){
        $bid = $this->uri->segment(3);
        $_SESSION['uid'] = $bid;
        $data['records'] = $this->uinit->getuserdata($bid);
        $data['image'] = $this->uinit->getuserimage($bid);
        $data['rscacontent'] = $this->uinit->getrscacontent($bid);
        $this->load->view('includes/header', $data);
        $this->load->view('includes/admin/navigation');
        $this->load->view('template/admin/dashboard',$data);
        $this->load->view('includes/footer');
    }
    public function app_user(){
        $bid = $_SESSION['usr_bid'];
        $data['records'] = $this->uinit->getuserdata($bid);
        $data['image'] = $this->uinit->getuserimage($bid);
        $data['rscacontent'] = $this->uinit->getrscacontent($bid);
        $this->load->view('includes/header', $data);
        $this->load->view('includes/admin/navbar_app');
        $this->load->view('template/admin/dashboard',$data);
        $this->load->view('includes/footer');
    }

    public function user_app(){

            if (isset($_SESSION['usr_type']) && $_SESSION['usr_type'] == 'user'){
            unset ($_SESSION['usr_type']);

            $_SESSION['usr_type'] = 'approver';
            
            }else{
               $_SESSION['usr_type'] = 'approver'; 
            }
            

    redirect('dashboard_approver/');
    }
    
}
