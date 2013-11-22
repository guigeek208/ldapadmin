<div class="page-header">
    <h1><?php echo $this->params['controller'] ?></h1>
</div>
<?php
$dropdownUsersButtonItems = array(
    $this->Html->link(
            __('Ajouter Groupe'), array('action' => 'add'), array('escape' => false)
    ),
);

echo $this->Form->create('Ldapgroup', array('class' => 'form-horizontal', 'action' => 'del'));
//echo $this->request->query['page'];
echo $this->element('dropdownButton', array(
    'buttonCount' => 1,
    'class' => 'btn-primary',
    'title' => __('Actions'),
    'icon' => 'glyphicon-user',
    'items' => $dropdownUsersButtonItems,
));
?>
<button type="submit" class="btn btn-default">Supprimer</button>
<p></p>

<table class="table table-striped table-condensed">
    <th></th>
    <th>
<?php
echo $this->Html->link('Cn', array(
    'controller' => 'users',
    'action' => 'orderlastname'
        ), array('escape' => false)
);
?>
    </th>
    <th>
<?php
echo $this->Html->link(
        'GidNumber', array(
    'controller' => 'users',
    'action' => 'orderfirstname'
        ), array('escape' => false)
);
?>
    </th>
    <tr>
<?php
foreach ($ldap_groups as $key => $value) {
    echo "<tr>";
    echo "<td>" . $this->Form->checkbox($value['LdapUser']['gidnumber'], array('hiddenField' => false)) . "</td>";
    echo "<td>";
    echo $this->Html->link($value['LdapUser']['cn'], array(
        'controller' => 'Ldapgroups',
        'action' => 'edit/'.$value['LdapUser']['cn']
            ), array('escape' => false)
    );
    // .$value['LdapUser']['uid']."</td>";
    echo "</td>";
    echo "<td>" . $value['LdapUser']['gidnumber'] . "</td>";
    echo "</tr>";
}
?>
    <tr>
    </tr>
</table>
        <?php
        $options = array(); /*
          'label' => 'Supprimer',
          'class' => 'btn btn-default',
          ); */
        echo $this->Form->end();
        ?>
