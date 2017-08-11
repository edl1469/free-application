<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/*
 * Basic sequence with AD LDS is:
 *      1. Connect,
 *      2. Bind,
 *      3. Search,
 *      4. Interpret result, and
 *      5. Close connection
 *
 * Example of CSULB LDAP entry:
 *   displayName:               Ed Lara
 *   csulbemployeemail:         Ed.Lara@csulb.edu
 *   telephoneNumber:           52728
 *   physicalDeliverOfficeName: BH-188
 *   department:                ITS Servers, Systems & Web
 *   title:                     Web Dvlpmnt Center-Lead
 *   cn:                        007797580
 *
 * Important Note:
 *   One must use the ldap_set_option for success with ADLDS. Example:
 *     ldap_set_option( $connection, LDAP_OPT_PROTOCOL_VERSION, 3 );
 */

class Adlds_library
{
  public function __construct()
  {
    // Empty
  }


  /**
   * Performs the ADLDS Connect and Bind steps, to verify server availability.
   *
   * @return boolean Returns true if verifired, otherwise false.
   */
  public function testConnection()
  {
    $connection = ldap_connect(ADLDS_HOST);
    $success = false;
    if ($connection) {
      ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
      if (ldap_bind($connection, ADLDS_BINDDN, ADLDS_PSWD)) {
        $success = true;
      }
    }
    ldap_close($connection);

    return $success;
  }

  /**
   * Performs the ADLDS Connect and Bind steps with user-provided information.
   *
   * @return boolean Returns true if verifired, otherwise false.
   */
  public function verify($bid, $pwd)
  {
    $connection = ldap_connect(ADLDS_HOST);
    $bindstring = 'CN='.$bid.','.ADLDS_QUERYBASE;
    $success = false;
    if ($connection) {
      ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
      if (ldap_bind($connection, $bindstring, $pwd)) {
        $success = true;
      }
    }
    ldap_close($connection);

    return $success;
  }

}

/* End of file adlds_library.php */
/* Location: ./application/libraries/adlds_library.php */
