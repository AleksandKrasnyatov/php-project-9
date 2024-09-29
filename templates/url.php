<?php

use App\Url;

/**
 * @var Url $url
 * @var array $checks
 */

?>
<h1>Сайт: <?= htmlspecialchars($url->getName() ?? '')?></h1>
<div class="table-responsive">
    <table class="table table-bordered table-hover text-nowrap" data-test="url">
        <tbody>
        <tr>
            <td>ID</td>
            <td><?= $url->getId() ?></td>
        </tr>
        <tr>
            <td>Имя</td>
            <td><?= htmlspecialchars($url->getName() ?? '')?></td>
        </tr>
        <tr>
            <td>Дата создания</td>
            <td><?= htmlspecialchars($url->getDateTime() ?? '')?></td>
        </tr>
        </tbody>
    </table>
</div>
<h2 class="mt-5 mb-3">Проверки</h2>
<form method="post" action="/urls/<?= $url->getId() ?>/checks">
    <input type="submit" class="btn btn-primary" value="Запустить проверку">
</form>
<table class="table table-bordered table-hover" data-test="checks">
    <thead>
    <tr>
        <th>ID</th>
        <th>Код ответа</th>
        <th>h1</th>
        <th>title</th>
        <th>description</th>
        <th>Дата создания</th>
    </tr>
    </thead>
    <tbody>
    <!--?php foreach ($checks as $check): ?-->
    </tbody>
</table>
