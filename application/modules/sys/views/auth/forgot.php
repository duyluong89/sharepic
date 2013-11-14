<link href="<?php echo assets('login.css', ASSET_TYPE_CSS); ?>" rel="stylesheet">
<div class="container">
    <form class="form-signin" method="post" id="frm_forgot">
        <?php if (isset($validate)): ?>
            <h2 class="form-signin-heading"><?php echo $this->lang->line('lbl_forgot_password');?></h2>
            <div class="alert <?php echo $validate ? 'alert-info' : 'alert-error'; ?>" style="margin: 15px 0px;"><?php echo isset($msg) ? $msg : ''; ?></div>
            <a class="btn btn-lg btn-primary btn-block" href="<?php echo create_url('login'); ?>" style="margin-top: 10px;"><?php echo $this->lang->line('lbl_goto_login_page');?></a>
        <?php else: ?>
            <h2 class="form-signin-heading"><?php echo $this->lang->line('lbl_forgot_password')?></h2>
            <?php if (isset($status) AND ($status == FALSE) AND (isset($msg)) AND (!empty($msg)) ): ?>
                <div class="alert alert-danger"><?php echo $msg; ?></div>
            <?php endif; ?>
            <div><input type="text" name="email" value="<?php echo set_value('email');?>" class="form-control" placeholder="youremail@company.com"></div>
            <div><input type="text" name="captcha" value="<?php echo set_value('captcha');?>" class="form-control" placeholder="Enter captcha ..."></div>
            <div style="margin: 10px 0px; text-align: center;">
                <a href="javascript:;" title="Click here for get new captcha">
                    <img class="captcha_img" src="<?php echo create_url('captcha'); ?>">
                </a>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 10px;"><?php echo $this->lang->line('lbl_forgot_password');?></button>
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
                    <a href="<?php echo create_url('login'); ?>"><?php echo $this->lang->line('lbl_login');?></a>
                </span>
            </div>
        <?php endif; ?>
    </form>
</div>