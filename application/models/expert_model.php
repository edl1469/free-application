<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Created by Ed Lara.
 * Package: Expert Faculty Database
 * Date: 10/31/2016
 * Time: 3:14 PM
 */
class Expert_model extends CI_Model
{
var $table = 'USERS';
    public function __construct()
    {
        parent::__construct();
    }
// Select Single record from db for logged in user.
    public function getOneRecord($dbid)
    {
        $query = $this->db->get_where($this->table, array('beachid' => $dbid));

        return $query->row();
    }
}
