<?php

use App\Url;

/**
 * @var Url[] $urls
 */

?>
<h1>Сайты</h1>
<div class="table-responsive">
    <table class="table table-bordered table-hover text-nowrap" data-test="urls">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Последняя проверка</th>
            <th>Код ответа</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($urls as $url): ?>
        <tr>
            <td><?= $url->getId() ?></td>
            <td>
                <a href="/urls/<?= $url->getId() ?>">
                    <?= htmlspecialchars($url->getName() ?? '') ?>
                </a>
            </td>
            <td><?= htmlspecialchars($url->getLastCheckedAt() ?? '') ?></td>
            <td><?= htmlspecialchars($url->getStatus() ?? '') ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
