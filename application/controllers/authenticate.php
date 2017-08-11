<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The Authenticate controller manages the user authentication actions.
 *
 * PHP Version 5.3
 *
 * @category  WebApplication
 * @package   TelecommRequest
 * @author    Steven Orr <sorr@csulb.edu>
 * @copyright 2011 CSULB Information Technology Services
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License v3
 * @link      http://daf.csulb.edu/
 */

/**
 * Application-internal Authentication actions and functions.
 *
 * This authentication strategy was generally borrowed from an online article.
 * Author:  JeffreyWay / Simple-CI-Authentication
 * URL:     https://github.com/JeffreyWay/Simple-CI-Authentication/
 * Doc:     http://net.tutsplus.com/tutorials/php/easy-authentication-with-codeigniter/
 *
 * @category WebApplication
 * @package  EFD Application
 * @author   Ed Lara <ed.lara@csulb.edu>
 * @license  http://opensource.org/licenses/gpl-3.0.html GNU Public License v3
 * @link     http://daf.csulb.edu/
 */
class Authenticate extends CI_Controller
{

    public function __construct() {
        session_start();
        parent::__construct();

    }


    /**
     * Perform login functions.
     *
     * @return null
     */
    public function index() {

            if(isset($_SESSION['update'])){
                unset($_SESSION['update']);
            }




        //Perform initial user check to confirm user is part of faculty data


        $valid_user = FALSE;
        $this->load->library( 'form_validation' );
        $this->load->model( 'authenticate_model', 'authenticate' );

        $this->form_validation->set_error_delimiters( '<div class="message errormsg" tabindex="0">', '</div>' );
        $this->form_validation->set_rules( 'username', 'Username', 'trim|required|numeric|xss_clean' );
        $this->form_validation->set_rules( 'password', 'Password', 'required' );  // Evidently, LDAP password can be any character, including space.

        if ( $this->form_validation->run() !== FALSE ) {

            // Form validation passed. Check credentials.
            $u = $this->input->post('username');
            $p = $this->input->post('password');
            $valid = FALSE;
        // Initial Check to see if user is a faculty member.

            $valid_user = $this->authenticate->checkuser($u,$p);

            if ($valid_user == FALSE) {
                $data['nouser_error'] = '<div class="message errormsg" id="error_app">' .
                    '<p>This application is reserved for faculty users only.' .
                    '</p></div>';
            } else {


                $valid = $this->authenticate->verifyVisitor($u, $p);

                if ($valid !== FALSE) {
                    $this->authenticate->setSessionVars($u);


                    if (isset($_SESSION['usr_bid']) && ($valid_user)) {
                        $bid = $_SESSION['usr_bid'];

                        switch($_SESSION['usr_type']){
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
                        redirect($userview);

                    } else {
                        $data['authentication_error'] = '<div class="message errormsg" id-"error_seesion">' .
                            '<p>We could not start a session. Please check back.' .
                            '</p></div>';
                    }
                } else {
                    $data['authentication_error'] = '<div class="message errormsg">' .
                        '<p id="error-invalid" tabindex="0">Either your Username or your Password was incorrect.' .
                        '</p></div>';
                }


            // Pro-actively assess if there is a LDAP problem.
            if (!$this->authenticate->checkFramework()) {
                $data['framework_error'] = '<div class="message errormsg" id="error-ldap">' .
                    '<p>We cannot log you in right now, ' .
                    'as the LDAP server is off-line. Contact the ITS Service Management' .
                    ' and Operations group for further information.</p></div>';
            }
            }

        }

        $data['udata'] = $valid_user;
        $data['bodyId'] = 'authenticate';
        $data['title']  = APP_NAME . ' Login';
        $this->load->view( 'authenticate.login.php', $data );
    }


    /**
     * Perform logout functions.
     *
     * @return null
     */
    public function logout() {
        session_destroy();

        redirect( 'admin' );
    }
}


/* End of file authenticate.php */
/* Location: ./application/controllers/authenticate.php */