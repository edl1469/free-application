<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_user extends CI_Controller
{

    /**
     * @author: Ed Lara
     * User Update Controller For Expert Profile Changes
     */

    public function __construct()
    {
        session_start();
        parent::__construct();
        $this->load->model('user_update_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $bid = $_SESSION['usr_bid'];


    }

    public function update_user_profile()
{   
        
    $_SESSION['update'] = true;
    $bid = $_SESSION['usr_bid'];
    // Temporary session created until profile is submitted. This model saves updated profile info in a session

    $data = $this->user_update_model->setprofilesession($bid);

}


    public function cancel_user_profile()
    {


        // Temporary session created until profile is submitted. This model saves updated profile info in a session

        $data = $this->user_update_model->canceluserprofile();

    }

    public function submit_user_profile()
    {   if (isset($_SESSION['uid'])){
            $bid = $_SESSION['uid'];
        }
        else{
        $bid = $_SESSION['usr_bid'];
    }
        $_SESSION['profiledata'] = true;

        // Temporary session created until profile is submitted. This model saves updated profile info in a session

        $data = $this->user_update_model->submittedprofile($bid);

                    

    }
    public function update_user_optin()
    {   
        $bid = $_SESSION['usr_bid'];
        
        $_SESSION['update'] = true;

        // Temporary session created until profile is submitted. This model saves updated profile info in a session

        $data = $this->user_update_model->setoptinchoice($bid);

    }


}