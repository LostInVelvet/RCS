<?php get_header(); ?>
<style>
	#homepage_top_banner{
		background-image: url('<?php header_image() ?>');
	}
</style>

<script>
	(function() {
		class Rcs_bg_img{
			constructor(height, width) {
				this.height = height;
				this.width = width;
			}
		}
		
		function Set_Bg_Dimensions_From_Image(img_src, div_id){
			var hp_bg_img = new Image();
			hp_bg_img.src = img_src;


			$(hp_bg_img).one('load', function(){
				var h = hp_bg_img.height
				var w = hp_bg_img.width;
				
				var screen_width = $(window).width();
				var hp_top_bg_height = h / w * screen_width;
				
				$(div_id).width(screen_width);
				$(div_id).height(hp_top_bg_height);
				$(div_id).css('background-size', $(window).width() + 'px auto');
			});	
		}
		
		$('.hp_col_hidden').click( function() {
			window.location = $(this).find("a").attr("href"); 
			console.log("clicked!");
  			return false;
		})
			
		$(window).on('load resize', function(){			
			var column_count = 3;
			var column_height = 0.8;
			
			
			$('.hp_col').width($(this).width() / column_count);
			$('.hp_col').height($(this).width() / column_count * column_height);
			
			$('.hp_col_name').width($(this).width() / column_count);

			$('.hp_col_name').each( function() {
				$(this).css('margin-top', ($('#hp_col_names').height() - $(this).height()) / 2 );
			});
			
			/*
			$('.hp_img').each(function(){
				if(this.width() > this.height()){
					$(this).width( $(this).width() / column_count * (2/3) );
				}
				else {
					$(this).height( $(this).height() / column_count * (2/3) );
				}
				
			});*/
			
			
			if( "<?php header_image() ?>" ){
				Set_Bg_Dimensions_From_Image("<?php echo header_image(); ?>", "#homepage_top_banner");
			}
			
			if( <?php if ( get_theme_mod( 'background_image' ) ) : echo  "true"; else : echo "false"; endif; ?> == true){
				//if($(window).height() >  ){
					//$("html").css('background-size', $(window).width() + 'px auto');
				//}
			}
			
			$('.hp_col_hidden').width($(this).width() / column_count);
			$('.hp_col_hidden').height($('#homepage_columns').height());
			
			var max_size = 0.90;
			var hp_col_hidden_text_scale = 1.2;
			
			var outer_size = $('.hp_col_hidden').width();
			var max_inner_size = ( outer_size * max_size ) / hp_col_hidden_text_scale;
			var margin_size = (outer_size - max_inner_size) / 2;
			
			
			$('.hp_col_hidden_text').css('margin-left', margin_size );
			$('.hp_col_hidden_text').css('margin-right', margin_size );
			
			$('.hp_col_hidden_text').each( function() {
				$(this).css('margin-top', ($('#homepage_columns').height() - $(this).height()) / 2 );
			});
			
			
			$('.hp_img').each( function() {
				if(this.height > this.width ){
					$(this).css('height', ( $('.hp_col').height() * (2/3) ) );
				}
				else {
					$(this).css('width', ( $('.hp_col').width() * (2/3) ) );
				}
				
				$(this).css('margin-top', ($('#hp_col_imgs').height() - $(this).height()) / 2 );
				$(this).css('margin-left', ($('.hp_col').width() - $(this).width()) / 2 );
				
			});
		});
	})();
</script>

<div id="homepage_top_banner"></div>
<section id="service_section">
	<div id="homepage_title">Our Services</div>
	<div id="homepage_bottom_section">
		<div id="homepage_columns">
			<div id="hp_cols_hidden">
				<?php
				$div_col_hidden = '<div class="hp_col_hidden">';
				$div_col_hidden_text = '<div class="hp_col_hidden_text">';
				$div_end = '</div>';

				$div_all = '';
				
				for($i = 1; $i <= 3; $i++){
					$div_mod_txt = 'column_text' . $i;
					$div_mod_link = 'column_link' . $i;

					$div_all .=	'<a href="' . get_theme_mod( $div_mod_link ) . '">' . 
									$div_col_hidden . 
										$div_col_hidden_text . '<span>' . get_theme_mod( $div_mod_txt ) . '</span>' . $div_end .
									$div_end.
								'</a>';
				}	
				echo $div_all;
				?>
			</div>
			<div id="hp_col_names">
				<?php
				$column_count = 3;
				$head_name = '<header class="hp_col_name">';
				$head_end = '</header>';
				$prnt_all = '';
				

				for($i = 1; $i <= 3; $i++){
					$head_mod_name = 'column_name' . $i;

					$prnt_all .=	$head_name . get_theme_mod( $head_mod_name ) . $head_end;
				}
				echo $prnt_all;
				?>
			</div>
			<div id="hp_col_imgs">
				<?php				
				$div_start = '<div class="hp_col">';
				$hp_img_start = '<img class="hp_img" src="';
				$hp_img_end = '"/>';
				$div_end = '</div>';
				$div_all = '';

				for($i = 1; $i <= 3; $i++){
					$div_mod_name = 'column_name' . $i;
					$hp_mod_img = 'column_img' . $i;

					$div_all .=	$div_start.
									$hp_img_start . esc_url( get_theme_mod( $hp_mod_img ) ) . $hp_img_end .
								$div_end;
				}
				echo $div_all;
				?>
			</div>
			
		</div>
	</div>
</section>

<section id="homepage_bottom">
	<div id="homepage_text">
		<div id="homepage_inner_text">	
			<?php
			if (have_posts()):
			  while (have_posts()) : the_post();
				the_content();
			  endwhile;
			else:
			  echo '<p>Sorry, no posts matched your criteria.</p>';
			endif;
			?>
		</div>
	</div>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>