<p></p>
<div class="col-md-12 well well-lg">
    <h5><b>Changement du mot de passe</b></h5>
    <?= $this->Form->create('User', array('class' => 'form-horizontal')); ?>
    <div class="form-group">
    <label for="inputPassword1" class="col-lg-4 control-label">Mot de passe </label>
    <div class="col-lg-6">
        <?= $this->Form->input('password', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Password')); ?>
    </div>
    </div>
    
    <div class="form-group">
    <label for="inputPassword2" class="col-lg-4 control-label">Mot de passe (confirmation) </label>
    <div class="col-lg-6">
        <?= $this->Form->input('password2', array('type' => 'password', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Password')); ?>
    </div>
    </div>
    <?php
    $options = array(
        'label' => 'Appliquer',
        'class' => 'btn btn-default',
    );
    echo $this->Form->end($options);
    ?>
</div>
</div>
