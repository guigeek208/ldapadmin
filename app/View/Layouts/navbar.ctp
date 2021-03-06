<?php

if ($this->Session->read('Auth.User')) {
    echo '<div class="collapse navbar-collapse">' .
    '<ul class="nav navbar-nav">';
    if ($this->params['controller'] == "ldapusers") {
        echo '<li class="active">';
    } else {
        echo '<li>';
    }
    echo $this->Html->link(
            '<span class="glyphicon glyphicon-user"></span> Utilisateurs LDAP', array(
        'controller' => 'ldapusers',
        'action' => 'index'
            ), array('escape' => false)
    );

    if ($this->params['controller'] == "Ldapgroups" && $this->params['controller'] == "index") {
        echo '<li class="active">';
    } else {
        echo '<li>';
    }
    echo $this->Html->link(
            '<span class="glyphicon glyphicon-user"></span> Groupes LDAP', array(
        'controller' => 'ldapgroups',
        'action' => 'index'
            ), array('escape' => false)
    );

    echo '</ul>' .
    '<ul class="nav navbar-nav navbar-right">';
    if ($this->params['controller'] == "users") {
        echo '<li class="dropdown active">';
    } else {
        echo '<li class="dropdown">';
    }
    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . __('%s', $this->Session->read('Auth.User.username')) . '<b class="caret"></b></a>' .
    '<ul class="dropdown-menu">';

    echo '<li>' .
    $this->Html->link(
            '<span class="glyphicon glyphicon-wrench"></span> ' .
            __('Pr&eacute;f&eacute;rences'), array(
        'controller' => 'users',
        'action' => 'settings'
            ), array('escape' => false)
    ) .
    '</li>';
    echo '<li>' .
    $this->Html->link(
            '<span class="glyphicon glyphicon-user"></span> ' .
            __('Utilisateurs '), array(
        'controller' => 'users',
        'action' => 'index'
            ), array('escape' => false)
    ) .
    '</li>';
    echo '<li>' .
    $this->Html->link(
            '<span class="glyphicon glyphicon-off"></span> ' .
            __('Logout '), array(
        'controller' => 'users',
        'action' => 'logout'
            ), array('escape' => false)
    ) .
    '</li>';
    echo '</ul>' .
    '</div><!--/.nav-collapse -->    ';
}
?>