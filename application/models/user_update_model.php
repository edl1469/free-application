<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Created by Ed Lara.
 * Package: Expert Faculty Database
 * Date: 10/31/2016
 * Time: 3:14 PM
 */
class User_update_model extends CI_Model

{

    public function __construct()
    {
        parent::__construct();

    }

// save profile changes to session variable.
    public function setoptinchoice($bid)
    {
        $optchoice = $this->input->post('optin');
        $values = array(
            'OPTEDIN' => $optchoice,
            'OPT_FLAG' => 'Y'
        );

        $this->db->where('BEACHID', $bid);
        $this->db->update('USERS', $values);

        if ($optchoice == 1) {
            echo '<p class="alert alert-success" style="margin:20px;"><strong>Your profile is now searchable in the FREE system.</strong></p>';
        } else {
            echo '<p class="alert alert-warning" style="margin:20px;"><strong>Your profile is now unsearchable in the FREE system.</strong></p>';
        }
    }

  
    public function canceluserprofile()
    {
        // if user cancels
        if (isset($_SESSION['img_path'])) {
            chmod($_SESSION['img_path'], 0777);
            unlink($_SESSION['img_path']);
        }
        if (isset($_SESSION['img_file'])) {
            chmod($_SESSION['img_file'], 0777);
            unlink($_SESSION['img_file']);
        }


        if (isset($_SESSION['user-email'])) {
            unset($_SESSION['user-email']);
        }
        if (isset($_SESSION['web-url'])) {
            unset($_SESSION['web-url']);
        }
        if (isset($_SESSION['altphone'])) {
            unset($_SESSION['altphone']);
        }
        if (isset($_SESSION['desc'])) {
            unset($_SESSION['desc']);
        }
        if (isset($_SESSION['img-profile'])) {
            unset($_SESSION['img-profile']);
        }

    }

    public function submittedprofile($bid)
    {

            

        if ($_SESSION['profiledata']) {
            $values = '';
            // check url for http:// and remove it for comparison
            $host = '';
            $urlhost = '';
            $urlpath = '';
            $q = '';
            $changed_url = FALSE;
            $url = $this->input->post('webpage');
            if (strpos($url, 'http') !== false) {
                $urlhost = parse_url($url, PHP_URL_HOST);
                $urlpath = parse_url($url, PHP_URL_PATH);
                $q = parse_url($url, PHP_URL_QUERY);
                if (strlen($q) > 0) {
                    $host = $urlhost . $urlpath . '?' . $q;
                } else {
                    $host = $urlhost . $urlpath;

                }
            } else {
                $urlpath = parse_url($url, PHP_URL_PATH);
                $q = parse_url($url, PHP_URL_QUERY);
                if (strlen($q) > 0) {
                    $host = $urlpath . '?' . $q;
                } else {
                    $host = $urlpath;

                }
            }

            // if user submits data.... create sessions from form input
            if (isset($_SESSION['web-url'])) {
                unset($_SESSION['web-url']);
            }
            if (isset($_SESSION['img-profile'])) {
                unset($_SESSION['img-profile']);
            }
            
            if (isset($_SESSION['user-email'])) {
                unset($_SESSION['user-email']);
            }
            if (isset($_SESSION['altphone'])) {
                unset($_SESSION['altphone']);
            }

            


            $sub_title = $this->input->post('title');

            $_SESSION['user-email'] = $this->input->post('email');
            //$_SESSION['web-url'] = $host;
            $_SESSION['web-url'] = $url;
            $_SESSION['altphone'] = $this->input->post('altphone');
            $rsca = $this->input->post('expdesc');
            $_SESSION['img-profile'] = $this->input->post('subfile');
            $div = $this->input->post('division');
            $_SESSION['div'] = $div;

            // upload image process
            if (!empty($_SESSION['img-profile'])) {
                $imageurl = 'assets/profile_pics/' . $_SESSION['img_file'];
                $this->db->where('BEACHID', $bid);
                $query = $this->db->get('PROFILE_PICS');
                if ($query->num_rows() > 0) {
                    $row = $query->row();

                    $imgpath = $row->IMG_URL;
                    unlink($imgpath);

                    $values = array(
                        'IMG_URL' => $imageurl

                    );
                    $this->db->where('BEACHID', $bid);
                    $this->db->update('PROFILE_PICS', $values);
                } else {
                    $values = array(
                        'IMG_URL' => $imageurl

                    );
                    $this->db->set('BEACHID', $bid);
                    $this->db->insert('PROFILE_PICS', $values);
                }
            }
            // end of image upload and db update
            // Insert Searchable Option from user

            $optchoice = $this->input->post('searchopt');
            $values = array(
            'OPTEDIN' => $optchoice,
            'OPT_FLAG' => 'Y'
                );

            $this->db->where('BEACHID', $bid);
            $this->db->update('USERS', $values); 

            // End Searchable Option process

              
            // Insert or Update RSCA content from textarea in form
            $update_rsca = false;
            
            // Insert or Update RSCA content from textarea in form
            $update_rsca = false;
            if (!empty($rsca)) {

                $revised_content = strip_tags(str_replace("'", "''",$rsca));
                $values = array(
                    'RSCA_CONTENT' => $revised_content

                );

                $this->db->where('BEACHID', $bid);
                $this->db->update('USERS', $values);

                $_SESSION['update'] = false;
                $update_rsca = true;

            } else {
                $revised_content = '';
                $data = array(
                    'RSCA_CONTENT' => $revised_content

                );

                $this->db->where('BEACHID', $bid);
                $this->db->update('USERS', $data);

                $_SESSION['update'] = false;
                $update_rsca = true;

            }
            //end of RSCA Content Update

            
            

            // TITLE UPDATE : before update, check the TITLE content and compare with values in DB. If matched do nothing otherwise update and send email and update approval table.
            $oldtitle = '';
            $oldurl = '';
            $oldphone = '';
            $oldemail = '';
            
            
            $query = $this->db->get_where('USERS',array('BEACHID' => $bid));
            

            if ($query->num_rows() > 0) {
                $row = $query->row();
                    if (!empty($row->PREFERRED_TITLE) && $row->TITLE != 'Pending Approval'){

                        $oldtitle = $row->PREFERRED_TITLE;
                    }
                    else
                        {
                            $oldtitle = $row->TITLE;
                        }
                $oldurl = $row->PERSONAL_URL;
                $oldphone = $row->ALTPHONE;
                $oldemail = $row->PRIMARY_EMAIL;
                $title_change = '';
                $title_change = (trim($sub_title) === $oldtitle) ? false : true;
                $email_user = false;
                if ($title_change) {
                    if ($oldtitle != 'Pending Approval') {

                        // Update USERS DB and insert into Approval

                        $values = array(
                            'TITLE' => 'Pending Approval',
                            'TEMP_TITLE' => $oldtitle,
                        );
                        $this->db->where('BEACHID', $bid);
                        $this->db->update('USERS', $values);

                        // Take New Title and create Approval record
                        $params = array(
                            'BEACHID' => $bid,
                            'PROPOSED_TITLE' => $sub_title,
                            'REQ_APPROVAL' => 1,
                            'DIVISION' => $div,


                        );

                        $this->db->insert('APPROVAL', $params);

                        // load library and send email to requestor

                        //mail to approver

                        $this->load->library('email');
                        $htmlContent = '<h1>Your title change has been submitted to the FREE System.</h1>';
                        $htmlContent .= '<p>You should receive an email shortly regarding this request.</p>';
                        $htmlContent .= '<p>Please review the <a href="' . base_url() . '/admin">Faculty Research Experience and Expertise System</a> to review your information.</p>';
                        
                        $config['mailtype'] = 'html';
                        $this->email->initialize($config);
                        $this->email->to($_SESSION['user-email']);
                        $this->email->from('wdc@csulb.edu', 'FREE System');
                        $this->email->subject('Title Change Requested');
                        $this->email->message($htmlContent);
                        $this->email->send();

                        $email_user = true;

                        if ($email_user) {
                            $this->email_approver();
                        }
                    }
                }
            

                // CHECK EMAIL FOR CHANGE
                if ($_SESSION['user-email'] != $oldemail) {
                    $valueemail = array(

                        'PRIMARY_EMAIL' => $_SESSION['user-email'],


                    );
                    $this->db->where('BEACHID', $bid);
                    $this->db->update('USERS', $valueemail);
                }
                if ($_SESSION['altphone'] != $oldphone) {
                    $valuephone = array(

                        'ALTPHONE' => $_SESSION['altphone'],


                    );
                    $this->db->where('BEACHID', $bid);
                    $this->db->update('USERS', $valuephone);
                }
                // WEB URL UPDATE
                // If new webpage get contents and update PERSONAL_URL_CONTENT Column
                if ($_SESSION['web-url'] !== $oldurl) {
                    if (strlen($_SESSION['web-url']) > 0) {
                        $output = '';
                        $this->load->library('simple_html_dom');
                        $page = 'http://' .$host;
                        //$url = 'http://' . $_SESSION['web-url'];
                        $html = file_get_html($page)->plaintext;

                        $out = html_escape(preg_replace('/\s+/S', ' ', trim($html)));
                        $final = preg_replace('/\t/', '', $out);
                        $superfinal = str_replace('&nbsp;', '', $final);
                        $ouput = strtolower($superfinal);

                        $valuesweb = array(
                            'PERSONAL_URL'  => $page,
                            //'PERSONAL_URL' => $_SESSION['web-url'],


                        );

                        $this->db->where('BEACHID', $bid);
                        $this->db->update('USERS', $valuesweb);

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
                        OCIExecute($stmt, OCI_DEFAULT)
                        or die ("Unable to execute query\n");
                        $lob->save($ouput);

                        OCICommit($conn);
                        $lob->free();
                        OCIFreeStatement($stmt);


                    }
                    else{
                        $valuesweb = array(
                            'PERSONAL_URL' => null,
                            'PERSONAL_URL_CONTENT' => null,
                        );

                        $this->db->where('BEACHID', $bid);
                        $this->db->update('USERS', $valuesweb);
                    }

                }
            }
        }

    }

    public function email_approver()
    {   // Get all approvers for appropriate Division and prep for email.
            
            $this->db->select('EMAIL');
            $this->db->from('APPROVERS');
            $this->db->where('UNIT',$_SESSION['div']);
            $query = $this->db->get();
            $out = $query->result_array();

            if ($out) {

             
             foreach ($out as $recipient){
                
            //mail to approver
            $this->load->library('email');
            $htmlContent = '<h1>Title change requested in FREE System.</h1>';
            $htmlContent .= '<p>Please review the <a href="' . base_url() . '/admin">Approval Control Panel</a> to review the request.</p>';
            
            $this->email->clear();

            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->to($recipient);
            $this->email->from('wdc@csulb.edu', 'FREE System');
            $this->email->subject('Title Change Requested');
            $this->email->message($htmlContent);
            $this->email->send();
            }
        }
    }
}