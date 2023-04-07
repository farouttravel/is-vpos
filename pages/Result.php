<?php
if (($_POST["3DStatus"] == "1")) {
    ?>
    <h2><b>3D Kullanici Dogrulama Basarili</b></h2>
    <?php
} else {
    ?>
    <h2><b>3D Kullanici Dogrulama Hatali.</b></h2>
    <?php
}
?>
<?php
if (($_POST["ProcReturnCode"] == "00")) {
    ?>
    <h2><b> Odeme Basarili.</b></h2>
    <?php
} else {
    ?>
    <h2><b> Odeme Hatali.</b></h2>
    <?php
}
?>
<table class="table">
    <tr>
        <td colspan="2">
            <h1>PayFor - Donus Parametreleri</h1>
        </td>
    </tr>
    <tr>
        <td style="text-align: right"><b>Parametre Adi</b></td>
        <td style="text-align: left"><b>Parametre Degeri</b></td>
    </tr>
    <?php
    foreach ($_POST as $key => $value) {
        echo "<tr><td style='text-align: right'>" . $key . "</td><td style='text-align: left'>" . $value . "</td></tr>";
    }
    ?>
</table>