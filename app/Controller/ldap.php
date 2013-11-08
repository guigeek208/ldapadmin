<?php

class ldap {

  private $address;
  private $port;
  private $username;
  private $password;
  private $connection;
  private $dn;

  function __construct($address, $port, $username, $password, $dn) {
    $this->address = $address;
    $this->port = $port;
    $this->username = $username;
    $this->password = $password;
    $this->dn = $dn;
  }

  private function connect() {
    $con = ldap_connect($this->address, $this->port)
            or die("Impossible de se connecter au serveur LDAP $this->address");
    ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
    $this->connection = $con;
  }
 
  public function bind() {
    $this->connect();
    if (strcmp($this->username, "admin") == 0) {
      if ((ldap_bind($this->connection, 'cn=' . $this->username . "," . $this->dn, $this->password))) {
        return true;
      } else {
        return false;
      }
    }
  } 
 
  public function test_bind($username, $password) {
    //$this->disconnect();
    $this->connect();
    if ((ldap_bind($this->connection, 'uid=' . $username . ",ou=people," . $this->dn, $password))) {
      //$this->disconnect();
      return true;
    } else {
      print "false";
      return false;
    }
  }

  public function disconnect() {
    if (ldap_unbind($this->connection)) {
      return true;
    } else {
      return false;
    }
  }

  public function get_users() {
    $this->bind();
    $findWhat = array("uid", "cn", "gidNumber");
    $findFilter = "(uid=*)";
    $sr = ldap_search($this->connection, $this->dn, $findFilter, $findWhat);
    $records = ldap_get_entries($this->connection, $sr);
    //$this->disconnect();
    return $records;
  }
  
  public function get_groups() {
    $this->bind();
    $findWhat = array("cn");
    $findFilter = "(&(objectClass=posixGroup)(cn=*))";
    $sr = ldap_search($this->connection, $this->dn, $findFilter, $findWhat);
    $records = ldap_get_entries($this->connection, $sr);
    //$this->disconnect();
    return $records;
  }

  public function get_all_users_except_group($groupname) {
    $arr = array();
    $this->bind();
    $findWhat = array("memberUid", "gidNumber");
    $findFilter = "(&(objectClass=posixGroup)(cn=$groupname))";
    $sr = ldap_search($this->connection, $this->dn, $findFilter, $findWhat);
    $records = ldap_get_entries($this->connection, $sr);
    /*echo "<pre>";
    print_r($records);
    echo "</pre>";*/
    $records_all = $this->get_users();
    /*echo "<pre>";
    print_r($records_all);
    echo "</pre>";*/   
    for ($i = 0; $i < $records_all["count"]; $i++) {
      $found=false;
      if ($records[0]["gidnumber"][0] != $records_all[$i]["gidnumber"][0]) {
        for ($j = 0; $j < $records[0]["memberuid"]["count"]; $j++) {
          if ($records_all[$i]["uid"][0] == $records[0]["memberuid"][$j]) {
            $found=true;
          }
        }
        if (!$found) {
          $arr[] = $records_all[$i]["uid"][0];
        }
      }
     
    }
    //$this->disconnect();
    return $arr;
  }
  
  public function get_users_from_group($groupname) {
    $arr = array();
    $this->bind();
    $findWhat = array("memberUid");
    $findFilter = "(&(objectClass=posixGroup)(cn=$groupname))";
    $sr = ldap_search($this->connection, $this->dn, $findFilter, $findWhat);
    $records = ldap_get_entries($this->connection, $sr);
    for ($i = 0; $i < $records[0]["memberuid"]["count"]; $i++) {
      $arr[]=$records[0]["memberuid"][$i];
    }
    return $arr;
  }
  
  public function search_filter($filter) {
    $this->bind();
    //$findWhat = array ("uid", "uidNumber", "cn","mail");
    $findWhat = array("uidNumber");
    $sr = ldap_search($this->connection, $this->dn, $filter, $findWhat);
    $records = ldap_get_entries($this->connection, $sr);
    //$this->disconnect();
    return $records;
  }

  public function get_max_uidnumber() {
    $this->bind();
    //$findWhat = array ("uid", "uidNumber", "cn","mail");
    $filter = "(uid=*)";
    $findWhat = array("uidNumber");
    $sr = ldap_search($this->connection, $this->dn, $filter, $findWhat);
    $records = ldap_get_entries($this->connection, $sr);
    //$this->disconnect();
    $uidmax = 0;
    for ($i = 0; $i < sizeof($records) - 1; $i++) {
      if ($records[$i]["uidnumber"][0] > $uidmax) {
        $uidmax = $records[$i]["uidnumber"][0];
      }
    }
    return $uidmax;
  }

  /**
   * 
   * @return free uidnumber
   */
  public function get_uidnumber_free() {
    $this->bind();
    $filter = "(uid=*)";
    $findWhat = array("uidNumber");
    $sr = ldap_search($this->connection, $this->dn, $filter, $findWhat);
    $records = ldap_get_entries($this->connection, $sr);
    //$this->disconnect();
    $uid = 10000;
    $freeuid = 10000;
    for ($i = 0; $i < sizeof($records) - 1; $i++) {
      if ($records[$i]["uidnumber"][0] != $uid + $i) {
        $freeuid = $uid + $i;
      }
    }
    return $freeuid;
  }

  public function person_exists($uid) {
    $this->bind();
    $filter = "(uid=*)";
    $findWhat = array("uid");
    $sr = ldap_search($this->connection, $this->dn, $filter, $findWhat);
    $records = ldap_get_entries($this->connection, $sr);
    //$this->disconnect();
    for ($i = 0; $i < sizeof($records) - 1; $i++) {
      if (strcmp($records[$i]["uid"][0], $uid) == 0) {
        return true;
      }
    }
    return false;
  }

  public function get_uid_free($uid) {
    $uidtest = $uid;
    $i = 1;
    while ($this->person_exists($uidtest)) {
      $uidtest = $uid . $i;
      $i++;
    }
    return $uidtest;
  }

  public function get_samba_sid() {
    $this->bind();
    $filter = "(&(objectClass=sambaDomain)(sambaDomainName=*))";
    $findWhat = array("sambaSID");
    $sr = ldap_search($this->connection, $this->dn, $filter, $findWhat);
    $records = ldap_get_entries($this->connection, $sr);
    //$this->disconnect();
    return $records[0]['sambasid'][0];
  }
  
  public function add_person($firstname, $lastname) {
    $password = $this->generate_password();
    $login = strtolower($this->get_uid_free($firstname[0] . $lastname));
    //$tel = "4197";
    //$mail = "fdgdf@gfdgdf.gt";
    $gid = "10000";
    $uid = $this->get_uidnumber_free();
    $lastname = strtoupper($lastname);
    
    $racineuser = "ou=people," . $this->dn;
    $info["sn"] = $lastname;
    $info["cn"] = "$firstname $lastname";
    $info["uidNumber"] = $uid;
    //$info["mail"] = $mail;
    //$info["telephoneNumber"] = $tel;
    $info["givenName"] = $firstname;
    $info["displayName"] = $info["cn"];
    $info["gidNumber"] = $gid;
    $info["homeDirectory"] = "/home/$login";
    $info["gecos"] = $info["cn"];
    $info["loginShell"] = "/bin/false";
    $info["shadowLastChange"] = 12081;
    $info["shadowWarning"] = 7;
    $info["shadowInactive"] = 2;
    $info["userPassword"] = "{SHA}" . base64_encode(pack("H*", sha1($password)));
    $info["sambaNTPassword"] = $this->make_md4_password($password);
    $info["sambaLMPassword"] = crypt($password);
    $info["sambaPwdLastSet"] = time();
    $info["sambaSID"] = $this->get_samba_sid();
    $info["objectClass"] [0] = "person";
    $info["objectClass"] [1] = "organizationalPerson";
    $info["objectClass"] [2] = "inetOrgPerson";
    $info["objectClass"] [3] = "top";
    $info["objectClass"] [4] = "posixAccount";
    $info["objectClass"] [5] = "shadowAccount";
    $info["objectClass"] [6] = "sambaSamAccount";

    if ($this->bind()) {
      if (ldap_add($this->connection, "uid=$login,$racineuser", $info)) {
        $this->create_report($login,$password,$info["cn"]);
        echo "OK";
        //$this->disconnect();
        return true;
      } else {
        echo "NOK";
        //$this->disconnect();
        return false;
      }
    } else {
      echo "Erreur bind";
    }
  }

  public function del_person($uid) {
    $racineuser = "ou=people," . $this->dn;
    
    /* Suppression du user dans les groupes */
    $info = array();
    $list = $this->get_groups();
    $size = sizeof($list) - 1;
    for ($i = 0; $i < $size; $i++) {
      $list2 = $this->get_users_from_group($list[$i]);
      $size2 = sizeof($list2);
      $found=false;
      for($j=0; $j < $size2; $j++) {
        if (strcmp($size2[$j],$uid)!=0) {
          $info[] = "$list2[$j]";
        }
        else {
          $found = true;
        }
      }
      if ($found) {
        $this->modify_group($list[$i], $info);
      }
    }
   
    /* Suppression du user */
    if ($this->bind()) {
      if (ldap_delete($this->connection, "uid=$uid,$racineuser")) {
        echo "OK";
        //$this->disconnect();
        return true;
      } else {
        echo "NOK";
        //$this->disconnect();
        return false;
      }
    }
  }
  
  public function modify_group($cn, $list_users) {
    $racineuser = "ou=group," . $this->dn;
    $info = array();
    for ($i = 0; $i < sizeof($list_users); $i++) {
      $info["memberuid"] [$i] = "$list_users[$i]";
    }    
    if ($this->bind()) {
      if (ldap_modify($this->connection, "cn=$cn,$racineuser", $info)) {
        echo "OK";
        //$this->disconnect();
        return true;
      } else {
        echo "NOK";
        //$this->disconnect();
        return false;
      }
    }
  }
  
  public function make_md4_password($password) {
    $hash = strtoupper(bin2hex(mhash(MHASH_MD4, iconv("UTF-8", "UTF-16LE", $password))));
    return $hash;
  }

  public function generate_password() {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789";
    srand((double) microtime() * 1000000);
    $i = 0;
    $pass = '';
    while ($i <= 7) {
      $num = rand() % 60;
      $tmp = substr($chars, $num, 1);
      $pass = $pass . $tmp;
      $i++;
    }
    return $pass;
  }
  
  public function create_report($login,$password,$cn) {
    $cmd = 'sed -s "s;PrenomNOM;'.$cn.';" ../rapports/fiche.tex > ../rapports/fiche_'.$login.'.tex';
    system($cmd);
    $cmd = 'sed -i -s "s;Login;Login : '.$login.';" ../rapports/fiche_'.$login.'.tex';
    system($cmd);
    $cmd = 'sed -i -s "s;Motdepasse;Mot de passe : '.$password.';" ../rapports/fiche_'.$login.'.tex';
    system($cmd);
    $cmd = 'cd ../rapports && pdflatex ../rapports/fiche_'.$login.'.tex > /dev/null';
    system($cmd);
  }
}

?>
