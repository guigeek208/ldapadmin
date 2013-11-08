<?php
$title = isset($title) ? $title : __('Ajouter un utilisateur');
?>
<div class="page-header">
    <h2><?= __('Ajouter un utilisateur') ?></h2>
</div>

<?= $this->Form->create('User', array('class' => 'form-horizontal', 'inputDefaults' => array(
    'label' => array('class' => 'control-label'),
    //'between' => '<div class="controls">',
    //'after' => '</div>',
    'class' => 'form-control',
    'error' => array('attributes' => array('id' => 'input-error'))
))); ?>
<div class="form-group">
    <label for="inputLogin1" class="col-lg-4 control-label">Identifiant </label>
    <div class="col-lg-6">
        <?= $this->Form->input('username', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Identifiant'));//, 'error' => array('attributes' => array('wrap' => 'span', 'id' => 'input-error', 'placeholder' => 'toto')))); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputPassword1" class="col-lg-4 control-label">Password </label>
    <div class="col-lg-6">
        <?= $this->Form->input('password', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Password')); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputPassword2" class="col-lg-4 control-label">Password (confirmation) </label>
    <div class="col-lg-6">
        <?php echo $this->Form->input('password2', array('type' => 'password', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Password')); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputRole1" class="col-lg-4 control-label">Role </label>
    <div class="col-lg-6">
        <?= $this->Form->select('role', array("user" => "utilisateur", "admin" => "admin"), array('class' => 'form-control', 'value' => '0', 'esĉape' => false, 'empty' => false)); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-lg-offset-4 col-lg-6">
        <?php
        $options = array(
            'label' => 'Ajouter',
            'class' => 'btn btn-default',
        );
        //echo $this->Form->submit();
        echo $this->Form->end($options);
        ?>      
    </div>
</div>

</div>

