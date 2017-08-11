<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * This library facilitates querys on the Oracle database used by Peoplesoft (CMS).
 *
 * There are a few columns available through this DB view:
 *
 *   DIVISION: DOIT							(DIVISION) - Long Description needed
 *   DEPTID: 00753								(Primary Department ID)
 *   DEPTNAME: ITS Svcs Mgmt &Operations-0101	(Name of Primary Dept and Mailstop)
 *
 */

class Peoplesoft_library
{
    public function __construct()
    {

    }

    /**
     * @return array
     */
    public function getDivisionData()
    {
        $handle = oci_connect(CMSORA_USER, CMSORA_PSWD, CMSORA_EZCONNECT);  // Easy Connect String
        $query = "SELECT DISTINCT DIVISION FROM sysadm." . CMSORA_TBL . " WHERE DIVISION LIKE '%AA-%'";
        $success = FALSE;

        // Connection verification.
        if (!$handle) {
            // Error.
            return array();
        } else {
            $compiled_query = oci_parse($handle, $query);
            $success = oci_execute($compiled_query);

            if ($success === FALSE) {
                // Error.
                return array();
            } else {



                // Map results to anticipated result order.
                $outs = array();
                $ids = array();
                $divs = array();
                $items = array();
                while (($row = oci_fetch_array($compiled_query, OCI_ASSOC)) != false) {

                        $outs[] = $row['DIVISION'];

                    if (in_array("AA-APGS", $row)) {
                        $items[] = "Academic Planning and Graduate Studies";
                    }
                    if (in_array("AA-ARSP", $row)) {
                        $items[] = "Academic Resources and Strategic Planning";
                    }
                    if (in_array("AA-ATS", $row)) {
                        $items[] = "Academic Technology Services";
                    }
                    if (in_array("AA-CBA", $row)) {
                        $items[] = "College of Business Administration";
                    }
                    if (in_array("AA-CCPE", $row)) {
                        $items[] = "College of Continuing and Professional Education";
                    }
                    if (in_array("AA-CED", $row)) {
                        $items[] = "College of Education";
                    }
                    if (in_array("AA-CHHS", $row)) {
                        $items[] = "College of Health and Human Services";
                    }
                    if (in_array("AA-CLA", $row)) {
                        $items[] = "College of Liberal Arts";
                    }
                    if (in_array("AA-CNSM", $row)) {
                        $items[] = "College of Natural Sciences and Mathematics";
                    }
                    if (in_array("AA-COE", $row)) {
                        $items[] = "College of Engineering";
                    }
                    if (in_array("AA-COTA", $row)) {
                        $items[] = "College of The Arts";
                    }
                    if (in_array("AA-CPAC", $row)) {
                        $items[] = "Carpenter Performaing Arts Center";
                    }
                    if (in_array("AA-DIV", $row)) {
                        $items[] = "Academic Affairs";
                    }
                    if (in_array("AA-FA", $row)) {
                        $items[] = "Faculty Affairs";
                    }
                    if (in_array("AA-LIB", $row)) {
                        $items[] = "University Library";
                    }
                    if (in_array("AA-OSI", $row)) {
                        $items[] = "Ocean Studies Institute";
                    }
                    if (in_array("AA-RSCH", $row)) {
                        $items[] = "Research";
                    }
                    if (in_array("AA-USAA", $row)) {
                        $items[] = "Undergraduate Studies and Academic Advising";
                    }
                }


                }


            $output = array_combine($outs,$items);
            return $output;
            }

            // Free the statement identifier when closing the connection
            oci_free_statement($compiled_query);
            oci_close($handle);
        }

        public function getAssociatedDepts ($divs)
        {

            $handle = oci_connect(CMSORA_USER, CMSORA_PSWD, CMSORA_EZCONNECT);  // Easy Connect String
            $query = "SELECT DEPTNAME FROM sysadm." . CMSORA_TBL . " WHERE DIVISION LIKE '%{$divs}%'";

                $compiled_query = oci_parse($handle, $query);
                $success = oci_execute($compiled_query);

            echo '<div class="form-group">
                                        <label for="inputDept" class="col-md-3 control-label" id="deplabel">Department:</label>
                                        <div class="col-md-10">
                                           <select class="form-control" id="inputDepts" name="department">
                                            <option value="">[Select one or more]</option>';
                if ($success) {
                    while (($row = oci_fetch_array($compiled_query, OCI_ASSOC)) != false) {

                        echo '<option value="' . $row['DEPTNAME'] . '">' . ucwords($row['DEPTNAME']) . '</option>';
                    }
                }

                echo "</select></div></div></div>";

        }


}