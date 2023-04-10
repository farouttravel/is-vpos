<?php /** @var array $pageData */ ?>

<h2>Review</h2>

<form method="post" action="<?= $_POST['vpos']['action'] ?>">
    <table class="table table-hover">
        <tr>
            <th>Data Name</th>
            <th>Value</th>
        </tr>
        <?php foreach ($_POST['vpos']['fields'] as $name => $value) : ?>
            <?php if (!empty($value) || $name == 'taksit') : ?>
                <tr>
                    <td><?= $name ?></td>
                    <td><?= $value ?></td>
                    <input type="hidden" name="<?= $name ?>" value="<?= $value ?>"/>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td>rnd</td>
            <td><?= $pageData['random'] ?></td>
            <input type="hidden" name="rnd" value="<?= $pageData['random'] ?>"/>
        </tr>
        <tr>
            <td>hash</td>
            <td><?= $pageData['hash'] ?></td>
            <input type="hidden" name="hash" value="<?= $pageData['hash'] ?>"/>
        </tr>
    </table>

    <button type="button" onclick="history.back();return false;" class="btn btn-danger">Back</button>
    <button type="submit" class="btn btn-primary">Proceed</button>
</form>