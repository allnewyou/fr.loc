<div class="container">
    <h1><?= $title ?? ''; ?></h1>

    <?php
//    session()->set('test', 'Test sess value'); // записываем значение в сессию
//    dump(session()->get('test')); // распечатываем значение из сессии, записать и распечатать значени можно на разных страницах

    foreach ($users as $user): ?>
        <div>
        ID: <?= $user->id; ?> <br>
        Name: <?= $user->name; ?> <br>
        </div>
    <?php endforeach; ?>

    <div class="row">

            <div class="col-md-6 offset-md-3"> <!-- блок для реализации регистрации -->

                <form action="<?= base_url('/register') ?>" method="post">

                    <?= get_csrf_field() ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input name="name" type="text" class="form-control <?= get_validation_class('name')?>" id="Name" placeholder="Name" value="<?=old('name')?>">
                        <?= get_errors('name'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control <?= get_validation_class('email')?>" id="email" placeholder="name@example.com" value="<?=old('email')?>">
                        <?= get_errors('email'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control <?= get_validation_class('password')?>" id="password" placeholder="Password">
                        <?= get_errors('password'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm password</label>
                        <input name="confirmPassword" type="password" class="form-control <?= get_validation_class('confirmPassword')?>" id="confirmPassword" placeholder="Confirm Password">
                        <?= get_errors('confirmPassword'); ?>
                    </div>

                    <button type="submit" class="btn btn-warning">Register</button>

                </form>

                <?php
                session()->remove('form_data'); //методы для удаления флеш сообщений после обновления страницы
                session()->remove('form_errors');
                ?>

            </div>

    </div>
</div>