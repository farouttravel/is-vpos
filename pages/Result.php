<div class="mb-2">
    <?php if (in_array($_POST["mdStatus"], ['1', '2', '3', '4'])) : ?>
        <span class="label label-success">3D Success</span>
    <?php else : ?>
        <span class="label label-danger">3D Failed</span>
    <?php endif; ?>
    <br />
    <?php if ($_POST["Response"] == "Approved") : ?>
        <span class="label label-success">Payment Success</span>
    <?php else : ?>
        <span class="label label-danger">Payment Failed</span>
    <?php endif; ?>
    <br />
    <br />
</div>
<div class="table-responsive">
    <table class="table">
        <tr>
            <td colspan="2">
                <h1>POST Parameters</h1>
            </td>
        </tr>
        <tr>
            <td style="text-align: right"><b>Name</b></td>
            <td style="text-align: left"><b>Value</b></td>
        </tr>
        <?php foreach ($_POST as $key => $value) : ?>
            <tr>
                <td><?= $key; ?></td>
                <td><?= $value; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>