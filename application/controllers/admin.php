<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The Start controller displays the User dashboard.
 *
 * PHP Version 5.3
 *
 * @category  WebApplication
 * @package   EFD
 * @author    Ed Lara <ed.lara@csulb.edu>
 * @copyright 2016 CSULB Information Technology Services
 *
 */

/**
 * Dashboard actions and functions.
 *
 * @category WebApplication
 * @package  Telecommexpert
 * @author   Ed Lara <ed.lara@csulb.edu>

 */
class Admin extends CI_Controller
{
    public function __construct() {
        session_start();
        parent::__construct();
        if(!isset($_SESSION['usr_bid'])) {
            redirect('authenticate');
        }
        else{
            redirect('dashboard');
        }
    }

    }


    /**
     * Show dashboards and reports.
     *
     * @return null
     */