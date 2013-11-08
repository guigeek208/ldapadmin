<?php
$title = isset($title) ? $title : __('Editer un utilisateur');
?>
<div class="page-header">
    <h2><?php echo __('Editer '); echo $data['LdapUser']['uid'] ?></h2>
</div>
<?= $this->Form->create('LdapUser', array('class' => 'form-horizontal', 'inputDefaults' => array(
    'label' => array('class' => 'control-label'),
    //'between' => '<div class="controls">',
    //'after' => '</div>',
    'class' => 'form-control',
    'error' => array('attributes' => array('id' => 'input-error'))
))); ?>
<?= $this->Form->input('uidnumber', array('label' => false, 'class' => 'form-control', 'type' => 'hidden', 'value' => $data['LdapUser']['uidnumber'])); ?>
<div class="form-group">
    <label for="inputLogin1" class="col-lg-4 control-label">Pr&eacute;nom </label>
    <div class="col-lg-6">
        <?= $this->Form->input('firstname', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Prenom', 'value' => $data['LdapUser']['givenname'])); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputLogin1" class="col-lg-4 control-label">Nom </label>
    <div class="col-lg-6">
        <?= $this->Form->input('lastname', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Nom', 'value' => $data['LdapUser']['sn'])); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputPassword1" class="col-lg-4 control-label">Mot de passe </label>
    <div class="col-lg-6">
        <?= $this->Form->input('password', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Mot de passe', 'value' => '0000000000')); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputPassword2" class="col-lg-4 control-label">Mot de passe (confirmation) </label>
    <div class="col-lg-6">
        <?php echo $this->Form->input('password2', array('type' => 'password', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Mot de passe', 'value' => '0000000000')); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-lg-offset-4 col-lg-6">
        <?php
        $options = array(
            'label' => 'Modifier',
            'class' => 'btn btn-default',
        );
        //echo $this->Form->submit();
        echo $this->Form->end($options);
        ?>      
    </div>
</div>

</div>