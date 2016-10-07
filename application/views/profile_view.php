<?php  extract($data['user']) ?>
<script>
  $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
</script>
<div class="col-lg-6">
    <form class="form-horizontal" method="post" action="/user/settingsUpdate">
        <fieldset>
            <legend>Настройки профиля</legend>
            <div class="form-group">
                <label for="login" class="col-lg-2 control-label">Имя</label>
                <div class="col-lg-10">
                    <input required type="text" class="form-control" name="login" id="login" placeholder="Имя" value="<?php echo $login ?>">
                    <p class="help-block"></p>
                </div>
            </div>
            <div class="control-group form-group">
                <label for="pwd" class="col-lg-2 control-label">Пароль</label>
                <div class="col-lg-10">
                    <input required type="password" class="form-control" name="pwd" id="pwd" placeholder="Пароль" value="<?php echo $pwd ?>">
                    <p class="help-block"></p>
                </div>
            </div>   
            <div class="control-group form-group">
                <label  for="email" class="col-lg-2 control-label">E-mail</label>
                <div class="col-lg-10">
                    <input data-validation-email-message="Неверный email адрес" aria-invalid="true" required type="email" class="form-control" name="email" id="email" placeholder="E-mail" value="<?php echo $email ?>">
                    <p class="help-block"></p>
                </div>
            </div>   
            <div class="col-lg-10 col-lg-offset-2">                
                <button type="submit" class="btn btn-primary">Сохранить<div class="ripple-wrapper"></div></button>
                <a href="/user" class="btn btn-default">Назад</a>
            </div>
        </fieldset>
    </form>
</div>
