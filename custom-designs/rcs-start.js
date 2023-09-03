// --------------------------------------------------------
// Center Object

function Center(type){
    switch(type){
        case 'H': canvas.getActiveObject().centerH();
                  break;
        case 'V': canvas.getActiveObject().centerV();
                  break;
        default:  canvas.getActiveObject().center();
                  break;
    }
    FixUnclickable()
}

// --------------------------------------------------------
// Fixes the issue with Fabric where objects are unclickable
// after manually setting their properties.
function FixUnclickable(){
        canvas.getActiveObject().setCoords(); 
    }
    

// --------------------------------------------------------
// Rotates the object

function Rotate(direction){
    if(direction == "reset"){
        angle = 0
    }
    else {
        var angle = canvas.getActiveObject().get('angle', 0);
    
        if(direction == "right"){
            angle += 90
        }
        else if(direction == "left"){
            angle -= 90
        }
    }
    canvas.getActiveObject().set('angle', angle);
    canvas.requestRenderAll();
    
    FixUnclickable();
}


// --------------------------------------------------------
// Sets the dimensions of the canvas based on the screen size
function Set_Canvas_Dimension(){
    var canv_pixel_size = 2500;
    var canv_pixel_height;
    var canv_pixel_width;
    var canv_screen_height;
    var canv_screen_width = $(window).width();
        
        		  
    if (cd_canv_height * 0.8 > cd_canv_width * 0.5){
    	canv_pixel_height = canv_pixel_size;
    	canv_pixel_width = canv_pixel_height * (cd_canv_width / cd_canv_height);
        			
    	canv_screen_height = $(window).height() * 0.8;
    	canv_screen_width = canv_screen_height * (cd_canv_width / cd_canv_height);
    			
    }
    else {
    	canv_pixel_width = canv_pixel_size;
    	canv_pixel_height = canv_pixel_width * (cd_canv_height / cd_canv_width);
        			
    	canv_screen_width = $(window).width() * 0.5;
    	canv_screen_height = canv_screen_width * (cd_canv_height / cd_canv_width);
    }
    		
    document.write('<style> #canvas, #canvas-wrapper, .canvas-container, .upper-canvas{' + 
    	'height: ' + canv_screen_height + 'px !important; ' +
    	'width: ' + canv_screen_width + 'px !important; ' + 
    	'</style>' +
    	'<canvas id="canvas" height="' + canv_pixel_height + '" width="' + canv_pixel_width + '"></canvas>'
    );
}