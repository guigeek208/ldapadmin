<br>
<?php echo $this->Html->css("signin.css"); ?>

<?php echo $this->Form->create('User', array('class' => 'form-signin')); ?>
<!--<h2 class="form-signin-heading">Please sign in</h2>-->
<div class="form-group">
    <?= $this->Form->input('username', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Identifiant')); ?>

</div>
<div class="form-group">
    <?= $this->Form->input('password', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Password')); ?>
</div>
<button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
<?php
/* $options = array(
  'label' => 'Se connecter',
  'class' => 'btn btn-default',
  ); */
echo $this->Form->end();
?>

