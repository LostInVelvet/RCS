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

			
	$(window).on('load resize', function(){			
		var column_names = ['.hp_col', '.hp_col_hidden'];
		var column_count = 3;
		var column_inner_size = 0.8;
		
		for (var i = 0; i < column_names.length; i++){
			$(column_names[i]).width($(this).width() / column_count);
			$(column_names[i]).height($(this).width() / column_count * column_inner_size);
		}
		$('.hp_col_name').width($(this).width() / column_count);

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
		
		$("html").css('background-size', $(window).width() + 'px auto');

			
			
		var max_size = 0.90;
		var hp_col_hidden_text_scale = 1.2;
		
		var outer_size = $('.hp_col_hidden').width();
		var max_inner_size = ( outer_size * max_size ) / hp_col_hidden_text_scale;
		var margin_size = (outer_size - max_inner_size) / 2;
			
		console.log( outer_size + " " + max_inner_size + " " + margin_size);
		console.log($('.hp_col_hidden_text').width());
		
		$('.hp_col_hidden_text').css('margin-left', margin_size );
		$('.hp_col_hidden_text').css('margin-right', margin_size );
			
		$('.hp_col_hidden_text').each( function() {
			$(this).css('margin-top', ($('.hp_col_hidden').height() - $(this).height()) / 2 );
			console.log(this);
		});
	});
})();