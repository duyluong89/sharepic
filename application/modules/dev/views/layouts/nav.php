<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-bootsnipp-collapse">
                <span class="sr-only"><?php echo $this->lang->line('lbl_toggle_navigation'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="animbrand"><a class="navbar-brand" href="<?php echo create_url('home'); ?>"><?php echo $this->lang->line('lbl_public_solution'); ?></a></div>
        </div>

        <div class="collapse navbar-collapse navbar-bootsnipp-collapse">
            <ul class="nav navbar-nav navbar-right" style="margin-right: 0px;">
                <?php if (!session_login()) : ?>
                <li id="nav-register-btn"><a href="/register"><?php echo $this->lang->line('lbl_register'); ?></a></li>
                <li id="nav-login-btn"><a href="<?php echo create_url('login'); ?>"><i class="icon-login"></i><?php echo $this->lang->line('lbl_login'); ?></a></li>
                <?php else: ?>
                <li class="dropdown">
                    <a href="<?php echo create_url('login'); ?>" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-globe"></span> <?php echo current_language() ? current_language() : $this->lang->line('lbl_language'); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php foreach (config_item('language_array') as $key => $value) : ?>
                        <li><a href="<?php echo current_url_with_params(array('language' => $key)); ?>"><?php echo $value;?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="<?php echo create_url('login'); ?>" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo session_login(false)->username; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><span class="glyphicon glyphicon-tasks"></span>&nbsp;<?php echo $this->lang->line('lbl_profile');?></a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo create_url('logout'); ?>"><span class="glyphicon glyphicon-edit"></span>&nbsp;<?php echo $this->lang->line('lbl_logout'); ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>