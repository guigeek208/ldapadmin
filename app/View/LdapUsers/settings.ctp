<p></p>
<div class="col-md-4 well well-lg">
    <h5><b>Changement du mot de passe</b></h5>
    <?= $this->Form->create('ParamPassUser', array('class' => 'form-horizontal')); ?>
    <div class="form-group">

        <?= $this->Form->input('password', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Password')); ?>

    </div>
    <div class="form-group">

        <?= $this->Form->input('password2', array('type' => 'password', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Password (confirmation)')); ?>

    </div>
    <?php
    $options = array(
        'label' => 'Appliquer',
        'class' => 'btn btn-default',
    );
    echo $this->Form->end($options);
    ?>
</div>