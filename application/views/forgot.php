<div class="row" style="margin: 0px">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Mot de passe oublié</h3>
            </div>
            <div class="panel-body">
                <?php echo Form::open('auth/sendReset', ['role' => 'form']);?>
                <fieldset>
                    <div class="form-group">
                        Entrez votre adresse courriel pour réinitialiser votre mot de passe.
                    </div>
                    <div class="form-group">
                        <?php echo Form::input('email', $email, ['class' => 'form-control', 'placeholder' => 'courriel', 'type' => 'email', 'autofocus' => 'autofocus']);?>
                    </div>
                    <div class="form-group feedback">
                        <?php if (isset($feedback)) echo $feedback;?>
                    </div>
                    <div class="form-group">
                        <?php echo Form::submit('login', 'Envoyer', ['class' => 'btn-primary btn btn-lg btn-block']);?>
                    </div>
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
       $('input:submit').click(function(e){
           e.preventDefault();

           var url = $(this).closest('form').attr('action');
           var email = $('input[name=email]').val();

           $.ajax({
               type: 'POST',
               url: url,
               data: {email: email}
           }).done(function(msg){
               $('div.feedback').html(msg);
           });
       });
    });
</script>
