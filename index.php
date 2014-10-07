<?php

/*
		Plugin Name: Movies Post Type
		Plugin URI: www.google.com
		Description: Offers a post for managing movie collection
		Author: Sazzadur Rahman
		Version: 1
		*/

		
		class SZ_movies_post_type 
		{
			
		public function __construct()
			{
				$this->register_post_type();
				$this->taxonomies();
				$this->metaboxes();

			}

		public function register_post_type(){

			$args = array(
			'labels' => array(

				'name' => 'Movies',
				'singular_name' => 'Movie',
				'add_new' => 'Add New Movie',
				'add_new_item' => 'Add New Movie',
				'edit_item' => 'Edit Item',
				'new_item' => 'Add New Item',
				'view_item' => 'View Movie',
				'search_items' => 'Search Movies',
				'not_found' => 'No Movies Found',
				'not_found_in_trash' => 'No Movies Found in Trash'

				),

			'query_var' => 'movies',
			'rewrite' => array(

				'slug' => 'movies'

				),

			'public' => true,
			'menu_icon' => admin_url().'/images/media-button-video.gif',
			'supports' => array(

				'title',
				'thumbnail',
				'excerpt',
				//'custom-fields'
				)
			);

			register_post_type( 'sz_movie', $args );


	}

			public function taxonomies(){

				$taxonomies = array();

				$taxonomies['genre'] = array(

					'hierarchical' => true,
					'public' => true,
					'query_var' => 'movie_genre',
					'rewrite' => array(

						'slug' => 'movies/genre'
						),
					'labels' => array(

				'name' => 'Genre',
				'singular_name' => 'Genre',
				'add_new_item' => 'Add Genre',
				'edit_item' => 'Edit Genre',
				'new_item_name' => 'Add New Genre',
				'update_item' => 'Update Genre',
				'all_items' => 'All Genre',
				'view_item' => 'View Movie',
				'search_items' => 'Search Genres',
				'popular_items' => 'Popular Genres',
				'add_or_remove_items' => 'Add or Remove Genre'


						)

					);

				$taxonomies['studio'] = array(

					'hierarchical' => true,
					'public' => true,
					'query_var' => 'movie_studio',
					'rewrite' => array(

						'slug' => 'movies/studio'
						),
					'labels' => array(

				'name' => 'Studio',
				'singular_name' => 'Studio',
				'add_new_item' => 'Add Studio',
				'edit_item' => 'Edit Studio',
				'new_item_name' => 'Add New Studio',
				'update_item' => 'Update Studio',
				'all_items' => 'All Studio',
				'view_item' => 'View Studio',
				'search_items' => 'Search Studios',
				'popular_items' => 'Popular Studios',
				'add_or_remove_items' => 'Add or Remove Studio'


						)

					);

				$this->register_all_taxonomies($taxonomies);
			}



		public function register_all_taxonomies($taxonomies){

			foreach ($taxonomies as $name => $arr) {
				register_taxonomy( $name , array('sz_movie'), $arr );

			}
		}

		public function metaboxes(){

			add_action('add_meta_boxes', function(){

				add_meta_box(
						'sz_movie_length', 	//ID
					 	'Movie Length', 	//Title
					 	'movie_length', 	//calback function to display the metabox in the dashboard
					 	'sz_movie'			//post type
					 );
			} );

			function movie_length($post){

				$length = get_post_meta( $post->ID, 'sz_movie_length', true );

				?>

				<p>
					<label for="sz_movie_length" >Length: </label>
					<input type="text" class="widefat" id="sz_movie_length" name="sz_movie_length" value="<?php echo esc_attr($length); ?>">
				</p>
				<?php


			}

			add_action('save_post', function($id){

				if(isset($_POST['sz_movie_length']))
				update_post_meta( 
						$id, 									//Post ID
						'sz_movie_length',						// ID/name of metabox
					 	strip_tags($_POST['sz_movie_length'])	//value to be saved
					   );
			} );

		}


		}

	add_action('init' , function(){

		new SZ_movies_post_type();
		

	} );
