<link rel="stylesheet" href="<?php echo assets('js/projekktor/themes/maccaco/projekktor.style.css'); ?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo assets('js/projekktor/projekktor-1.3.00.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets('js/openlayer.js'); ?>"></script>
<script type="text/javascript">
    $(function(){
        projekktor('video, audio', {
            playerFlashMP4: '<?php echo assets('js/projekktor/swf/Jarisplayer/jarisplayer.swf'); ?>',
            playerFlashMP3: '<?php echo assets('js/projekktor/swf/Jarisplayer/jarisplayer.swf'); ?>f'
        });
    });
</script>
<div class="modal-dialog" style="width: 1000px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"> <?php echo $this->lang->line('lbl_winterdienst_detail')?></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body" id="modal_gps_information">
                          <p align="center">Loading content</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_video" data-toggle="tab"> <?php echo $this->lang->line('lbl_video')?></a></li>
                    <li class=""><a href="#tab_image" data-toggle="tab"> <?php echo $this->lang->line('lbl_image')?></a></li>
                    <li><a href="#tab_voice" data-toggle="tab"> <?php echo $this->lang->line('lbl_voice_meno')?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_video">
                        <h4> <?php echo $this->lang->line('lbl_video_file_demo')?></h4>
                        <video class="projekktor" width="470" height="360" poster="poster.jpg">
                            <source src="http://www.projekktor.com/wp-content/manual/intro.lo.webm" />
                            <source src="http://www.projekktor.com/wp-content/manual/intro.lo.webm" />
                            <source src="http://www.projekktor.com/wp-content/manual/intro.lo.webm" />
                        </video>
                    </div>
                    <div class="tab-pane" id="tab_image">
                    	<div class="row">
						  	<div class="col-sm-4" style="height: 400px; overflow: auto;">
						  		<?php
				    			if(isset($image) && !empty($image))
				    			{
				    				$i = 0;
					    			foreach ($image as $item)
					    			{
					    				if(($i%3) === 0)
					    				{
					    					if($i === 0)
					    						echo '<div class="row">';
					    					else
					    						echo '</div><div class="row">';
					    				}
				    					?>				    				
					    				<div class="col-sm-4">
						   					<img class="thumbnail" width="89" height="85" alt="" src="<?php echo config_item('api_web');?>uploads<?php echo $item['data'];?>" onclick="$('#imgview').attr('src',$(this).attr('src'));">
							   			</div>
						   			<?php
					    				$i++;
					    			}
					    			echo '</div>';
				    			}
				    			?>
						  	</div>
						  	<div class="col-sm-5" style="width: 43%;">
						    	<div class="row">
						    		<div class="col-sm-12">
						    		<?php if(isset($image) && !empty($image)){?>
				    					<img width="400" height="auto" style="border: 1px solid #ddd; border-radius: 4px; -webkit-transition: all .2s ease-in-out; transition: all .2s ease-in-out;" id="imgview" alt="" src="<?php echo config_item('api_web');?>uploads<?php echo $image[0]['data'];?>"> </div>
				    				<?php }?>						    			
						    	</div>
						  	</div>
						</div>
                    </div>
                    <div class="tab-pane" id="tab_voice">
                        <audio controls class="projekktor" width="470" height="150" poster="poster.jpg">
                            <source src="<?php echo config_item('api_web'); ?>uploads/audiorecordtest.3gp" type="video/3gpp" ></source>
                            <?php echo $this->lang->line('lbl_your_browser_does_not_support_this_audio_format')?>Your browser does not support this audio format.
                        </audio>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('lbl_close')?></button>
        </div>
    </div>
</div>