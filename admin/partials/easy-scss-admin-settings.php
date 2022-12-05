<?php

use EasyScss\Shared\EasyScssGlobals;
use EasyScss\Shared\EasyScssOptionsManager;
use EasyScss\Shared\EasyScssUtils;

$option_manager = new EasyScssOptionsManager();
$utils = new EasyScssUtils();

$entry_key = EasyScssGlobals::$option_entrypoint_key;
$destination_key = EasyScssGlobals::$option_destination_key;

$entrypoint_file_option = $option_manager->get($entry_key);
$destination_folder_option = $option_manager->get($destination_key);

$has_errors = isset($_GET['error']) && $_GET['error'] === "1";
$is_saved = isset($_GET['saved']) && $_GET['saved'] === "1";
$has_empty_values = isset($_GET['empty']) && $_GET['empty'] === "1";

?>

<div class="wrap easy-scss">

  <?php
    if ($has_errors) {
        $utils->admin_notice('error', 'There was an error while saving settings. Try Again.');
    }
    if ($is_saved) {
        $utils->admin_notice('success', 'Settings saved successfully.');
    }
    if ($has_empty_values) {
        $utils->admin_notice('error', 'All fields must not be empty.');
    }
  ?>

  <div class="page-title">
    <h1><?php echo esc_html__('Settings') ?></h1>
    <h4><?php echo esc_html__('All path must be relative to the active theme folder.') ?></h4>
  </div>
  <form action="<?php echo get_admin_url()."admin-post.php"?>" method="post">
	  <?php wp_nonce_field('save_options', 'save_options_nonce'); ?>
    <input type='hidden' name='action' value='save_options' />
    <div class="form-row">
      <label><?php echo esc_html__('Entrypoint File') ?></label>
      <input
        type="text"
        name="options[<?php echo esc_attr($entry_key) ?>]" id="entrypoint"
        value="<?php echo $entrypoint_file_option ? esc_attr($entrypoint_file_option->meta_value) : '' ?>" required
      >
    </div>
    <div class="form-row">
      <label><?php echo esc_html__('Destination Folder') ?></label>
      <input
        type="text"
        name="options[<?php echo esc_attr($destination_key) ?>]"
        value="<?php echo $destination_folder_option ? esc_attr($destination_folder_option->meta_value) : '' ?>" required
      >
    </div>
	  <?php submit_button(__('Save settings'), 'primary', 'submit', false) ?>
  </form>
</div>
