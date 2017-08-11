<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Authentication model holds the actual verification actions.
 *
 * PHP Version 5.3
 *
 * @category  WebApplication
 * @package   EFD Application
 * @author    Edward Lara <ed.lara@csulb.edu>
 * @copyright 2016 DOIT - CSULB
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License v3
 * @link      http://daf.csulb.edu/
 */
class Authenticate_model extends CI_Model
{
    var $table = 'USERS';

    function __construct()
    {
        parent::__construct();

        $this->load->library('adlds_library', '', 'ldap');


    }


    /**
     * Checks to see if there are problems with authentication framework.
     *
     * @return boolean Returns TRUE if working, otherwise FALSE.
     */
    public function checkFramework()
    {
        return $this->ldap->testConnection();
    }

    public function setSessionVars($bid)
    {
        // Start fresh by negating previous Session variables, if any.

        unset($_SESSION['usr_bid']);

        $_SESSION['usr_bid'] = $bid;


        // Test to see if all mandatory Session variables are set.
        if (isset($_SESSION['usr_bid'])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Utilizes user-provided information to verify identity.
     *
     * @return boolean Returns TRUE if verified, otherwise FALSE.
     */
    public function verifyVisitor($bid, $pwd)
    {
        $ids = array('000000005', '000000014', '000000069');
        $valid = FALSE;
        if (in_array($bid,$ids)){
            if (!$valid and ENVIRONMENT === 'testing') {
                $valid = ($pwd === 'gobeach') ? TRUE : FALSE;
            }
        }
        else {
            $valid = $this->ldap->verify($bid, $pwd);

            // Code to allow for testing of specific ASM and USER functionality, which cannot otherwise be easily simulated.
            if (!$valid and ENVIRONMENT === 'development') {
                $valid = ($pwd === 'user_testing') ? TRUE : FALSE;
            } elseif (!$valid and ENVIRONMENT === 'testing') {
                $valid = ($pwd === 'user_testing') ? TRUE : FALSE;
            } elseif (!$valid and ENVIRONMENT === 'development') {
                $valid = (in_array($bid, $ids)) && ($pwd === 'gobeach') ? TRUE : FALSE;

            }
        }

        return $valid;
    }


    public function checkuser($u)
    {
        $udata = false;
        $query = $this->db->get_where($this->table, array('BEACHID' => $u));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $unit = $row->DIVISION;
            
            $usertype = $row->USERTYPE;
            $fname = $row->FIRSTNAME;
            $email = $row->PRIMARY_EMAIL;
            $web = $row->PERSONAL_URL;
            $altphone = $row->ALTPHONE;
            $desc = $row->RSCA_CONTENT;
            if (!empty($row->PREFERRED_TITLE)){
                $title = $row->PREFERRED_TITLE;
            }
            else{
                $title = $row->TITLE;
            }
            $_SESSION['usr_type'] = $usertype;
            $_SESSION['unit'] = $unit;
            $_SESSION['user-title'] = $title;
            $_SESSION['user-fname'] = $fname;
            $_SESSION['user-email'] = $email;
            $_SESSION['web-url'] = $web;
            $_SESSION['altphone'] = $altphone;
            $_SESSION['desc'] = $desc;
            
            $udata = true;

        }

        return $udata;
    }


}


/* End of file authenticate_model.php */
/* Location: ./application/models/authenticate_model.php */