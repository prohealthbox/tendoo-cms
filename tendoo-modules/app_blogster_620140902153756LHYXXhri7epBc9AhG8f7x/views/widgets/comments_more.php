  <div class="form-group">
    <label for="exampleInputEmail1"><?php _e( 'Display how many comments' );?></label>
	<?php
	if(isset($zone,$index))
	{
		$name	=	'name="tewi_wid['.$zone.']['.$index.'][params]"';
	}
	else
	{
		$name	=	'';
	}
	?>
    <select class="form-control" <?php echo $name;?> meta_widgetParams meta_widgetParamsName="nbr_comments">
		<?php 
			for($i = 1;$i<= 30;$i++)
			{
				if(isset($parameters))
				{
					if($parameters == $i)
					{
				?>
				<option selected="selected" value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php
					}
					else
					{
				?>
				<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php	
					}
				}
				else
				{
				?>
				<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php
				}
			}
		?>
	</select>
  </div>