<?php
 /*
    Plugin Name: go News in Pictures
    Plugin URI: http://goresponsive.in
    Description: Plugin for viewing best news photos, news pictures online
    Author: goResponsive
    Version: 1.0
    Author URI: http://goresponsive.in
    */
	?>
<?php

add_action('widgets_init','newspic_widget');
function newspic_widget(){
register_widget('newsinpic_widget');
}
class newsinpic_widget extends WP_widget{
	function newsinpic_widget(){
		$widget_ops = array( 'classname' => 'newspic-widget' );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'newspic-widget' );
		$this->WP_Widget( 'newspic-widget','go News in Pictures', $widget_ops, $control_ops );
	}
	function widget($args,$instance){
		extract( $args );
		$fet=new WP_query(
		"showposts=" .$instance["posts"].
		"&cat=" .$instance["cat"] 
		);
	$title = apply_filters('widget_title', $instance['title'] );
	$posts = $instance['posts'];
		echo $before_widget;
		echo $before_title;
		echo $title ;
		echo $after_title;
	while($fet->have_posts())
		{
			$fet->the_post();
				?>
			<a class='newsInPictures'  title='<?php echo the_title()?>' href='<?php echo the_permalink(); ?>' >
			<?php
			
			the_post_thumbnail(array($instance['width'],$instance['height'])); ?>
			
			</a>
			<?php	
		}
			echo $after_widget;

		}
	function update($new_instance,$old_instance)
		{
		$instance=$old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts'] = strip_tags( $new_instance['posts'] );
		$instance['cat']=strip_tags($new_instance['cat']);
		$instance['width']=strip_tags($new_instance['width']);
		$instance['height']=strip_tags($new_instance['height']);
		return $instance;
		}

	function form($instance)
		{
		$defaults = array( 'title' =>__('News in Pictures' , 'test'), 'posts' => '12' , 'cats_id' => '1' ,'width'=>'100','height'=>'100' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$categories_obj = get_categories('hide_empty=0');
		$categories = array();
		foreach ($categories_obj as $pn_cat)
			{
			$categories[$pn_cat->cat_ID] = $pn_cat->cat_name;
			}

		
	
	echo "<p>
			<label for='".$this->get_field_id( 'title' )."'>Title : </label>
			<input id='".$this->get_field_id( 'title' )."' name='".$this->get_field_name( 'title' )."' value='".$instance['title']."' class='widefat' type='text' />
		</p>";
		
		echo "<p>
			<label for='".$this->get_field_id( 'posts' )."'>Number of thumbs to show: </label>
			<input id='".$this->get_field_id( 'posts' )."' name='".$this->get_field_name( 'posts' )."' value='".$instance['posts']."' type='text' size='3' />
		</p>";
		
		echo "<p>
		<label for='".$this->get_field_id( 'width' )."'>width: </label>
			<input id='".$this->get_field_id( 'width' )."' name='".$this->get_field_name( 'width' )."' value='".$instance['width']."' type='text' size='3' />
		<label for='".$this->get_field_id( 'height' )."'>height: </label>
			<input id='".$this->get_field_id( 'height' )."' name='".$this->get_field_name( 'height' )."' value='".$instance['height']."' type='text' size='3' />	
			
		</p>";
		
		
		?>
		
		<label>
		<?php _e( 'Category' ); ?>:
		<?php wp_dropdown_categories( array( 'show_option_all' => 'All categories','name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
			</label>
			<?php
			
	}
}
?>