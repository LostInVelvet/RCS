function Make_Palettes(){
    var bgCode = getActiveStyle('backgroundColor');
    var colorOverlayCode = getActiveStyle('stroke.color');
    var strokeCode = getActiveStyle('stroke.color');
    MakeBackgroundColorPickerPalette(bgCode);
    MakeColorOverlayPickerPalette(colorOverlayCode);
    MakeStrokeColorPickerPalette(strokeCode);
}
Make_Palettes();


/*
// This is breaking the canvas for some reason. The upper canvas is getting in the way and making things unclickable... figure it out later.
function Set_Dimensions(whatever){
	var canv_width = canvas.width;
	var canv_height = canvas.height;
	
	var width = $(window).width() * 0.5;
	var height = (canv_height / canv_width) * width;
	
	$(whatever).attr('style', 'width: ' + width + 'px !important');
	$(whatever).attr('style', 'height: ' + height + 'px !important');
	console.log("setting dimensions " + width + " " + height);
}
var canvasStuff = ['#canvas', '#canvas-wrapper', '.canvas-container', '.upper-canvas'];

for(var i = 0; i < canvasStuff.length; i++){
	//Set_Dimensions(canvasStuff[i]);
}
*/

$("#strokeWidth").slider({
    min: 0,
    max: 30,
    slide: function(event, ui){
        setActiveStyle('strokeWidth', ui.value);
        canvas.requestRenderAll();
    }
});


// Lowers the fail count every 10 minutes by 1.
// The related function yells at users for putting in the wrong password too many times for the admin controls.
var failCnt = 0;

function LowerFailCnt(){
    setTimeout(function(){
        if(failCnt > 0){
            failCnt -= 1;
        }
        LowerFailCnt();
    }, 10000);
    
}
LowerFailCnt();


$('#showAdminControls').on('click', function() {
    if(document.getElementById("adminControls").style.display == "none"){
        document.getElementById('showAdminControlsModal').style.display = "block";
    }
    else {
        document.getElementById("adminControls").style.display = "none";
    }
});
    
$('#showAdminControlsSubmitPsw').on('click', function() {
    var psw = document.getElementById('adminControlsPsw').value;
    var correctPsws = ["rcs", "jake"];
    if($.inArray(psw, correctPsws) != -1){
        document.getElementById("adminControls").style.display = "block";
        document.getElementById('showAdminControlsModal').style.display = "none";
    }
    else {
        failCnt += 1;
        
        if(failCnt <= 2){
            alert("Wrong password. Try again");
        }
        else {
            document.getElementById('showAdminControlsModal').style.display = "none";
            setTimeout(function(){
                alert("Stop trying to get into shit that you're not supposed to be in.");
            }, 100);
            
        }
        
    }
});

$('#clearConfirmBtn').on('click', function() {
    canvas.clear();
    
    canvas.backgroundColor = '#ffffff';
    SetPlateOverlay();
    
    $('.modal').hide();
}); 

$('#finishConfirmBtn').on('click', function() {
    var finishModal = document.getElementById('finishModal');
    var finishConfirmModal = document.getElementById('finishConfirmModal');
	
	var json = JSON.stringify(canvas);
	
	$('input[name="custom_design_meta"]').val(json);
	
	/*
	$(".design-wrapper").css('display', 'block');
	$('select[name="design"]').val('custom');
	*/
	
	$('.single_add_to_cart_button').click();
	
	document.getElementById('CdModal').style.display = "none";
    finishModal.style.display = "none";
    finishConfirmModal.style.display = "block";
});

$('#printPlate').on('click', function() { 
    fabric.Image.fromURL('../../wp-content/plugins/custom-designer/images/plate-edge.png', function(oImg) {
		oImg.set({
			scaleX: canvas.width / oImg.width,
			scaleY: canvas.height / oImg.height,
			opacity: 0.85
		});
        canvas.setOverlayImage(oImg, canvas.requestRenderAll.bind(canvas));
    });
            
    canvas.deactivateAll().requestRenderAll();
    
    setTimeout(function(){
        var win=window.open();
        win.document.title = "Print page title";
        win.document.write('<head><style type="text/css" media="print">@page { margin: 0px; } body { margin-left: .85in; margin-top: 1in; } img {width: ' + cd_canv_width + 'in; height: ' + cd_canv_height + 'in; margin: auto;-webkit-transform: scaleX(-1); transform: scaleX(-1);}</style></head><body><img src="' + canvas.toDataURL() + '" onload="window.print(); window.close();"/></body>');
        
        setTimeout(function(){
            SetPlateOverlay();
        }, 500);
    }, 2000);
    
});

$('#flipX').on('click', function() {
    canvas.getActiveObject().toggle("flipX");
    canvas.requestRenderAll();
}); 

function SaveJSON(){
    var json = JSON.stringify(canvas);
    var filename = "CustomLicencePlateDesign.DesignsByRCS";
    var blob = new Blob([json], {type: "application/json" });
    saveAs(blob, filename);
}
function SavePNG(){
    var ua = window.navigator.userAgent;
 
    if (ua.indexOf("Chrome") > 0) {
        var link = document.createElement('a');
        link.download = "plate.png";
        link.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
        link.click();
    }
    else {
        alert("Please use Chrome");
    }
                
    /*
    var png = canvas.toDataURL('png');
    var filename = "CustomLicencePlateDesign.png";
    var blob = new Blob([png], {type: "image/png" });
    saveAs(blob, filename);*/
}

$('#saveJSON').on('click', function(){
    SaveJSON();
});

$('#savePNG').on('click', function(){
    SavePNG();
});

$('#makeAllTextStylesSame').on('click', function(){
    var activeStyle = canvas.getActiveObject().styles;
    console.log(canvas.getActiveObject());
    
    var objs = canvas.getObjects();
    for(var i = 0; i < objs.length; i++){
        if(objs[i].type == "text"){
            objs[i].style = activeStyle;
        }
    }
})


// --------------------------------------------------------
// Set the guidelines overlay

var guidelinesShown = true;

$('#showGuidelines').on('click', function() {
    if (guidelinesShown === true){
		fabric.Image.fromURL(cd_template_overlay, function(oImg) {
		oImg.set({
			scaleX: canvas.width / oImg.width,
			scaleY: canvas.height / oImg.height,
			opacity: 0.85
		});
        canvas.setOverlayImage(oImg, canvas.requestRenderAll.bind(canvas));
    });
        
        guidelinesShown = false;
    }
    else {
        SetPlateOverlay()
        guidelinesShown = true;
    }
});


// --------------------------------------------------------
// Set the overlay

function SetPlateOverlay(){
    fabric.Image.fromURL(cd_guidelines_overlay, function(oImg) {
		oImg.set({
			// Someone mentioned using oImg._originalElement.naturalWidth but it's breaking it for this.
			scaleX: canvas.width / oImg.width,
			scaleY: canvas.height / oImg.height,
			opacity: 0.85
		});
        canvas.setOverlayImage(oImg, canvas.requestRenderAll.bind(canvas));
    });
}


// --------------------------------------------------------
// Hide/Display Controls
canvas
    .on('selection:created', function(e){ Hide_Display_Controls(e); } )
    .on('selection:updated', function(e){ Hide_Display_Controls(e); } );

canvas.on('before:selection:cleared', function(e) {
    document.getElementById('imageControls').style.display = "none";
    document.getElementById('textControls').style.display = "none";
    document.getElementById('allControls').style.display = "none";
    document.getElementById('clickSomething').style.display = "block";
    
});
    
function Hide_Display_Controls(e) {
        if (e.target.type === 'image') {
            document.getElementById('imageControls').style.display = "block";
            document.getElementById('textControls').style.display = "none";
        }
        else if(e.target.type === 'text'){
            document.getElementById('imageControls').style.display = "none";
            document.getElementById('textControls').style.display = "block";
        }
        document.getElementById('allControls').style.display = "block";
        document.getElementById('clickSomething').style.display = "none";
        
        var strokeControls = document.getElementById('strokeControls');
        var glowPalette = document.getElementById('glowPalette');
        
        if(e.target.stroke && e.target.strokeWidth > 0){
            strokeControls.style.display = "block";
            $('#strokeWidth').slider('value', e.target.strokeWidth);
        }
        else{
           strokeControls.style.display = "none"; 
        }
        
        if(e.target.shadow && e.target.shadow != "2px 2px 5px rgba(0,0,0,0.9)"){
            glowPalette.style.display = "block"; 
        }
        else{
           glowPalette.style.display = "none"; 
        }
}

// --------------------------------------------------------
// Add Text
$("#textForm").submit(function() {
    var desiredText = document.getElementById('text-spot').value;
    if(desiredText !== ""){
        var text = new fabric.Text(desiredText, {
				fill: '#7ba0f3',
                fontFamily: 'lobster',
                fontSize: 350,
                originX: 'center',
                originY: 'center',
                padding: parseInt(30),
        });
        canvas.add(text);
        canvas.centerObject(text);
        SelectNewestObject();
        FixUnclickable();
        
        document.getElementById('text-spot').value = "";
    }
    return false;
});


// --------------------------------------------------------
// Change Background - This will only work offline. Browsers won't support it online due to security issues.
bgNumber.oninput = function () {
    if (this.value.length > 5)
        this.value = this.value.slice(0,5); 
}

$("#bgForm").submit(function() {
    var bgNumber = document.getElementById('bgNumber').value;
    
     if(bgNumber>99999 || bgNumber < 10000){
        alert("Error. Please make sure the code length is 5 numbers.");
    }
    else {
        try {
            var imageName = bgNumber + ".jpg";
            
            fabric.Image.fromURL(imageName, function (img) {
                var oImg = img.set({left: 0, top: 0, angle: 0});
                var scaleByAmt = oImg.width / canvas.getWidth();
                oImg.width = canvas.getWidth();
                
                var height = oImg.height / scaleByAmt;
                if(height < canvas.getHeight()){
                    oImg.height = canvas.getHeight();
                }
                else {
                    oImg.height = height;
                }
                canvas.setBackgroundImage(oImg, canvas.requestRenderAll.bind(canvas));
            });
        }
        catch(err) {
            alert("Error. Background image was not found. Please make sure you have the correct code sequence.");
        }
    }
    return false;
});

/*
document.getElementById('loadJSONFile').addEventListener("change", function (e) {
    console.log("RAWR");
    var file = e.target.files[0];
    var reader = new FileReader();
    
    reader.onload = function (f) {
        var data = f.target.result;  
        
        var fileExtension = ['json', 'DesignsByRCS'];
        if ($.inArray(file.name.split('.').pop().toLowerCase(), fileExtension) == -1){
            alert("Only '.json' and '.DesignsByRCS' formats are allowed.");
        }
        else{
            var json = reader.readAsDataURL(file);
            console.log(json);
            canvas.loadFromJSON(json, function(){
                canvas.requestRenderAll();
            });
                
        }
    };
    
    reader.readAsDataURL(file);
    $("#uploadJSON")[0].reset();
  }*/

// --------------------------------------------------------
// Upload image and reset form so that I can upload an image twice in a row.

document.getElementById('uploadImg').addEventListener("change", function (e) {
    // Make sure the file api works.
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        var file = e.target.files[0];
        var reader = new FileReader();
        var maxUploadSize = 0.85;
        
        reader.onload = function (f) {
            var data = f.target.result;  
            
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
            if ($.inArray(file.name.split('.').pop().toLowerCase(), fileExtension) == -1){
                alert("Only '.jpeg','.jpg', '.png', '.gif', and '.bmp' formats are allowed.");
            }
            else{
                fabric.Image.fromURL(data, function (img) {
                    var oImg = img.set({
                        angle: 0,
                        left: 0, 
                        top: 0,  
                        originX: 'center', 
                        originY: 'center'
                    });
                    
                    if(oImg.width < canvas.getWidth() / 4 || oImg.height < canvas.getHeight() /4 ){
                        alert("This image appears to be small. Stretching it out may cause blurriness. You may proceed, but we highly recommend using a larger image.");
                    }
                    else{
                        oImg.scaleToHeight(canvas.getHeight() * maxUploadSize);
                        
                        if(oImg.width > canvas.width * maxUploadSize){
                            oImg.scaleToWidth(canvas.getWidth() * maxUploadSize);
                        }
                    }
                    
                    canvas.add(oImg).requestRenderAll();
                    canvas.centerObject(oImg);
                    
                    SelectNewestObject();
                    FixUnclickable();
                    
                    
                });
            }
            
            /*
            // This was in rcs-start but I'm not sure why? I have this other stuff here... Maybe it's just unnecessary?
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
            */
        };
        reader.readAsDataURL(file);
        $("#uploadImage")[0].reset();
    }
    else {
        alert('Error. Uploading images is not supported in this browser. Please use another browser such as Chrome.');
    }
});

// --------------------------------------------------------
// Select the most recent object

function SelectNewestObject(){
    var canvasObjects = canvas._objects;
    var newest = canvasObjects[canvasObjects.length-1];
    canvas.setActiveObject(newest);
}
