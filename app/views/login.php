<?php require(__DIR__ . '/layouts/header.php'); ?>
<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <?php if (isset($_SESSION['error'])): ?>
            <div>
                <ul>
                    <?php foreach($_SESSION['error'] as $key => $value): ?>
                        <li><?= $key ?> - <?= $value ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <form class="form-horizontal" data-toggle="validator" method="post" id="login-form">
            <?php if ( isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru'): ?>
                <div class="form-group">
                    <label for="email" class="col-lg-2 control-label">Email</label>
                    <div class="col-lg-10">
                        <input type="email" class="form-control" name="email" 
                        id="email" placeholder="Email">
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-lg-2 control-label">Пароль</label>
                    <div class="col-lg-10">
                        <input type="password" class="form-control" name="password" 
                        id="password" placeholder="Пароль">
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-default">Войти</button>
                    </div>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label for="email" class="col-lg-2 control-label">Email</label>
                    <div class="col-lg-10">
                        <input type="email" class="form-control" name="email" 
                        id="email" placeholder="Email">
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-lg-2 control-label">Password</label>
                    <div class="col-lg-10">
                        <input type="password" class="form-control" name="password" 
                        id="password" placeholder="Password">
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-default">Login</button>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>
<?php require(__DIR__ . '/layouts/footer.php'); ?>
