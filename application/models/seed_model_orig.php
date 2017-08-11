<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Created by Ed Lara.
 * Package: Expert Faculty Database
 * Date: 10/31/2016
 * Time: 3:14 PM
 */
class Seed_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

    }
public function SeedDivisions(){

    $query = $this->db->get('DIVISION');

    return $query->result_array();

}
public function seedUrls($file_name){

    $file = fopen('./uploads/csv/'.$file_name,"r");

    while(! feof($file))
    {   $host = '';
        $string = fgets($file);
        $pstr = explode(',', $string);
        $bid = $pstr[0];
        //$first =  $pstr[1];
        //$last = $pstr[2];
        $url = $pstr[1];

        if (strpos($url, 'http') !== false) {
            $urlhost = parse_url($url, PHP_URL_HOST);
            $urlpath = parse_url($url, PHP_URL_PATH);
            $query = parse_url($url,PHP_URL_QUERY);
            if (strlen($query)>0) {
                $host = $urlhost . $urlpath.'?'.$query;
            }
            else{$host = $urlhost . $urlpath;

            }
        } else {
            $host = parse_url($url, PHP_URL_PATH);
            $query = parse_url($url,PHP_URL_QUERY);
            if (strlen($query)>0) {
                $host = $urlhost . $urlpath.'?'.$query;
            }
            else{$host = $urlhost . $urlpath;

            }
        }

        $output = '';
        $this->load->library('simple_html_dom');


        $html = file_get_html($url)->plaintext;

        $out = html_escape(preg_replace('/\s+/S', ' ', trim($html)));
        $final = preg_replace('/\t/', '', $out);
        $superfinal = str_replace('&nbsp;', '', $final);
        $ouput = strtolower($superfinal);

        $valuesweb = array(
            'PERSONAL_URL' => $host,


        );

        $this->db->where('BEACHID', $bid);
        $this->db->update('USERS', $valuesweb);
// connect to DB to update URL Content
        $ezconnect = '(DESCRIPTION =
    						(ADDRESS = (PROTOCOL = TCP)(HOST = 10.35.0.83)(PORT = 1521))
    						(CONNECT_DATA =
      						(SERVER = DEDICATED)
      						(SERVICE_NAME = expfacd)
    									)
  							)';

        $db_user = 'efd_user';
        $db_password = 'efdS3arch';
        $db_database = 'expfacd';

        $conn = oci_connect($db_user, $db_password, $ezconnect);


        $sql = " UPDATE USERS SET
					            PERSONAL_URL_CONTENT = EMPTY_CLOB()
					        WHERE
					           BEACHID = '$bid'
					        RETURNING
					            PERSONAL_URL_CONTENT INTO :puc ";

        $stmt = OCIParse($conn, $sql);

        $lob = OCINewDescriptor($conn, OCI_D_LOB);

        OCIBindByName($stmt, ':puc', $lob, -1, OCI_B_CLOB);

        // Execute the statement using OCI_DEFAULT (begin a transaction)
        OCIExecute($stmt, OCI_NO_AUTO_COMMIT) or die ("Unable to execute query\n");
        $lob->save($ouput);

        OCICommit($conn);
        $lob->free();
        OCIFreeStatement($stmt);






    }
redirect('dashboard_seed');
}

}
