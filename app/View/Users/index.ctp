<div class="page-header">
	<h1><?php echo $this->params['controller'] ?></h1>
</div>
<?php
$dropdownUsersButtonItems = array(
    $this->Html->link(
	__('Ajouter Utilisateur'),
	array('action' => 'add_user'),
	array('escape' => false)
    ),
);

echo $this->Form->create('User', array('class' => 'form-horizontal'));
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
		<th>ID</th>
		<th>
			<?= $this->Html->link('Login',
						array(
                       'controller' => 'users',
                       'action' => 'orderlastname'
                   ),
                   array('escape' => false)
        	); ?>
      </th>
		<th>
			<?= $this->Html->link(
                   'Role',
                   array(
                       'controller' => 'users',
                       'action' => 'orderfirstname'
                   ),
                   array('escape' => false)
          ); ?>
      </th>
		<tr>
			<?php
				foreach ($data['entries'] as $entry) {
					echo "<tr>";
					echo "<td>".$this->Form->checkbox($entry['User']['id'], array('hiddenField' => false))."</td>";
					echo "<td>".$entry['User']['id']."</td>";
					echo "<td>".$entry['User']['username']."</td>";
					echo "<td>".$entry['User']['role']."</td>";
					echo "</tr>";
				}
			?>
		<tr>
		</tr>
</table>
<?php
$options = array();/*
	'label' => 'Supprimer',
	'class' => 'btn btn-default',
);*/
echo $this->Form->end(); 
?>
