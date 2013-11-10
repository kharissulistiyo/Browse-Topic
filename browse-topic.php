<?php
/*
Plugin Name: Browse Topic
Version: 0.1
Description: Browse Topic WordPress Plugin. It creates list of post tag links and a filter ( ASC/DESC ) control at the top. It makes your blog readers easy to choose what topic they want to read.
Author: <a href="http://kharissulistiyo.github.io">Kharis Sulistiyono</a>
Author URI: http://kharissulistiyo.github.io
Plugin URI: https://github.com/kharissulistiyo/Browse-Topic
*/



/*
* Front-end style
*/

if(!function_exists('browse_topic_style')){

	function browse_topic_style(){
		
		wp_enqueue_style( 'browse-topic', plugins_url( 'browse-topic.css' , __FILE__ ) );
	
	}

}

add_action( 'wp_enqueue_scripts', 'browse_topic_style' ); 



/*
* List all topics or tags and dropdown filter at the top
*/

if(!function_exists('browse_topic_content')){

	function browse_topic_content(){ ?>

		
		
		<form class="browse-topic-filter-form" action="<?php the_permalink(); ?>" method="get">
			<div>
				<label for="sortby"><?php _e('Filter', 'browse-topic'); ?></label>
				<select id="sortby" name="sort_topic">
					<option value="ASC"><?php _e('Topics (A to Z)', 'browse-topic'); ?></option>
					<option value="DESC"><?php _e('Topics (Z to A)', 'browse-topic'); ?></option>
				</select>
				<input value="Sort Topics" type="submit"> 
			</div>
		</form>
		
		

		<?php 


		/*
		* Topics list goes here
		*/


		if(isset($_GET['sort_topic'])) {

			$order = $_GET['sort_topic'];
			
		}




		$args = array(
			'hide_empty' => true,
			'orderby' => 'name',
			'order' => $order
		);



		$tags = get_tags($args);
		$html = '<div class="bt-topics">';
		$html .= '<ul>';
		foreach ( $tags as $tag ) {
			$tag_link = get_tag_link( $tag->term_id );
			
			$html .= '<li>';	
			$html .= "<a href='{$tag_link}' title='{$tag->name}' class='{$tag->slug}'>";
			$html .= "{$tag->name} ({$tag->count})</a>";
			$html .= '</li>';
			
		}
		$html .= '</ul>';
		$html .= '</div>';
		echo $html;



	}

}

add_action('browse_topic_hook', 'browse_topic_content');



/*
* Plugin shortcode
*/

if(!function_exists('browse_topic_shortcode')){

	function browse_topic_shortcode(){
	
		// Hook for Browse Topic Plugin
		do_action('browse_topic_hook');		
		
	}

}

add_shortcode( 'browse-topic', 'browse_topic_shortcode' );
