<?php require(__DIR__ . '/layouts/header.php'); ?>
<div class="row">
    <div class="col-sm-6">
        <h4>Email: <?= $row['email'] ?></h4>
        <img src="/upload/<?= $row['avatar'] ?>" alt="Avatar <?= $row['username'] ?>" width="100" class="img-circle">
    </div>
</div>
<?php require(__DIR__ . '/layouts/footer.php'); ?>