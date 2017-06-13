<?php
// $Id: node.tpl.php,v 1.4.2.1 2009/05/12 18:41:54 johnalbin Exp $

/**
 * @file node.tpl.php
 *
 * Theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $picture: The authors picture of the node output from
 *   theme_user_picture().
 * - $date: Formatted creation date (use $created to reformat with
 *   format_date()).
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $name: Themed username of node author output from theme_user().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $submitted: themed submission information output from
 *   theme_node_submitted().
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $teaser: Flag for the teaser state.
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 */
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix">
  <?php print $user_picture; ?>

  
  <?php if (!$page && $title): ?>
    <h2 class="title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
  <?php endif; ?>
  <?php if ($page && $title): ?>
    <h2 class="title"><?php print $title; ?></h2>
  <?php endif; ?>
  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <?php if ($display_submitted || $terms): ?>
    <div class="meta">
      <?php if ($display_submitted): ?>
        <span class="submitted">
          <?php print $submitted; ?>
        </span>
      <?php endif; ?>

      <?php if ($terms): ?>
       <!-- <div class="terms terms-inline"><?php print $terms; ?></div> -->
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="content">
  
  	
<?php //print $content; ?>


<?php if ($node->content['body']['#value']): ?>
    <?php //echo $node->content['body']['#value'];?>
    
    <?php $bc_apiUrl = BC_API_BASE_URL.'/titles?q='.trim(urlencode(strip_tags($node->content['body']['#value'])),'%0A').'&library='.BC_API_LIBRARY.'&'.BC_API_PARAMS.'&api_key='.BC_API_PRIVATE_KEY;?>
    <?php //echo $bc_apiUrl;?>
   
    <div class="node-<?php print $node->nid;?>">
	    <ul class="lightSlider">
	      	
	      
		    <?php 
		    
		    $results = bc_ApiSearchTitles($bc_apiUrl);
		        $i = 0;
		        foreach ($results['titles'] as $value) {
		            if ($value['isbns'][0]){
		                $title = $value['title']; 
		                $isbn = $value['isbns'][0];
		                $url = $value['details_url'];
		                
		                
		                
		                echo '
		                
						  
						    
						     
						       <a href="'.$url.'" target=_catalog alt="'.$title.'" title="'.$title.'">    
						                <img class="thumbnail img-responsive" src="http://www.syndetics.com/index.aspx?type=xw12&amp;client=mconpublib&amp;upc=&amp;oclc=&amp;isbn='.$isbn.'/LC.GIF">
						          </a>
						     
						    
						  ';
		                $i++;
		            }
		        }  
		    ?>
	   </ul>
    </div>
   <?php 
	   $lightSlider_js = '
						<script type="text/javascript">
							 $(\'.lightSlider\').each(function (index) {
							 	$(this).lightSlider({
							        item:7,
							        loop:false,
							        slideMove:6,
							        easing: \'cubic-bezier(0.25, 0, 0.25, 1)\',
							        speed:600,
							        responsive : [
							            
							            {
							                breakpoint:900,
							                settings: {
							                    item:5,
							                    slideMove:4,
							                    slideMargin:6,
							                  }
							            },
							            {
							                breakpoint:480,
							                settings: {
							                    item:2,
							                    slideMove:2
							                  }
							            }
							        ],
							        
							    });  
							 });
						</script>';
			//echo($lightSlider_js);
	?>
<?php endif; ?>  

<?php if (!$field_body): ?>  
	<?php	// render resource list 1 fields
	$i = 0;
	$html = '<div class="row">';
	$resource = array();
    if (isset($field_resource_list1[$i]['nid']) ) {
    foreach ($field_resource_list1 as $resource_list1) {
      	
      
      
      		// Get an array of node fields from the selected nodes
		  	
		  	$node = node_load($resource_list1['nid']);
			$node = node_build_content($node);
			//print_r($node);
			
			if (user_access('administer nodes')) {
				  	$editLink = l('Edit', 'node/' . $node->nid . '/edit', 
							  		array(
									    'attributes' => array(
									      'class' => 'block-edit',
									      'style' => 'position: absolute; right: 5px; padding: 5px;'
										  )
										)
								);										
			}

			
		  	$resource[$i][type] = $node->type;
		  	$resource[$i][nid] = $node->nid;
		  	$resource[$i][title] = $node->title;
			$resource[$i][image] = $node->field_resource_image[0][filepath];
			$resource[$i][brief_desc] = $node->field_brief_description[0][value];
			$resource[$i][body] = $node->body;
			
			if ($resource[$i][type] == "kids_link") {
				$resourceTypeLabel = "Website";
			} else {
				$resourceTypeLabel = "Library Card";
			}
			
			
			/* Web resources and research databases use a different link field 
			 * @todo re-map the links to a common field
			 * */
			if ($node->field_dburl){
				$resource[$i][url] = $node->field_dburl[0][value];
			} else if ($node->field_linkurl) {
				$resource[$i][url] = $node->field_linkurl[0][value];
			}
			
			if ($editLink) {
      			$editLink = '<div class="edit">'.$editLink.'</div>';
      		}
      		
			
      		// Produce the html output
      		
      		
      		$html .=
      		'
      		    		
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 '.$resource[$i][type].'">'.
				$editLink.'
				<div class="thumbnail">        
					<a href="'.$resource[$i][url].'" role="button" data-toggle="modal" data-target="#'.$resource[$i][nid].'">
					        
					        <img class="img-responsive" src="/'.$resource[$i][image].'">
					                <div class="caption">
					                   
					                   <p>'.$resource[$i][brief_desc].'</p>
					                   <span class="resource-type"> '.$resourceTypeLabel.'</span>
					                 </div>
						</a>

							<div class="panel-footer clearfix">
						<div class="pull-right "><a class="btn btn-info " href="#" role="button" data-toggle="modal" data-target="#'.$resource[$i][nid].'">About</a>
						
						<a class="btn btn-primary" href="'.$resource[$i][url].'" target="_blank">Go <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a></div>
						</div>
						</div>
						
						<div id="'.$resource[$i][nid].'" class="modal fade" role="dialog">
						  <div class="modal-dialog">
						
						    
						    <div class="modal-content">
						      <div class="modal-header">
						        <a class="close" data-dismiss="modal">×</a>
						        <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span> '.$resource[$i][title].'</h4>
						      </div>
						      <div class="modal-body">
						          <img src="/'.$resource[$i][image].'">
						          <p>'.$resource[$i][body].'</p>
						          <span class="resource-type"> '.$resourceTypeLabel.'</span>
						      </div>
						      <div class="modal-footer">
						        <a class="btn btn-primary" href="'.$resource[$i][url].'" target="_blank">Go to '.$resource[$i][title].' <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>
						        <a class="btn btn-default" data-dismiss="modal">Close</a>
						      </div>
						    </div>
																										
						  </div>
						</div>
						</div>
					
      		
      		
      		
      		';
			
      $i ++;
	  } 
    }
    
	$html .= '</div>';
	print $html;
?>
<?php endif; ?>	

<!-- Media Lists -->
<?php
$i = 0;

$node = $variables['node'];
//print_r($node);
foreach ($node->taxonomy as $term) {
	if ($term->vid == 6) {	// Only include Media Lists
	//print $term->vid;
	
	$recomendations = views_embed_view('media_lists', 'block_2', $term->name);
	
	$lightSlider_js = '
	<script type="text/javascript">
		 $(\'.term-'.$term->tid.' .lightSlider\').lightSlider({
		        item:7,
		        loop:false,
		        slideMove:6,
		        easing: \'cubic-bezier(0.25, 0, 0.25, 1)\',
		        speed:600,
		        responsive : [
		            
		            {
		                breakpoint:900,
		                settings: {
		                    item:5,
		                    slideMove:4,
		                    slideMargin:6,
		                  }
		            },
		            {
		                breakpoint:480,
		                settings: {
		                    item:2,
		                    slideMove:2
		                  }
		            }
		        ],
		        
		    });  
		 
	</script>';
	
	$row = 	'
	<div class="term-'.$term->tid.'">
	  <div class="">
	     <h2 class="sub-heading">'.$term->name.'</h2>'
	         .$recomendations.'
	  </div>       
	</div>';
	
	$html = $row.$lightSlider_js;
	
	print $html;
	
	}	
}


?>
<!-- End Media Lists -->
<!-- Additional Content field -->

<?php if ($field_additional_content_heading[0][value]): ?>
	<h2 class="sub-heading"><?php print $field_additional_content_heading[0][value]; ?></h2>
<?php endif; ?>

<?php if ($field_additional_content[0][value]): ?>
	<div>
		<?php print $field_additional_content[0][value]; ?>
	</div>
 <?php endif; ?>
 <!-- Additional Content field -->
   	
  </div>

  <?php print $links; ?>
</div><!-- /.node -->

