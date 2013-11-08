<?php
//App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */

class User extends AppModel {
    var $name = 'User';
    
	public $validate = array(
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Un identifiant est requis',
			),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
				'message' => 'Only alphabets and numbers allowed',
            )
		),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Un mot de passe est requis'
            )
        ),
        'password2' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Un mot de passe est requis'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'user')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
	);
}
