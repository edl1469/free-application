<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Authentication model holds the user inititation and verification.
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
class User_init_model extends CI_Model
{

    var $table = 'USERS';

    function __construct()
    {
        parent::__construct();

    }

    public function getusername($bid)
    {
        $this->db->select('FIRSTNAME');
        $this->db->where("BEACHID = $bid");
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $row = $query->row();

            return $row->FIRSTNAME;

        }
    }


    public function getrscacontent($bid)
    {
        $query = $this->db->select('RSCA_CONTENT');
        $this->db->where("BEACHID = $bid")->where ("(RSCA_CONTENT IS NOT NULL)");
        $query = $this->db->get($this->table);
        $content = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            return $row->RSCA_CONTENT;


        }

    }



    public function setusertype($bid)
    {
        $query = $this->db->select('USERTYPE');
        $this->db->where("BEACHID = $bid");
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $row = $query->row();

            return $row->USERTYPE;

        }
    }

    public function getuserdata($bid)
    {

        $query = $this->db->get_where($this->table, array('BEACHID' => $bid));
        

        return $query->result_array();


    }


    public function getuserimage($bid)
    {

        $query = $this->db->query("SELECT * FROM \"PROFILE_PICS\" WHERE BEACHID = $bid");
        if ($query->num_rows() > 0) {
            $row = $query->row();

            return $row->IMG_URL;

        }
    }



}