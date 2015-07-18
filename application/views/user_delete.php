<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?php
            if ($user->loaded())
            {
                echo 'Êtes-vous sûr de vouloir supprimer cet utilisateur? ';
        ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-3">
        <button class="btn btn-danger col-lg-12 delete" data-url="<?php echo URL::site('adminWeb/deleteUser/'.$user->pk());?>">Supprimer</button>
    </div>
    <div class="col-lg-3">
        <button class="btn btn-default col-lg-12 cancel">Annuler</button>
    </div>
</div>
        <?php
            }
            else
            {
                echo Helper_Alert::danger('L\'utilisateur n\'existe pas', false);
                echo '</div></div>';
            }

            echo '<input type="hidden" id="listURL" value="'.URL::site('user/list').'" />';
    ?>

<div class="row">
    <div class="col-lg-3" id="feedback">
    </div>
</div>

<script>
    $('button.cancel').click(function(){
        window.history.back();
    });

    $('button.delete').click(function(){
        var userList = $('#listURL').val();
        var url = $(this).attr('data-url');

        $.ajax({
            url: url,
            method: 'GET',
            cache: false
        }).done(function(data){
            if (data.success == true){
                window.location.href = userList;
            }
            else
            {
                $('#feedback').html(data.feedback);
            }
        })

    });
</script>
