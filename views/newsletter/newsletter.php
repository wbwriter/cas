<?php
include_once ROOT_DIR.'views/header.inc';
?>

<div class="cwell">
    <!-- Contact form -->
    <h3 class="title">Newsletter</h3>
    <div class="form">

        <div class="alert alert-danger" style="display: <?php echo $this->vars['display_error']['general'] ?> ">
            <strong>Erreur! </strong> Un ou plusieurs champs sont invalides.
        </div>

        <form class="form-horizontal" method="post" action="<?php echo URL_DIR.'newsletter/sendnewsletter' ?>">
            <!-- Name -->
            <div class="form-group">
                <label class="control-label col-md-2" for="name">Sujet</label>
                <div class="col-md-9">
                    <small style="color: red; display: <?php echo $this->vars['display_error']['subject'] ?> ">Assurez-vous que le sujet n'est pas vide et qu'il n'excède pas 120 caractères.</small>
                    <input type="text" class="form-control" maxlength="120" required name="subject" id="subject" value="<?php echo $this->vars['subject']; ?>">
                </div>
            </div>
            <!-- Message -->
            <div class="form-group">
                <label class="control-label col-md-2" for="message">Message</label>
                <div class="col-md-9">
                    <small style="color: red; display: <?php echo $this->vars['display_error']['message'] ?> ">Assurez-vous que le message n'est pas vide et qu'il n'excède pas 3000 caractères.</small>
                    <textarea class="form-control" required minlength="10" maxlength="3000" id="message" name="message" rows="6"><?php echo $this->vars['message']; ?></textarea>
                </div>
            </div>
            <!-- Buttons -->
            <div class="form-group">
                <!-- Buttons -->
                <div class="col-md-10 col-md-offset-2">
                    <button type="submit" class="btn btn-info">Envoyer la newsletter <i class="fa fa-envelope" aria-hidden="true"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php
include_once ROOT_DIR.'views/footer.inc';
?>