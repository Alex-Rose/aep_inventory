<div class="row" style="margin: 0px">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Réinitialisation de mot de passe</h3>
            </div>
            <div class="panel-body">
                <?php echo Form::open('auth/processReset', ['role' => 'form']);?>
                <fieldset>
                    <?php echo Form::hidden('activation', $activation);?>
                    <?php echo Form::hidden('email', $email);?>
                    <div class="form-group">
                        <?php if(isset($feedback)) echo $feedback;?>
                    </div>
                    <div class="form-group">
                        <?php echo Form::input('password', '', ['class' => 'form-control', 'placeholder' => 'Mot de passe', 'type' => 'password', 'autofocus' => 'autofocus']);?>
                    </div>
                    <div class="form-group">
                        <?php echo Form::input('password2', '', ['class' => 'form-control', 'placeholder' => 'Valider le mot de passe', 'type' => 'password']);?>
                    </div>
                    <div class="form-group">
                        <?php echo Form::submit('reset', 'Enregistrer', ['class' => 'btn-primary btn btn-lg btn-block']);?>
                    </div>
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>