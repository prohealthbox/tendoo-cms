<?php
$this->gui->cols_width( 1 , 3 );
$this->gui->cols_width( 2 , 1 );
$this->gui->col_config( 1 , array(
	'inner-opening-wrapper'	=>	'<form method="post" class="submitForm">'
) );
$this->gui->col_config( 2 , array(
	'inner-closing-wrapper'	=>	'</form>'
) );
$this->gui->set_meta( array(
	'namespace'		=>		'post_new',
	'type'			=>		'unwrapped',	
) )->push_to( 1 );

$this->gui->set_meta( array(
	'namespace'		=>		'post_meta',
	'type'			=>		'unwrapped',	
) )->push_to( 2 );

$this->gui->set_item( array(
	'type'		=>	'dom',
	'value'		=>	module_view( 'views/post-edit' , true , 'blogster' )
) )->push_to( 'post_new' );

$this->gui->set_item( array(
	'type'		=>	'dom',
	'value'		=>	module_view( 'views/post-edit-meta' , true , 'blogster' )
) )->push_to( 'post_meta' );

$this->gui->get();
?>
<?php
return
?><?php echo $inner_head;?>
<section id="w-f">
    <section class="hbox stretch"><?php echo $lmenu;?>
        <section class="vbox">
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> <?php echo output('notice');?>  <?php echo validation_errors(); ?>
                    <form method="post" class="submitForm">
                        <div class="row">
                            <div class="col-lg-9">
                                <input type="hidden" value="<?php echo $getSpeNews[0]['ID'];?>" name="article_id">
                                <input class="form-control" value="<?php echo $getSpeNews[0]['TITLE'];?>" type="text" name="news_name" placeholder="Titre de l'article">
                                <br />
                                <?php echo $this->instance->visual_editor->getEditor(array('class'=>'form-control','id'=>'editor','name'=>'news_content','defaultValue'=>$getSpeNews[0]['CONTENT'],'height'	=>	'800px'));?> </div>
                            <div class="col-lg-3">
                                <section class="panel">
                                    <div class="panel-heading">
										<?php _e( 'Meta data' );?>
									</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div id="articleKeyWords" class="pillbox clearfix m-b">
                                                <ul>
                                                    <?php
						if(count($getKeyWords) > 0)
						{
							foreach($getKeyWords as $k)
							{
								?>
                                                    <li class="label bg-primary">
                                                        <input type="hidden" name="artKeyWord[]" value="<?php echo $k['TITLE'];?>">
                                                        <?php echo $k['TITLE'];?></li>
                                                    <?php
							}
						}
						?>
                                                    <input class="addKeyWord" placeholder="<?php _e( 'Add a keyword' );?>" type="text">
                                                </ul>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
					function __bindKeyWordRemovalListener()
					{
						$('#articleKeyWords').find('.label').each(function(){
							if(typeof $(this).attr('bindKeyWordRemovalListenerbound') == 'undefined')
							{
								$(this).attr('bindKeyWordRemovalListenerbound','true');
								$(this).bind('click',function(){
									$(this).fadeOut(500,function(){
										$(this).remove();
									});
								});
							}
						})
					}
						
					$(document).ready(function(){
						$('.addKeyWord').focusin(function(){
							$(this).keydown(function(e,f){
								if(e.which == 13)
								{
									if($(this).val() != '')
									{
										$(this).before('<li class="label bg-primary"><input type="hidden" name="artKeyWord[]" value="'+$(this).val()+'">'+$(this).val()+'</li>');
										$(this).val('');
										__bindKeyWordRemovalListener();
									}
								}
							});
						});
						__bindKeyWordRemovalListener();
					});
				  </script>
                                        <div class="form-group">
                                            <button class="btn btn-primary input-sm form-control creatingCategory" data-form-url="<?php echo $this->instance->url->site_url(array('admin','open','modules',$module[ 'namespace' ],'ajax','createCategory'));?>" type="button"><?php _e( 'Add a category' );?></button>
                                        </div>
                                        <div class="form-group">
                                        	<span><?php _e( 'Choose a category' );?></span>
                                            <hr class="line line-dashed">
                                            <select class="multiselect" multiple="multiple" name="category[]">
                                            <?php
												if(count($categories) > 0)
												{
													$relatedCategoryId	=	array();
													//var_dump($getNewsCategories);
													foreach($getNewsCategories as $_gNc)
													{
														$relatedCategoryId[]	=	$_gNc['CATEGORY_REF_ID'];
													}
													//var_dump($relatedCategoryId);
                        foreach($categories as $c)
                        {
							if(in_array($c['ID'],$relatedCategoryId))
							{
								?>
								<option selected value="<?php echo $c['ID'];?>"><?php echo $c['CATEGORY_NAME'];?></option>
								<?php
							}
							else
							{
								?>
								<option value="<?php echo $c['ID'];?>"><?php echo $c['CATEGORY_NAME'];?></option>
								<?php
							}
                        }
												}
												else
												{
													?>
                                                <option value=""><?php _e( 'No category available' );?></option>
                                                <?php
												}
                        ?>
                                            </select>
                                        </div>
                                        <script>
									$(document).ready(function(e) {
										$('.multiselect').multiselect({
											dropRight: true,
											nonSelectedText	: "<?php _e( 'Please select something' );?>",
											nSelectedText	:	"cochés)",
											enableFiltering	:	true,
											templates		:	{
												filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
											}
										});
									});
									</script>
                                        <div class="form-group">
                                            <?php
                        $fmlib->mediaLib_button(array(
                            'PLACEHOLDER'		=>		__( 'Image link' ),
                            'NAME'				=>		'thumb_link',
							'TEXT'				=>		__( 'Preview thumb' ),
							'VALUE'				=>		$getSpeNews[0]['THUMB']
                        ));	
                        ?>
                                        </div>
                                        <div class="form-group">
                                            <?php
                        $fmlib->mediaLib_button(array(
                            'PLACEHOLDER'		=>		__( 'Image link' ),
                            'NAME'				=>		'image_link',
                            'GOTO'				=>		'selection',
							'TEXT'				=>		__( 'Full image' ),
							'VALUE'				=>		$getSpeNews[0]['IMAGE']
                        ));	
                        ?>
                                        </div>
                                        <?php
                        $fmlib->mediaLib_load();
                        ?>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </form>
                </section>
            </section>
        </section>
        <footer class="footer bg-white b-t">
        <?php
		if($getSpeNews[0]['SCHEDULED']	==	'1')
		{
			$dateArray	=	$this->instance->date->time($getSpeNews[0]['DATE'],true);
		}
		else
		{
			$dateArray	=	$this->instance->date->time($this->instance->date->datetime(),true);
		}
		?>
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-2" id="ajaxLoading"> </div>
                <div class="col-sm-10 text-right text-center-xs"> <a class="publish_article pull-right btn-sm btn <?php echo theme_button_class();?>" style="margin-right:10px;"><?php _e( 'Edit Post' );?></a> <a class="set_as_draft pull-right btn-sm btn <?php echo theme_button_class();?>" style="margin-right:10px;"><?php _e( 'Set as draft' );?></a> <a class="pull-right btn-sm btn btn-white" style="margin-right:10px;"><?php _e( 'Or' );?></a>
                    <input type="text" name="scheduledTime" class="input-sm input-s pull-right form-control" placeholder="12:30" style="margin-right:10px;" value="<?php echo $dateArray['h'].':'.$dateArray['i'];?>">
                    <a class="pull-right btn-sm btn btn-white" style="margin-right:10px;"><?php _e( 'To' );?></a>
                    <input class="input-sm input-s pull-right datepicker form-control" size="16" value="<?php
					echo $dateArray['d'].'-'.$dateArray['m'].'-'.$dateArray['y']
                    ?>" type="text" style="margin-right:10px;" name="scheduledDate">
                    <a class="program_for pull-right btn-sm btn <?php echo theme_button_false_class();?>" style="margin-right:10px;"><?php _e( 'Schedule for' );?></a> </div>
            </div>
        </footer>
        </section>
    </section>
<script>
	$(document).ready(function(){
		// Lazy coding :(, but it's working :D
		$('.publish_article').bind('click',function(){
			$('.submitForm').append('<input type="hidden" name="push_directly" value="1"/>');
			$('.submitForm').submit();
			$('.submitForm').find('[name="push_directly"]').remove();
		});
		$('.program_for').bind('click',function(){
			$('.submitForm').append('<input type="hidden" name="push_directly" value="3"/>');
			$('.submitForm').append('<input type="hidden" name="scheduledDate" value="'+$('[name="scheduledDate"]').val()+'"/>');
			$('.submitForm').append('<input type="hidden" name="scheduledTime" value="'+$('[name="scheduledTime"]').val()+'"/>');
			$('.submitForm').submit();
			$('.submitForm').find('[name="push_directly"]').remove();
			$('.submitForm').find('[scheduledTime]').remove();
			$('.submitForm').find('[scheduledDate]').remove();
		});
		$('.set_as_draft').bind('click',function(){
			$('.submitForm').append('<input type="hidden" name="push_directly" value="2"/>');
			$('.submitForm').submit();
			$('.submitForm').find('[name="push_directly"]').remove();
		});
		var currentTime	=	'<?php echo $this->instance->date->datetime('%d-%m-%Y');?>';
		$('.datepicker').datepicker({
			showAnim		:		'slideDown',
			dateFormat		:		'dd-mm-yy',
			minDate			:		currentTime,
			monthNames		:		[ "<?php _e( 'January' );?>", "<?php _e( 'Febuary' );?>", "<?php _e( 'March' );?>", "<?php _e( 'April' );?>", "<?php _e( 'May' );?>", "<?php _e( 'June' );?>", "<?php _e( 'Jully' );?>", "<?php _e( 'August' );?>", "<?php _e( 'September' );?>", "<?php _e( 'October' );?>", "<?php _e( 'November' );?>", "<?php _e( 'December' );?>" ],
			dayNamesMin		:		[ "<?php _e( 'Sun' );?>", "<?php _e( 'Mon' );?>", "<?php _e( 'Tue' );?>", "<?php _e( 'Thu' );?>", "<?php _e( 'Fri' );?>", "<?php _e( 'Wed' );?>", "<?php _e( 'Sat' );?>" ]
		});
		var hours			=	new Array;
		for(i=0;i<=23;i++)
		{
			for(_i=0;_i<=55;_i+=5)
			{
				if(i < 10)
				{
					if(_i < 10)
					{
						hours.push('0'+i+':0'+_i);
					}
					else
					{
						hours.push('0'+i+':'+_i);
					}
				}
				else
				{
					if(_i < 10)
					{
						hours.push(i+':0'+_i);
					}
					else
					{
						hours.push(i+':'+_i);
					}
				}
			}
		}
		$('[name="scheduledTime"]').autocomplete({
			position		: { my : "bottom", at: "center top" },
			source			:	hours,
			minLength		:	2,
			autoFocus		:	true
		});
		var widget			=	$('[name="scheduledTime"]').autocomplete('widget');
		$(widget).css('z-index',2000);
	});
</script> 