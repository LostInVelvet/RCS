(function(){

var matrices = {
    blackwhite: [
                  1.5, 1.5, 1.5, 0, -1,
                  1.5, 1.5, 1.5, 0, -1,
                  1.5, 1.5, 1.5, 0, -1,
                  0, 0, 0, 1, 0,
                ],
                
    kodachrome: [
                  1.12855,-0.39673,-0.03992,0,0.24991,
                  -0.16404,1.08352,-0.05498,0,0.09698,
                  -0.16786,-0.56034,1.60148,0,0.13972,
                  0,0,0,1,0
                ],
    
    polaroid:   [
                  1.438,-0.062,-0.062,0,0,
                  -0.122,1.378,-0.122,0,0,
                  -0.016,-0.016,1.483,0,0,
                  0,0,0,1,0
                ],
                
    sepia:      [
                  0.393, 0.769, 0.189, 0, 0,
                  0.349, 0.686, 0.168, 0, 0,
                  0.272, 0.534, 0.131, 0, 0,
                  0, 0, 0, 1, 0
                ],
                
    vintage:    [
                  0.62793,0.32021,-0.03965,0,0.03784,
                  0.02578,0.64411,0.03259,0,0.02926,
                  0.04660,-0.08512,0.52416,0,0.02023,
                  0,0,0,1,0
                ]
};
    
$("input[type=radio][name=cd_image_filters]").on("change", function(){
    var obj = canvas.getActiveObject();
    var filter_type = $(this).val();
    obj.filters = [];

    if(filter_type != "none") {
        if(filter_type == "grayscale"){
            filter = new fabric.Image.filters.Grayscale();
        }
        else if(filter_type == "blend-color"){
            //obj.filters['blend-color']['color'] = '#00f900';
            
            // Tint at opacity 1 works good for coloring things solid - It'd work for clipart but I need add and multiply. 
            filter = new fabric.Image.filters.BlendColor({
                color: '#3513B0',
                mode: 'add'
            });
        }
        else {
            filter = new fabric.Image.filters.ColorMatrix({
                        matrix: matrices[filter_type]
                    });
        }  
        obj.filters.push(filter);
    }
    obj.applyFilters();
    canvas.requestRenderAll();
});
/*
$("input[type=radio][name=cd_color_type]").on("change", function(){
	var obj = canvas.getActiveObject();
    var filter_type = $(this).val();
	
	if(filter_type == add){
		filter = new fabric.Image.filters.BlendColor({
        	color: '#3513B0',
            mode: 'add'
        });
	}
	else if(){
			filter = new fabric.Image.filters.BlendColor({
                color: '#3513B0',
                mode: 'add'
            });
	}
	else if(){
		filter = new fabric.Image.filters.BlendColor({
                color: '#3513B0',
                mode: 'add'
            });
	}
});	*/

canvas
    .on('selection:created', function(e){ Set_Filter_Selection(e); } )
    .on('selection:updated', function(e){ Set_Filter_Selection(e); } );


function Set_Filter_Selection(e){
    if (e.target.type === 'image') {
        var obj = canvas.getActiveObject();
        
        if(obj.filters[0]){
            console.log(obj.filters[0].type);
            if(obj.filters[0].type == "Grayscale"){
                 $("input[type=radio][name=cd_image_filters]").filter("[value=grayscale]").prop('checked', true);
            }
            else if(obj.filters[0].type == "ColorMatrix"){
                var key_found = false;
                var color_matrix = JSON.stringify(obj.filters[0].matrix);
                
                for(var key in matrices){
                    if(JSON.stringify(matrices[key]) == color_matrix){
                        $("input[type=radio][name=cd_image_filters]").filter("[value=" + key + "]").prop('checked', true);
                        key_found = true;
                        break;
                    }
                }
                
                if(!key_found){
                     $("input[type=radio][name=cd_image_filters]").filter("[value=none]").prop('checked', true);
                }
            }
            else if(obj.filters[0].type == "BlendColor"){
                console.log(JSON.stringify(obj.filters[0]));
                // deal with the custom colors!
            }
        }   
        else{
            $("input[type=radio][name=cd_image_filters]").filter("[value=none]").prop('checked', true);
       }
    }
}

// End of (function(){
})();