      <hr>

      <footer>
        <p>&copy; CHR 2013-2016</p>

      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url()?>assets/jquery.min.js"></script>

    <script src="<?php echo base_url()?>assets/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/bootstrap/switch.min.js"></script>
    <script src="<?php echo base_url()?>assets/jqBootstrap-validation/jqBootstrapValidation.min.js"></script>

    <script src="<?php echo base_url()?>assets/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/datetimepicker/default.min.js"></script>

    <script src="<?php echo base_url()?>assets/datatable/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>assets/datatable/DT_bootstrap.min.js"></script>

    <script src="<?php echo base_url()?>assets/custom_js/jquery.submit-button.min.js"></script>


    <?php
      if(isset($js_list))
      {
        foreach ($js_list as $key_element => $js_path) {
          echo '<script src="'.base_url().'assets/'.$js_path.'.js"></script>';
        }
      }
    ?>
  </body>
</html>
<script>
 $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation({
  preventSubmit: true,
  sniffHtml: true
 }); });
</script>
