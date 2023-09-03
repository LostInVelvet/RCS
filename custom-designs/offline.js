// --------------------------------------------------------
// Change Background - This will only work offline. Browsers won't support it online due to security issues.
$("#bgForm").submit(function() {
    var bgChar = document.getElementById('bgChar').value;
    var bgNumber = document.getElementById('bgNumber').value;
    
    if(bgChar.length > 2){
        alert("Error. Please make sure the code length is two characters.");
    }
    else if(bgNumber>99999 || bgNumber < 9999){
        alert("Error. Please make sure the code length is 5 numbers.");
    }
    else {
        try {
            var imageName = bgChar + "-" + bgNumber + ".jpg";
            
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
                canvas.setBackgroundImage(oImg, canvas.renderAll.bind(canvas));
            });
        }
        catch(err) {
            alert("Error. Background image was not found. Please make sure you have the correct code sequence.");
        }
    }
    return false;
});
