<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model
{

    var $db_user = 'efd_user';
    var $db_pswd = 'efdS3arch';
    var $db_host = '10.35.0.83:1521/';


    public function __contstruct()
    {
        parent::__construct();

        $this->load->database();


    }

    public function getDivisionData(){
        $this->db->from('DIVISION');
        $this->db->order_by('DESCRIPTION','asc');
        $query = $this->db->get();
        return $query->result_array(); 
    }

    public function getdetails($id)
    {
        $id = $this->input->post('id');
        $query = $this->db->get_where('USERS', array('BEACHID' => $id));

        if ($query->num_rows() > 0) {

            $row = $query->row();
            // get image url for profile pic
                $img_url='';
                $bchid = $row->BEACHID;
                $query = $this->db->get_where('PROFILE_PICS', array('BEACHID' => $bchid));
                    if ($query->num_rows() > 0) {
                        $rows = $query->row();
                        $img_url = base_url().$rows->IMG_URL;
                    }
                    else{
                        $img_url = base_url().'assets/img/whtspace.jpg';
                    }
            $pnumber = $row->PHONE;
            $len = strlen($pnumber);
            $altphone = $row->ALTPHONE;
            $altcell = '';
            $mail = '';
            $shownumber = '';
            $showalt = '';
            $main_title = '';
            $main_title = (!empty($row->PREFERRED_TITLE)) ? $row->PREFERRED_TITLE : $row->TITLE;
            if ($main_title == 'Pending Approval'){
                $main_title = $row->TEMP_TITLE;
            }
            $mail = (!empty($row->PRIMARY_EMAIL)) ? $row->PRIMARY_EMAIL : $row->EMAIL;
            if ($pnumber && strlen($pnumber) == 5) {
                $newnumber = explode('5', $pnumber, 2);
                

                $first = '(562) 985-' . $newnumber[0];
                $altcell = '562985' . $newnumber[0] . $newnumber[1];
                $last = $newnumber[1];
                $displaynumber = $first . $last;
                $shownumber = '<p class="card"><a href="tel:' . $altcell . '"><i class="fa fa-phone-square" aria-hidden="true" style="margin-right:5px;"></i>' . $displaynumber . '</a></p>';
            }
            else{
                $shownumber = '<p class="card"><a href="tel:' . str_replace('-', '', $pnumber) . '"><i class="fa fa-phone-square" aria-hidden="true" style="margin-right:5px;"></i>' . $pnumber . '</a></p>';
            } 
            
            
            
            if ($altphone) {
                $newalt= str_replace("(", "", str_replace(")", "", $altphone));
                $showalt = '<p class="card"><a href="tel:' . $newalt . '"><i class="fa fa-phone-square" aria-hidden="true" style="margin-right:5px;"></i>' . $altphone . '</a></p>';
            }


            $qry = $this->db->get_where('DIVISION', array('SHORT_CODE' => $row->DIVISION));
            if ($qry->num_rows() > 0) {

                $rw = $qry->row();
                $detail_div = $rw->DESCRIPTION;
            }

            echo '<div class="boxit">
            <div class="col-md-12" id="closedets"><button type="button" class="btn btn-default" id="close-details" value="'.$bchid.'">Close</button></div><div class="clearfix"></div>
            <h2 style="margin-left:.65em;">' . $row->FIRSTNAME . ' ' . $row->LASTNAME . '</h2> 

            <div class="col-md-6" style="padding:1em;"><table style="width:100%" class="table-bordered"> 
            <tbody>
            <tr><th scope="row"class="row-head">Title:</th>
            <td class="row-data">' . $main_title . '</td></tr>
            <tr><th scope="row"class="row-head">Department:</th>
            <td class="row-data">' . $row->DEPARTMENT . '</td></tr>
            <tr><th scope="row" class="row-head">College:</th>
            <td class="row-data">' . $detail_div . '</td></tr>
            <tr><th scope="row" class="row-head">Contact Information:</th>
            <td class="row-data"><p><a href="mailto:' . strtolower($mail) . '"><i class="fa fa-envelope padright" aria-hidden="true" style="margin-right:5px;"></i>' . ucwords($mail) . '</a></p>' . $shownumber . $showalt . '</td>
            ';
            if (!empty($row->PERSONAL_URL)){

                $urlStr = $row->PERSONAL_URL;
                $parsed = parse_url($urlStr);
                if (empty($parsed['scheme'])) {
                $urlStr = 'http://' . ltrim($urlStr, '/');
                }


            echo '<tr scope="row"><th class="row-head">Webpage:</th>
            <td class="row-data"><a href="' . $urlStr . '" target="_blank">View Webpage</a></td></tr>
            </tr>';}

            echo'</tbody></table></div>
            <div class="img-circle col-md-3" ><img src = "' . $img_url . '" width = "170" id = "detail-img" ></div >
            <div class="clearfix"></div>                                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                                                                    
            <h3 style="padding-top:1em;padding-left:1em;">Research, Scholarly, and Creative Activity:</h3>                                                                                                                                                                                                                                                                                                                              
            <div class="col-lg-10" style="padding:1em;">' . $row->RSCA_CONTENT . '</div> <div class="clearfix" style="padding:2em;"></div>                                                                                                                                                                                                                                                                                                                   
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
            </div></div></div>';
            echo '<script>
                $(\'#close-details\').click(function () {
        $(\'#details\').hide();
        $(\'#results\').toggle();
        $(\'#'.$bchid.'\').focus();
    });
</script>';

        }
    }


    public function get_local_depts($div)

    {
        $newdiv = '';
        if ($div == 'AA-CAPS'){
            $divquery = "SELECT DISTINCT DEPARTMENT FROM users WHERE DEPARTMENT = 'Counseling & Psych Svcs'";
        }
        else{
            $divquery = "SELECT DISTINCT DEPARTMENT FROM users WHERE DIVISION = '$div' ORDER BY DEPARTMENT ASC";
        }

        $query = $this->db->query($divquery);
        $out = $query->result_array();
        if ($out) {
            echo '<div class="form-group">
            <label for="inputDept" class="col-md-3 control-label" id="deplabel">Department:</label><div class="col-md-6" id="selectdpt">';
            echo '<select class="form-control" id="inputDept" name="departments">
                <option value=" ">[Select one or more]</option> ';
            if ($div != 'AA-CAPS'){echo "<option value='Any'>Any</option>";}
            foreach ($out as $deplist) {

                echo '<option value="' . $deplist['DEPARTMENT'] . '">' . $deplist['DEPARTMENT'] . '</option>';

            }
            echo '</select></div></div>';
        } else {
            echo '<div class="form-group">
            <label for="inputDept" class="col-md-3 control-label" id="deplabel">Department:</label><div class="col-md-6" id="selectdpt">';
            echo '<select class="form-control" id="inputDept" name="departments">
                <option value=" ">[Select one or more]</option> ';
            echo "<option value='Any'>Any</option></select></div></div>";
        }
    }

    public function search_users()
    {
        /*
         * counter used to determine how to append sql query if first name field is used.
         */
        $counter = 0;

        /*
         * setting initial values AND search variables
         */
        $firstname = '';
        $lastname = '';
        $postvars = array('firstname', 'lastname', 'keywords', 'division');
        $i = 0;
        foreach ($postvars as $v) {
            if (!empty($_POST[$v])) {
                $i++;
            }

        }
        if ($i == 0) {
            //error here
            $data = 'empty';
            echo $data;
            exit();
        } else {

            $sql = "SELECT * FROM users WHERE STATUS != 'U' AND OPTEDIN = 1";



            if ($this->input->post('keywords')) {
                $keywords = strtolower($this->input->post('keywords'));
                

                //$keywordslower = strtolower($this->input->post('keywords'));
                //$keywordsupper = strtoupper($this->input->post('keywords'));
                
                	$keyword_count = str_word_count($keywords);
                	if ($keyword_count > 1){
                		$exploded_search = explode(" ",trim($keywords));
                		$i = 0;
                		foreach ($exploded_search as $keyword){
                			if ($i == 0){
                			$sql .= " AND (NLS_LOWER(RSCA_CONTENT) LIKE '%$keyword%' OR NLS_LOWER(PERSONAL_URL_CONTENT) LIKE '%$keyword%' OR NLS_LOWER(FIRSTNAME) LIKE '%$keyword%' OR NLS_LOWER(FULLNAME) LIKE '%$keyword%' OR NLS_LOWER(LASTNAME) LIKE '%$keyword%')";
                				$i++;
                		}
                		else{
                			$sql .= " OR (NLS_LOWER(RSCA_CONTENT) LIKE '%$keyword%' OR NLS_LOWER(PERSONAL_URL_CONTENT) LIKE '%$keyword%' OR NLS_LOWER(FIRSTNAME) LIKE '%$keyword%' OR NLS_LOWER(FULLNAME) LIKE '%$keyword%' OR NLS_LOWER(LASTNAME) LIKE '%$keyword%')";

                		  }
                	   }
                		
                	}
                else{	
                	$sql .= " AND (NLS_LOWER(RSCA_CONTENT) LIKE '%$keywords%' OR NLS_LOWER(PERSONAL_URL_CONTENT) LIKE '%$keywords%' OR NLS_LOWER(FIRSTNAME) LIKE '%$keywords%' OR NLS_LOWER(FULLNAME) LIKE '%$keywords%' OR NLS_LOWER(LASTNAME) LIKE '%$keywords%')";
                	

                	}
                    
                    
                    $counter++;
                
            }

            if ($this->input->post('firstname')) {
                
                $fname = strtolower($this->input->post('firstname'));
                
                    if ($counter > 0){
                $sql .= " AND (NLS_LOWER(FIRSTNAME) LIKE '%{$fname}%')";
                $counter++;
            }
            else{
                $sql .= " AND (NLS_LOWER(FIRSTNAME) LIKE '%{$fname}%')";
            }
            }
            if ($this->input->post('lastname')) {
                
                $lname = strtolower(str_replace("'", "''",$this->input->post('lastname')));
                
                if ($counter > 0){
                $sql .= " AND (NLS_LOWER(LASTNAME) LIKE '%{$lname}%')";
            }
            else{
                $sql .= " AND (NLS_LOWER(LASTNAME) LIKE '%{$lname}%')";
            }

            }
            

            if ($this->input->post('department')) {
                $department = $this->input->post('department');
                $division = $this->input->post('division');
                if (empty($division) && empty($division)){
                    $sql .= '';
                }
                else{
                if ($counter > 0) {
                    if ($department == 'Any' && $division != 'AA-CAPS') {
                        $sql .= " AND DIVISION = '$division'";
                    } elseif ($department == ' ' && $division != 'AA-CAPS') {
                        $sql .= " AND DIVISION = '$division'";
                    } 
                        elseif ($division == 'AA-CAPS'){
                        $sql .= " AND DIVISION = 'DSA' AND DEPARTMENT = 'Counseling & Psych Svcs'";
                      }
                    else {
                        $sql .= " AND department LIKE '%{$department}%'";
                        $counter++;
                    }
                }
                if ($counter == 0) {
                    if ($department == 'Any' && $division != 'AA-CAPS') {
                        $sql .= " AND DIVISION = '$division'";
                        $counter++;
                    } elseif ($department == ' ' && $division != 'AA-CAPS') {
                        $sql .= " AND DIVISION = '$division'";
                    } 
                      elseif ($division == 'AA-CAPS'){
                        $sql .= " AND DIVISION = 'DSA' AND DEPARTMENT = 'Counseling & Psych Svcs'";
                      }
                    else {
                        $sql .= " AND department LIKE '%{$department}%'";
                        $counter++;
                    }
                }
            }

            }

            
            $sql .= " ORDER BY LASTNAME ASC";

            $query = $this->db->query($sql);
            $count = $query->num_rows();
            if (!$count) {
                $data = 'no data';
                echo $data;
                //echo $sql . '<br>Keyword Count: '.$keyword_count;
                exit;
            }
            
            //
            //used for testing sql statement- REMOVE IN PRODUCTION
            //echo $sql;
            //echo '<br>'.$counter;
            $imgsrc = base_url() . 'assets/img/profile.png';
            $pnumber = '';
            $i = 0;
            foreach ($query->result_array() as $row) {
                $mail = (!empty($row['PRIMARY_EMAIL'])) ? $row['PRIMARY_EMAIL'] : $row['EMAIL'];
                $end = count($row);

                if ($i == 0) {
                    echo '

                <div class="col-md-12 col-sm-6 col-xs-12">
  <h2>Search Results</h2>
            
  <table class="table table-striped table-bordered results-table" id="table-results">
  
    <thead>
      <tr>
        <th id="hname"><span id="tname">Name</span></th>
        <th id="hdept">Department</th>
        <th id="hemail">Email</th>
        <th id="hprofile" class="no-sort" tabindex="0">Faculty Profile</th>
      </tr>
    </thead>
    <tbody >';
                }
                $urlStr = $row['PERSONAL_URL'];
                $parsed = parse_url($urlStr);
                if (empty($parsed['scheme'])) {
                $urlStr = 'http://' . ltrim($urlStr, '/');
                }

                echo '<tr>
        <td class="tbresults" >' . $row['LASTNAME'] . ', ' . $row['FIRSTNAME'] . '</td>
        <td class="tbresults">' . $row['DEPARTMENT'] . '</td>
        <td class="tbresults"><a href="mailto:' . strtolower($mail) . '"><i class="fa fa-envelope padright" aria-hidden="true" style="margin-right:5px;"></i>' . strtolower($mail) . '</a></td>';

                
                    echo '<td class="tbresults" ><a href="#" class="profilebtn" id="'.$row['BEACHID'].'"> View Research Interests</a></td>';
                 
                echo '</tr>';
                $i++;
                if ($i == $count) {
                    echo '</tbody>
            </table>
                </div>';
                }
            }
            // echo $count;
        }

    }
}
