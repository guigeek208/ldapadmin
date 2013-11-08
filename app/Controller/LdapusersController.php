<?php

class LdapUsersController extends AppController {

    var $name = 'LdapUsers';
    var $uses = array('LdapUser');

    function index() {
        $users = $this->LdapUser->findAll('uid', '*');
        $this->set('ldap_users', $users);
    }

    function add() {
        //debug($this->request->data);
        if (!empty($this->request->data)) {
            if ($this->request->data['LdapUser']['password'] != $this->request->data['LdapUser']['password2']) {
                $this->Session->setFlash(__('Mots de passe différents'), 'flash_alerts', array('class' => 'danger'));
            } else {
                $this->LdapUser->set($this->request->data);
                if ($this->LdapUser->validates($this->request->data)) {
                    if ($this->LdapUser->save($this->data)) {
                        $this->Session->setFlash(__('Utilisateur LDAP ajouté'), 'flash_alerts', array('class' => 'success'));
                        $this->redirect('/ldapusers/index');
                    } else {
                        if (is_object($this->Session)) {
                            $this->Session->setFlash(__('Merci de corriger les erreurs'), 'flash_alerts', array('class' => 'danger'));
                        }
                        $data = $this->data;
                        $this->set('ldap_users', $data);
                    }
                } else {
                    $this->Session->setFlash(__('Merci de corriger les erreurs'), 'flash_alerts', array('class' => 'danger'));
                }
            }
        }
    }

    function edit($uid) {
        debug($this->request->data);
        $this->set('uid', $uid);
        $data = $this->LdapUser->read(null, $uid);
        debug($data);
        $this->set('data', $data);
        if (!empty($this->request->data)) {
            if ($this->request->data['LdapUser']['password'] != $this->request->data['LdapUser']['password2']) {
                $this->Session->setFlash(__('Mots de passe différents'), 'flash_alerts', array('class' => 'danger'));
            } else {
                $this->LdapUser->set($this->request->data);
                if ($this->LdapUser->validates($this->request->data)) {
                    debug($this->data);
                    $this->LdapUser->del($uid);
                    if ($this->LdapUser->save($this->data)) {
                        $this->Session->setFlash(__('Utilisateur LDAP modifié'), 'flash_alerts', array('class' => 'success'));
                        $this->redirect('/ldapusers/index');
                    } else {
                        $this->Session->setFlash(__('Merci de corriger les erreurs'), 'flash_alerts', array('class' => 'danger'));
                    }
                }
            }
        }
        
        /*if (empty($this->request->data)) {
            $data = $this->LdapUser->read(null, $id);
            $this->set('ldap_user', $data);
        } else {
            $this->LdapUser->del($id);
            if ($this->LdapUser->save($this->data)) {
                if (is_object($this->Session)) {
                    $this->Session->setFlash(__('Utilisateur LDAP modifié'), 'flash_alerts', array('class' => 'success'));
                    $this->redirect('/ldap_users/index');
                } else {
                    $this->Session->setFlash(__('Merci de corriger les erreurs'), 'flash_alerts', array('class' => 'danger'));
                }
            } else {
                if (is_object($this->Session)) {
                    $this->Session->setFlash(__('Merci de corriger les erreurs'), 'flash_alerts', array('class' => 'danger'));
                }
                $data = $this->data;
                $this->set('ldap_user', $data);
            }
        }*/
    }

    function view($uid) {
        $this->set('ldap_user', $this->LdapUser->read(null, $uid));
    }

    function del() {
        foreach ($this->data['Ldapuser'] as $key => $value) {
            $this->LdapUser->del($key);
        }
        $this->Session->setFlash(__('Utilisateur effacé'), 'flash_alerts', array('class' => 'success'));
        $this->redirect('/ldapusers/index');
    }

}

?> 