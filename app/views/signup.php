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
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">
            <?php if ( isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru'): ?>
                <div class="form-group">
                    <label for="username">Имя</label>
                    <input type="text" class="form-control" name="username" 
                    id="username" placeholder="Имя" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" 
                    id="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" name="password" 
                    id="password" placeholder="Пароль" required>
                </div>
                <div class="form-group">
                    <label for="avatar">Аватар</label>
                    <input type="file" id="avatar" name="avatar" required>
                </div>
                
                <button type="submit" class="btn btn-default">Зарегистрироватся</button>
            <?php else: ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" 
                    id="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" 
                    id="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" 
                    id="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="avatar">Avatar</label>
                    <input type="file" id="avatar" name="avatar" required>
                </div>
                
                <button type="submit" class="btn btn-default">Sign Up</button>
            <?php endif; ?>
            
        </form>
    </div>
</div>
<?php require(__DIR__ . '/layouts/footer.php'); ?>