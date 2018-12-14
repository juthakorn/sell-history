<div id="res2"></div>
<?php if (isset($_SESSION['message'])) { ?>
    <div id="message" class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?= $_SESSION['message']['text'] ?>
    </div>

<script>
    $(function () {
        setTimeout(function () {
            $('#message').fadeOut('slow');
        }, 5000);
    });
</script>
<?php
    unset($_SESSION['message']);
} 
?>