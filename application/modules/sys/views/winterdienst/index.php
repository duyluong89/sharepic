<link rel="stylesheet" type="text/css" href="<?php echo assets('css/winterdienst.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets('js/select2/select2.css'); ?>" />
<style type="text/css">
    .filter_item {margin-left: 20px;}
    .filter_item label {padding-right: 10px;}
    .filter_item select {width: 150px;}
</style>
<script type="text/javascript" src="<?php echo assets('js/select2/select2.min.js'); ?>"></script>
<script type="text/javascript" src="http://openlayers.org/dev/OpenLayers.js"></script>
<script type="text/javascript" src="<?php echo assets('js/openlayer.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets('js/winterdienst.js'); ?>"></script>
<script type="text/javascript">
    var map;
    var gps_information_url = '<?php echo create_url('sys/winterdienst/information'); ?>';
    <?php
        echo (isset($gps_position_data) AND !empty($gps_position_data)) ? ('var gps_data = '.json_encode($gps_position_data).'') : '';
    ?>

    // Load a map
    $(function(){
        $('.select2').select2({ width: 'resolve' });
        map = new OpenLayers.Map("map");
        load_map(map);
    });

    $(function(){
        $(".k_dropdownlist").kendoDropDownList();
        $(".k_datepicker").kendoDatePicker({
            format: "dd.MM.yyyy"
        });
        $('.gps_detail').on('click', function(e){
            e.preventDefault();
            i = $(this);
            $('.gps_detail').removeAttr('style');
            i.css('font-weight', 'bold');
            index = i.attr('_index');
            data = gps_data[index]['position'];
            if (data != 'undefined') {
                //for (var i = data.length - 1; i >= 0; i--) {
                //    pos = data[i];
                //    add_marker(map, pos[0], pos[1], index);
                //};
                add_linestring(map,data);
            }

            display_info(index);
            $('#panel_information').fadeIn();

            btn_view_detail = $('#btn_view_detail');
            btn_view_detail.attr('href', btn_view_detail.attr('href') + '/' + index);
        });

        $('#modal_information').on('hidden.bs.modal', function () {
            $(this).removeData('bs.modal');
        })

        $('#modal_information').on('shown.bs.modal', function () {
            data = $('#gps_information').html();
            $(data).find('ul:first').removeAttr('style');
            $('#modal_gps_information').html(data).fadeIn();
        })
    });
</script>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-horizontal" method="get">
                    <div class="row">
                        <span class="pull-left filter_item">
                            <label><?php echo $this->lang->line('lbl_by_date');?></label>
                            <input name="by_date" class="k_datepicker" value="<?php echo $this->input->get('by_date'); ?>" style="width: 140px;" />
                        </span>
                        <span class="pull-left filter_item">
                            <label><?php echo $this->lang->line('lbl_by_worker');?></label>
                            <select name="by_worker" class="k_dropdownlist2 select2">
                                <option value=""><?php echo $this->lang->line('lbl_select_worker');?></option>
                                <?php if (isset($workers) AND !empty($workers)) : ?>
                                    <?php foreach ($workers as $key => $value) : ?>
                                        <option value="<?php echo $value->id; ?>" <?php echo ($this->input->get('by_worker') == $value->id) ? 'selected="selected"' : ''; ?>><?php echo $value->first_name . ' ' . $value->last_name; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </span>
                        <span class="pull-left filter_item">
                            <label><?php echo $this->lang->line('lbl_by_machine');?></label>
                            <select name="by_machine" class="k_dropdownlist2 select2">
                                <option value=""><?php echo $this->lang->line('lbl_select_machine');?></option>
                                <?php if (isset($machines) AND !empty($machines)) : ?>
                                    <?php foreach ($machines as $key => $value) : ?>
                                        <option value="<?php echo $value->id; ?>" <?php echo ($this->input->get('by_machine') == $value->id) ? 'selected="selected"' : ''; ?>><?php echo $value->name; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </span>
                        <span class="pull-left filter_item">
                            <label><?php echo $this->lang->line('lbl_by_object');?></label>
                            <select name="by_object" class="k_dropdownlist2 select2">
                                <option value=""><?php echo $this->lang->line('lbl_select_object');?></option>
                            </select>
                        </span>
                        <span class="pull-left filter_item">
                            <button value="OK GO" class="btn btn-primary btn-sm">OK GO</button>
                        </span>
                    </div>
                    <?php if (FALSE) : ?>
                    <hr class="clr">
                    <div class="row">
                        <div class="col-md-3" style="width: 28%;">
                            <div class="form-group pull-left">
                                <label class="col-md-4 control-label" style="font-weight: normal;"><?php echo $this->lang->line('lbl_by_date');?></label>
                                <div class="col-md-8">
                                    <input name="by_date" class="k_datepicker" value="<?php echo $this->input->get('by_date'); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="width: 28%;">
                            <div class="form-group pull-left">
                                <label class="col-md-4 control-label" style="font-weight: normal;"><?php echo $this->lang->line('lbl_by_worker');?></label>
                                <div class="col-md-8">
                                    <select name="by_worker" class="k_dropdownlist">
                                        <option value=""><?php echo $this->lang->line('lbl_select_worker');?></option>
                                        <?php if (isset($workers) AND !empty($workers)) : ?>
                                            <?php foreach ($workers as $key => $value) : ?>
                                                <option value="<?php echo $value->id; ?>" <?php echo ($this->input->get('by_worker') == $value->id) ? 'selected="selected"' : ''; ?>><?php echo $value->first_name . ' ' . $value->last_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="width: 28%;">
                            <div class="form-group pull-left">
                                <label class="col-md-4 control-label" style="font-weight: normal;"><?php echo $this->lang->line('lbl_by_object');?></label>
                                <div class="col-md-8">
                                    <select name="by_object" class="k_dropdownlist">
                                        <option value=""><?php echo $this->lang->line('lbl_select_object');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2" style="width: 10%;">
                            <input type="submit" value="OK GO" class="k-button"/>
                        </div>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default" id="panel_gps_record">
            <div class="panel-heading"><?php echo $this->lang->line('lbl_gps_record')?></div>
            <div class="panel-body">
                <?php if (isset($gps) AND (!empty($gps)) ) : ?>
                <ul style="margin: 0px; padding: 0px; max-height: 350px; overflow: auto;">
                    <?php
                        foreach ($gps as $key => $value) :
                        $gps_title = (isset($value->ontime) AND strtotime($value->ontime) ) ? date('Ymd', strtotime($value->ontime)) . '.' : '';
                        if (isset($workers[$value->id_worker])) {
                            $worker_data = $workers[$value->id_worker];
                            $gps_title .= strtolower($worker_data->first_name.$worker_data->last_name) . '.' . $value->id;
                        }
                    ?>
                        <li>
                            <span class="glyphicon glyphicon-check"></span>&nbsp;
                            <a class="gps_detail" href="javascript:;" _index="<?php echo $value->id; ?>"><?php echo $gps_title; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php else : ?>
                <p align="center"><?php echo $this->lang->line('lbl_empty');?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $this->lang->line('lbl_map');?></div>
            <div class="panel-body" style="height: 380px;" id="map">
            </div>
        </div>

        <div class="panel panel-default" id="panel_information" style="display: none;">
            <div class="panel-heading"><?php echo $this->lang->line('lbl_information');?></div>
            <div class="panel-body">
                <table class="tbl">
                    <tr>
                        <td width="90%">
                            <div class="row" id="gps_information">
                                <div class="col-md-6">
                                    <ul style="padding-left: 25px;">
                                        <li>
                                            <span><?php echo $this->lang->line('lbl_worker');?></span>
                                            <span id="gps_information_worker" class="gps_information_value"></span>
                                        </li>
                                        <li>
                                            <span><?php echo $this->lang->line('lbl_object');?></span>
                                            <span id="gps_information_object" class="gps_information_value"></span>
                                        </li>
                                        <li>
                                            <span><?php echo $this->lang->line('lbl_start');?></span>
                                            <span id="gps_information_start" class="gps_information_value"></span>
                                        </li>
                                        <li>
                                            <span><?php echo $this->lang->line('lbl_end');?></span>
                                            <span id="gps_information_end" class="gps_information_value"></span>
                                        </li>
                                        <li>
                                            <span><?php echo $this->lang->line('lbl_date');?></span>
                                            <span id="gps_information_date" class="gps_information_value"></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul>
                                        <li>
                                            <span><?php echo $this->lang->line('lbl_info');?></span>
                                            <span id="gps_information_info" class="gps_information_value"></span>
                                        </li>
                                        <li>
                                            <span><?php echo $this->lang->line('lbl_video');?></span>
                                            <span id="gps_information_video" class="gps_information_value"></span>
                                        </li>
                                        <li>
                                            <span><?php echo $this->lang->line('lbl_image');?></span>
                                            <span id="gps_information_image" class="gps_information_value"></span>
                                        </li>
                                        <li>
                                            <span><?php echo $this->lang->line('lbl_voice');?></span>
                                            <span id="gps_information_voice" class="gps_information_value"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td width="10%" valign="bottom" align="right">
                            <a href="<?php echo create_url('sys/winterdienst/information'); ?>" class="btn btn-default btn-success pull-right" data-toggle="modal" data-target="#modal_information" data-backdrop="static" data-keyboard="false" id="btn_view_detail"><?php echo $this->lang->line('lbl_view_detail');?></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_information" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>