    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <!-- jQuery -->
    <script src="<?=base_url()?>assets/plugins/js/jquery.min.js"></script>
    <!-- popper -->
    <script src="<?=base_url()?>assets/plugins/js/popper.min.js"></script>
    <!-- bootstrap -->
    <script src="<?=base_url()?>assets/plugins/js/bootstrap.min.js"></script>
    <!-- validator -->
    <script src="<?=base_url()?>assets/plugins/js/jquery.validate.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/pushnotification/jquery.pushNotification.js"></script>
    <!-- Custom Scripts-->
    <script src="<?=base_url()?>assets/js/scripts.js"></script>

    <?= (isset($other_script)) ? $other_script: ''?>

</body>

</html>