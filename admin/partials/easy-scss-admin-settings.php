<?php ?>

<div class="wrap easy-scss">
  <div class="page-title">
    <h1>Settings</h1>
    <h4>All path must be relative to the active theme folder.</h4>
  </div>
  <form action="<?php echo get_admin_url()."admin-post.php"?>" method="post">
    <div class="form-row">
      <label><?php echo esc_html__('Entrypoint File') ?></label>
      <input type="text" name="options[entrypoint_file]" id="entrypoint">
    </div>
    <div class="form-row">
      <label><?php echo esc_html__('Destination Folder') ?></label>
      <input type="text" name="options[destination_folder]" id="destination-folder">
    </div>
	  <?php submit_button(__('Save settings'), 'primary', 'submit', false) ?>
  </form>
</div>
