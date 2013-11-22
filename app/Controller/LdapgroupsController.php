<?php

class LdapGroupsController extends AppController {

    var $name = 'LdapGroups';
    var $uses = array('LdapUser');

    function index() {
        $groups = $this->LdapUser->findAllGroups('gidNumber', '*');
        debug($groups);
        $this->set('ldap_groups', $groups);
        debug($this->LdapUser->get_users_from_group("grp_users"));
    }
}
?>