$('#cropBtn').click(/*'shown.bs.modal',*/ function () {
    var cropBoxData;
    var canvasData;
    var cropper;
    var cropModal = document.getElementById('cropModal');
    
    cropModal.style.display = "block";
    
    document.getElementById("cropImgContainer").innerHTML = "<img id='cropperImg' src='" + canvas.getActiveObject().toDataURL() + "'>";
    
    var image = document.getElementById("cropperImg");

    cropper = new Cropper(image, {
        autoCropArea: 0.5,
        aspectRatio: 1,
        strict: true,
        viewMode: 1,
        zoomable: false,
        ready: function () {
            cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
        }
    });
        
    function getRoundedCanvas(sourceCanvas) {
        var roundCanvas = document.createElement('canvas');
        var context = roundCanvas.getContext('2d');
        var width = sourceCanvas.width;
        var height = sourceCanvas.height;
    
        roundCanvas.width = width;
        roundCanvas.height = height;
    
        context.imageSmoothingEnabled = true;
        imageSmoothingQuality = true;
        context.drawImage(sourceCanvas, 0, 0, width, height);
        context.globalCompositeOperation = 'destination-in';
        context.beginPath();
        context.ellipse(width/2, height/2, width/2, height/2, 0 * Math.PI, 0, 45 * Math.PI);
        context.fill();

        return roundCanvas;
    }
        
    button.onclick = function () {
        var croppedCanvas = cropper.getCroppedCanvas();
        var croppedImg
        var maxUploadSize = 0.85;
        var cropId = document.querySelector('input[name="cropperType"]:checked').id;
        var cropperType = cropId.slice(11, cropId.length);
        
        if(cropperType == "Circle" || cropperType == "Oval"){
            croppedImg = getRoundedCanvas(croppedCanvas).toDataURL();
        }
        else {
            croppedImg = croppedCanvas.toDataURL();
        }
            
        canvas.remove(canvas.getActiveObject());
        
        fabric.Image.fromURL(croppedImg, function (img) {
            var oImg = img.set({
                angle: 0,
                left: 0, 
                top: 0,  
                originX: 'center', 
                originY: 'center'
            });
                
            oImg.scaleToHeight(canvas.getHeight() * maxUploadSize);
            if(oImg.width > canvas.width * maxUploadSize){
                oImg.scaleToWidth(canvas.getWidth() * maxUploadSize);
            }
             
            canvas.add(oImg).requestRenderAll();
            canvas.centerObject(oImg);
            
            SelectNewestObject();
            FixUnclickable();
            
            $('.modalNoClickout').hide();
        });
    };
    
    
    $("#cropperType").on("change", function(){
        var cropId = document.querySelector('input[name="cropperType"]:checked').id;
        var cropperType = cropId.slice(11, cropId.length);
        
        if(cropperType == "Square"){
            $('.cropper-view-box').css({'border-radius': '0%'});
            $('.cropper-face').css({'border-radius': '0%'});
            
            cropper.setAspectRatio(1);
        }
        
        else if(cropperType == "Rectangle"){
            $('.cropper-view-box').css({'border-radius': '0%'});
            $('.cropper-face').css({'border-radius': '0%'});
            
            cropper.setAspectRatio(0);
        }
        else if(cropperType == "Circle"){
            $('.cropper-view-box').css({'border-radius': '50%'});
            $('.cropper-face').css({'border-radius': '50%'});
            
            cropper.setAspectRatio(1);
        }
        
        else if(cropperType == "Oval"){
            $('.cropper-view-box').css({'border-radius': '50%'});
            $('.cropper-face').css({'border-radius': '50%'});
            
            cropper.setAspectRatio(0);
        }
    });
});