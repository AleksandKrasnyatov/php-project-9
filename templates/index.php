<?php

use App\Url;

/**
 * @var Url $url
 * @var array $errors
 */

?>
<h1></h1>
<div class="row">
    <div class="col-12 col-md-10 col-lg-8 mx-auto border rounded-3 bg-light p-5">
        <h1 class="display-3">Анализатор страниц</h1>
        <p class="lead">Бесплатно проверяйте сайты на SEO пригодность</p>
        <form action="/urls" method="post" class="row" required>
            <div class="col-8">
                <label for="text" class="visually-hidden">Url для проверки</label>
                <input type="text" name="url[name]" value="<?= htmlspecialchars($url->getName() ?? '') ?>" class="form-control form-control-lg" placeholder="https://www.example.com">
                <?php if (isset($errors['name'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['name'] ?>
                    </div>
                <?php endif ?>
            </div>
            <div class="col-2">
                <input type="submit" class="btn btn-primary btn-lg ms-3 px-5 text-uppercase mx-3" value="Проверить">
            </div>

        </form>

    </div>
</div>
