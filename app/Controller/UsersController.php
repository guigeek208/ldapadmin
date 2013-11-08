<?php

class UsersController extends AppController {

    public $uses = array('User');

    public function login() {
        //$this->layout = "login";   
        if (!empty($this->request->data)) {
            if ($this->Auth->login()) {
                return $this->redirect('/ldapusers/index');
            }
        }
    }

    public function logout() {
        $this->Auth->logout();
        return $this->redirect('/');
    }

    public function index() {
        $d = array();
        $d['entries'] = $this->User->find('all');
        $this->set('data', $d);
        if (!empty($this->request->data)) {
            foreach ($this->request->data['User'] as $key => $value) {
                $this->User->delete($key);
                $this->Session->setFlash(__('Utilisateur effacé'), 'flash_alerts', array('class' => 'success'));
            }
            $this->redirect(array('action' => 'index'));
        }
    }

    public function add_user() {
        //debug($this->request->data);
        if (!empty($this->request->data)) {
            if ($this->request->data['User']['password'] != $this->request->data['User']['password2']) {
                $this->Session->setFlash(__('Mots de passe différents'), 'flash_alerts', array('class' => 'danger'));
            } else {
                $this->User->set($this->request->data);
                if ($this->User->validates($this->request->data)) {

                    //if (!$this->User->save($this->request->data)) {
                    $data = array('User' => array('username' => $this->request->data['User']['username'],
                            'password' => $this->request->data['User']['password'],
                            'role' => $this->request->data['User']['role'],
                    ));
                    if (!$this->User->save($this->request->data, true, array('username', 'password', 'role'))) {
                        $this->Session->setFlash(__('Merci de corriger les erreurs'), 'flash_alerts', array('class' => 'danger'));
                    } else {
                        $this->Session->setFlash(__('Utilisateur ajouté'), 'flash_alerts', array('class' => 'success'));
                        $this->redirect(array('action' => 'index'));
                    }
                } else {
                    debug($errors = $this->User->validationErrors);
                    $this->Session->setFlash(__('Merci de corriger les erreurs'), 'flash_alerts', array('class' => 'danger'));
                }
            }
        }
    }

    public function settings() {
        if (!empty($this->request->data)) {
            if ($this->request->data['User']['password'] != $this->request->data['User']['password2']) {
                //$this->Session->setFlash(__('<div class="alert alert-danger">Mots de passe différents</div>'));
                $this->Session->setFlash('Mots de passe différents', 'flash_alerts', array('class' => 'danger'));
            } else {
                $this->User->set($this->request->data);
                if ($this->User->validates($this->request->data)) {
                    $hashedPassword = Security::hash($this->request->data['User']['password'], NULL, true);
                    if ($this->User->updateAll(
                        array('User.password' => "'$hashedPassword'"),
                        array('User.username' => $this->Session->read('Auth.User.username'))
                    )) {
                        $this->Session->setFlash(__('Changement du mot de passe effectué'), 'flash_alerts', array('class' => 'success'));
                    }
                    else {
                        $this->Session->setFlash(__('Erreur'), 'flash_alerts', array('class' => 'danger'));
                    }
                } else {
                    $this->Session->setFlash(__('Merci de corriger les erreurs'), 'flash_alerts', array('class' => 'danger'));
                }
            }
        }
    }

}

?>
