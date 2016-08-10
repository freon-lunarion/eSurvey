    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    

    <script src="<?php echo base_url()?>assets/jquery.js"></script>
    <script src="<?php echo base_url()?>assets/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/datatable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url()?>assets/datatable/DT_bootstrap.js"></script>
    <script src="<?php echo base_url()?>assets/custom_js/jquery.numeric-only.js"></script>
    <script src="<?php echo base_url()?>assets/custom_js/jquery.price_format.js"></script>
    <script src="<?php echo base_url()?>assets/custom_js/jquery.submit-button.js"></script>  

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
<script type="text/javascript">
  $(document).ready(function () {
    $('.masking-float').priceFormat({
      prefix: '',
      clearPrefix: true
    });
    $('.masking-integer').priceFormat({
      prefix: '',
      clearPrefix: true,
      centsLimit: 0
    });
  });
</script>