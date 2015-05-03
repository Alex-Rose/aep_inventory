<div class="row" style="margin: 0px">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Se connecter</h3>
            </div>
            <div class="panel-body">
                <?php echo Form::open('auth/process', ['role' => 'form']);?>
                    <fieldset>
                        <div class="form-group">
                            <?php echo Form::input('email', $email, ['class' => 'form-control', 'placeholder' => 'courriel', 'type' => 'email', 'autofocus' => 'autofocus']);?>
                        </div>
                        <div class="form-group">
                            <?php echo Form::input('password', '', ['class' => 'form-control', 'placeholder' => 'Mot de passe', 'type' => 'password']);?>
                        </div>
                        <div class="form-group">
                            <?php echo $feedback;?>
                        </div>
                        <div class="form-group">
                            <?php echo Form::submit('login', 'Connexion', ['class' => 'btn-primary btn btn-lg btn-block']);?>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>