<input class="span3" placeholder="NIK" type="text" name="txt_nik" >
<input class="span3" placeholder="Password" type="password" name="txt_pass">
<button class="btn-info btn" type="submit">Login</button>
<?php echo anchor($switch, $switch_text, 'class="btn btn-link"');?>
</form>
</div>
</div>
</div>
      <hr>

      <footer>
        <p>&copy; CHR 2013</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url()?>assets/jquery.js"></script>
    <script src="<?php echo base_url()?>assets/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/fancybox/jquery.fancybox.js"></script>
    <script src="<?php echo base_url()?>assets/datatable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url()?>assets/datatable/DT_bootstrap.js"></script>
    <script src="<?php echo base_url()?>assets/fancybox/setup.js"></script>
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

 <script type="text/javascript"> var $ = jQuery.noConflict(); $(document).ready(function() { $('#myCarousel').carousel({ interval: 5000, cycle: true }); }); </script>