
<?php /** @var \Vpos\Core $app */ ?>

<?php include_once 'header.html'; ?>

<div class="container">
    <div class="page-header text-left">
        <table class="table table-hover ">
            <tr>
                <td>
                    <h1>Isbank</h1>
                </td>
                <td>
                    <h1>Test Scripts</h1>
                </td>
            </tr>
        </table>
        <nav class="text-left">
            <a href="/">List</a>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <?php $app->load(); ?>
        </div>
    </div>
</div>

<?php include_once 'footer.html'; ?>