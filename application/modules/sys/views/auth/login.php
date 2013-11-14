<link href="<?php echo assets('login.css', ASSET_TYPE_CSS); ?>" rel="stylesheet">
<div class="container">
    <form class="form-signin" method="post">
        <h2 class="form-signin-heading"><?php echo $this->lang->line('msg_please_sign_in');?></h2>
        <?php if (isset($status) AND ($status == FALSE) AND (isset($msg)) AND (!empty($msg)) ): ?>
        <div class="alert alert-danger"><?php echo $msg; ?></div>
        <?php endif; ?>
        <input type="text" name="username" value="" class="form-control" placeholder="Username" required autofocus>
        <input type="password" name="password" value="" class="form-control" placeholder="Password" required>
        <label class="checkbox"><input type="checkbox" value="remember-me"><?php echo $this->lang->line('lbl_remember_me'); ?></label>
        <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $this->lang->line('lbl_sign_in');?></button>
        <div style="margin-top: 40px; text-align: center;">
            <span class="pull-left">
                <span class="dropdown">
                    <a href="<?php echo create_url('login'); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo current_language() ? current_language() : $this->lang->spanne('lbl_language'); ?> <b class="caret"></b></a>
                    <div class="dropdown-menu">
                        <?php foreach (config_item('language_array') as $key => $value) : ?>
                        <div><a href="<?php echo current_url_with_params(array('language' => $key)); ?>"><?php echo $value;?></a></div>
                        <?php endforeach; ?>
                    </div>
                </span>
            </span>
            <span class="pull-right">
                <a href="<?php echo create_url('forgot'); ?>"><?php echo $this->lang->line('lbl_forgot_password');?></a>
            </span>
        </div>
    </form>


</div>