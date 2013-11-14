<div id="frm_detail_wraper">
    <script type="text/javascript">
        $('#frm_detail').submit(function(e){
            e.preventDefault();
            i = $(this);
            $.ajax({
                url: i.attr('action'),
                type: 'POST',
                data: i.serialize(),
                success: function(res) {
                    $('#frm_detail_wraper').html(res);
                },
                error: function(err) {}
            });
        });
    </script>
    <form class="form-horizontal" id="frm_detail" action="<?php echo create_url('sys/user/edit/' . (isset($id) ? $id : '') ); ?>">
        <?php if (isset($msg)) : ?>
        <div class="alert alert-success"><?php echo $msg; ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label class="col-md-4 control-label" for="username">Username</label>
            <div class="col-md-5">
                <input id="username" name="username" value="<?php echo set_value('username', isset($data->username) ? $data->username : ''); ?>" type="text" placeholder="Username ..." class="form-control input-md">
                <div class="help-block ps_err">
                    <?php echo form_error('username'); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="email">Email</label>
            <div class="col-md-5">
                <input id="email" name="email" value="<?php echo set_value('email', isset($data->email) ? $data->email : ''); ?>" type="text" placeholder="Email" class="form-control input-md">
                <div class="help-block ps_err">
                    <?php echo form_error('email'); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="group">Group</label>
            <div class="col-md-5">
                <select id="group" name="group" class="form-control">
                    <option value="1">Option one</option>
                    <option value="2">Option two</option>
                </select>
                <div class="help-block ps_err">
                    <?php echo form_error('group'); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="company">Company</label>
            <div class="col-md-5">
                <select id="company" name="company" class="form-control">
                    <option value="1">Option one</option>
                    <option value="2">Option two</option>
                </select>
                <div class="help-block ps_err">
                    <?php echo form_error('company'); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="btn_save"></label>
            <div class="col-md-8">
                <button id="btn_save" name="btn_save" class="btn btn-primary">Save change</button>
                <a id="btn_cancel" name="btn_cancel" class="btn_close_dialog btn btn-danger">Cancel</a>
            </div>
        </div>
    </form>
</div>