<?php
ob_start();
?>

<table tableMultiSelect class="table table-striped m-b-none">
    <thead>
        <tr>
            <th width="40"><input type="checkbox" id="check_all" /></th>
            <th width="500"><?php _e( 'Title' );?></th>
            <th><?php _e( 'Author' );?></th>
            <th><?php _e( 'Bind to' );?></th>
            <th><?php _e( 'Created' );?></th>
            <th><?php _e( 'URL' );?></th>
        </tr>
    </thead>
    <tbody>
    <form id="bulkSelect" method="post">
        <?php
									if( is_array( $get_pages ) && count( $get_pages ) > 0 ){
										foreach( $get_pages as $_pages ){
												$author			=	get_instance()->users_global->getUser( $_pages[ 'AUTHOR' ] );
												$controller		=	get_instance()->tendoo->get_controllers( 'filter_cname' , $_pages[ 'CONTROLLER_REF_CNAME' ] ); 
											?>
        <tr>
            <td><input type="checkbox" name="page_id[]" value="<?php echo $_pages[ 'ID' ];?>" /></td>
            <td><a href="<?php echo module_url( array( 'edit' , $_pages[ 'ID' ] ) );?>"><?php echo return_if_array_key_exists( 'TITLE' , $_pages );?> <?php echo $_pages[ 'STATUS' ] == 0 ? '<span class="text-muted">' . __( '[Draft]' ) . '</span>' : '';?></a></td>
            <td><?php echo $author[ 'PSEUDO' ];?></td>
            <td><?php echo 
											return_if_array_key_exists( 'PAGE_TITLE' , $controller[0] )
												? return_if_array_key_exists( 'PAGE_TITLE' , $controller[0] ) : __( 'No controller' );
										;?></td>
            <td><?php echo $this->date->timespan( $_pages[ 'DATE' ] );?></td>
            <td><?php 
											if( is_array( $controller ) ){
												?>
                <a href="<?php echo get_instance()->url->site_url(array( $controller[0][ 'PAGE_CNAME' ] ) );?>">
                <?php _e( 'Open that page' );?>
                </a>
                <?php
											}
											else{
												if( is_array( $_pages[ 'THREAD' ] ) ){
												?>
                <a href="<?php echo get_instance()->url->site_url( $_pages[ 'THREAD' ] );?>">
                <?php _e( 'Open that page' );?>
                </a>
                <?php
												}
												else {
													echo is_string( $_pages[ 'THREAD' ] ) ? $_pages[ 'THREAD' ] : '';
												}
											}
											?></td>
        </tr>
        <?php
										}
									}
									else
									{
										?>
        <tr>
            <td colspan="5"><?php echo __( 'No page available <a href=" ' . module_url( array( 'create' ) ) . '">Click here to create a page</a>' );?></td>
        </tr>
        <?php
									}
									?>
    </form>
        </tbody>
    
</table>
<div class="row m-t-sm text-center-xs">
    <div class="col-sm-4">
        <div bulkSelect target="#bulkSelect">
            <select name="action" class="input-sm form-control input-s-sm inline">
                <option value="0"><?php _e( 'Bulk Actions' );?></option>
                <option value="delete"><?php _e( 'Delete' );?></option>
                <option value="draft"><?php _e( 'Drafts' );?></option>
            </select>
            <button class="btn btn-sm btn-white"><?php _e( 'Apply' );?></button>
        </div>
    </div>
    <div class="col-sm-4 text-center">
        <small class="text-muted inline m-t-sm m-b-sm"></small>
    </div>
    <div class="col-sm-4 text-right text-center-xs">
        <?php bs_pagination( $paginate );?>
    </div>
</div>
<?php
$page_table		=	ob_get_clean();

$this->gui->cols_width( 1 , 3 );

$this->gui->set_meta( 'pages-list' , __( 'Availables pages' ) , 'panel-ho' )->push_to( 1 );

$this->gui->set_item( array(
	'type'		=>		'dom',
	'value'		=>		$page_table
) )->push_to( 'pages-list' );

$this->gui->get();
return;
?>
<?php echo $inner_head;?>
<section>
    <section class="hbox stretch">
        <?php echo $lmenu;?>
        <section class="vbox">
            <section class="scrollable" id="pjax-container">
                <header>
                    <div class="row b-b m-l-none m-r-none">
                        <div class="col-sm-4">
                            <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                            <p class="block text-muted">
                                <?php echo get_page('description');?>
                            </p>
                        </div>
                    </div>
                </header>
                <section class="vbox stretch">
                    <section class="wrapper">
                        <?php echo output('notice');?> <?php echo fetch_notice_from_url();?>
                        <section class="panel">
                            <div class="panel-heading">
                                <?php _e( 'Availables Pages' );?>
                            </div>
                            <div class="table-responsive">
                                <table tableMultiSelect class="table table-striped m-b-none">
                                    <thead>
                                        <tr>
                                            <th width="40"><input type="checkbox" id="check_all" /></th>
                                            <th width="500"><?php _e( 'Title' );?></th>
                                            <th><?php _e( 'Author' );?></th>
                                            <th><?php _e( 'Bind to' );?></th>
                                            <th><?php _e( 'Created' );?></th>
                                            <th><?php _e( 'URL' );?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <form id="bulkSelect" method="post">
                                        <?php
									if( is_array( $get_pages ) && count( $get_pages ) > 0 ){
										foreach( $get_pages as $_pages ){
												$author			=	get_instance()->users_global->getUser( $_pages[ 'AUTHOR' ] );
												$controller		=	get_instance()->tendoo->get_controllers( 'filter_cname' , $_pages[ 'CONTROLLER_REF_CNAME' ] ); 
											?>
                                        <tr>
                                            <td><input type="checkbox" name="page_id[]" value="<?php echo $_pages[ 'ID' ];?>" /></td>
                                            <td><a href="<?php echo module_url( array( 'edit' , $_pages[ 'ID' ] ) );?>"><?php echo return_if_array_key_exists( 'TITLE' , $_pages );?> <?php echo $_pages[ 'STATUS' ] == 0 ? '<span class="text-muted">' . __( '[Draft]' ) . '</span>' : '';?></a></td>
                                            <td><?php echo $author[ 'PSEUDO' ];?></td>
                                            <td><?php echo 
											return_if_array_key_exists( 'PAGE_TITLE' , $controller[0] )
												? return_if_array_key_exists( 'PAGE_TITLE' , $controller[0] ) : __( 'No controller' );
										;?></td>
                                            <td><?php echo $this->date->timespan( $_pages[ 'DATE' ] );?></td>
                                            <td><?php 
											if( is_array( $controller ) ){
												?>
                                                <a href="<?php echo get_instance()->url->site_url(array( $controller[0][ 'PAGE_CNAME' ] ) );?>">
                                                <?php _e( 'Open that page' );?>
                                                </a>
                                                <?php
											}
											else{
												if( is_array( $_pages[ 'THREAD' ] ) ){
												?>
                                                <a href="<?php echo get_instance()->url->site_url( $_pages[ 'THREAD' ] );?>">
                                                <?php _e( 'Open that page' );?>
                                                </a>
                                                <?php
												}
												else {
													echo is_string( $_pages[ 'THREAD' ] ) ? $_pages[ 'THREAD' ] : '';
												}
											}
											?></td>
                                        </tr>
                                        <?php
										}
									}
									else
									{
										?>
                                        <tr>
                                            <td colspan="5"><?php echo __( 'No page available <a href=" ' . module_url( array( 'create' ) ) . '">Click here to create a page</a>' );?></td>
                                        </tr>
                                        <?php
									}
									?>
                                    </form>
                                        </tbody>
                                    
                                </table>
                            </div>
                        </section>
                    </section>
                </section>
            </section>
            <footer class="footer bg-white b-t">
                <div class="row m-t-sm text-center-xs">
                    <div class="col-sm-4">
                        <div bulkSelect target="#bulkSelect">
                            <select name="action" class="input-sm form-control input-s-sm inline">
                                <option value="0">
                                <?php _e( 'Bulk Actions' );?>
                                </option>
                                <option value="delete">
                                <?php _e( 'Delete' );?>
                                </option>
                                <option value="draft">
                                <?php _e( 'Drafts' );?>
                                </option>
                            </select>
                            <button class="btn btn-sm btn-white">
                            <?php _e( 'Apply' );?>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm"></small>
                    </div>
                    <div class="col-sm-4 text-right text-center-xs">
                        <?php bs_pagination( $paginate );?>
                    </div>
                </div>
            </footer>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>