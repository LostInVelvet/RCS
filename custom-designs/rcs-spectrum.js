    
// --------------------------------------------------------
// Spectrum Code - The color picker

function MakeBackgroundColorPickerPalette(rgbCode){
    $("#backgroundColorPickerPalette").spectrum({
        color: "#ffffff",
//        flat: true,
        maxSelectionSize: 6,
        showPaletteOnly: true,
        showPalette:true,
        showSelectionPalette: true,
        palette: [
            ["000000", "777777", "ffffff", "660000", "ff0000", "993300"], 
            ["ff6600", "ffff00", "009900", "00ff00", "0000ff", "3399ff"], 
            ["00ffff", "6600ff", "9966ff", "990066", "ff33cc", "ff99ff"]
        ],
        
        togglePaletteOnly: true,
        togglePaletteLessText: 'less',
        togglePaletteMoreText: 'more',
        localStorageKey: "spectrumColors",
    });
}

 $("#backgroundColorPickerPalette").on('move.spectrum', function() {
    var hexCode = $("#backgroundColorPickerPalette").spectrum("get").toHexString();
    canvas.backgroundColor = hexCode;
    canvas.renderAll();
});

/*
function MakeColorPicker(rgbCode){
    $("#colorPicker").spectrum({
//        clickoutFiresChange: true,
        color: rgbCode,
//        flat: true,
        maxSelectionSize: 8,
        palette: [
            ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
            ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
            ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
            ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
            ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
            ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
            ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
            ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
        ],
        preferredFormat: "hex",
        showInitial: true,
        showInput: true,
        localStorageKey: "spectrumColors",
    });
}


$("#colorPicker").on('move.spectrum', function() {
    var hexCode = $("#colorPicker").spectrum("get").toHexString();
    setActiveStyle('fill', hexCode);
    canvas.renderAll();
});

$("#colorPicker").on('change.spectrum', function() {
    var hexCode = $("#colorPicker").spectrum("get").toHexString();
    colorChosen = hexCode;
    setActiveStyle('fill', hexCode);
    var t = getActiveStyle('fill');
    MakeColorPickerPalette(hexCode);
    
    canvas.renderAll();
});

*/

function MakeColorPickerPalette(rgbCode){
    $("#colorPickerPalette").spectrum({
        color: rgbCode,
//      flat: true,
        maxSelectionSize: 6,
        showPaletteOnly: true,
        showPalette:true,
        showSelectionPalette: true,
        palette: [
            ["000000", "777777", "ffffff", "660000", "ff0000", "993300"], 
            ["ff6600", "ffff00", "009900", "00ff00", "0000ff", "3399ff"], 
            ["00ffff", "6600ff", "9966ff", "990066", "ff33cc", "ff99ff"]
        ],
        
        togglePaletteOnly: true,
        togglePaletteLessText: 'less',
        togglePaletteMoreText: 'more',
        localStorageKey: "spectrumColors",
    });
}

 $("#colorPickerPalette").on('move.spectrum', function() {
    var hexCode = $("#colorPickerPalette").spectrum("get").toHexString();
    var obj = canvas.getActiveObject();
    setActiveStyle('fill', hexCode);
    canvas.renderAll();
});


function MakeGlowColorPickerPalette(rgbCode){
    $("#glowColorPickerPalette").spectrum({
        color: rgbCode,
        flat: true,
        showPaletteOnly: true,
        showPalette:true,
        palette: [
            ["ff0000", "ff6600", "ffff00", "009900", "3399ff"],
            ["000000", "777777", "ffffff", "6600ff", "ff33cc"],
        ],
        togglePaletteOnly: true,
        togglePaletteLessText: 'less',
        togglePaletteMoreText: 'more',
        localStorageKey: "spectrumColors",
    });
}

 $("#glowColorPickerPalette").on('move.spectrum', function() {
    var hexCode = $("#glowColorPickerPalette").spectrum("get").toHexString();
    var obj = canvas.getActiveObject();
    obj.shadow.color = hexCode;
    canvas.renderAll();
});


function MakeStrokeColorPickerPalette(rgbCode){
    $("#strokeColorPickerPalette").spectrum({
        color: rgbCode,
        flat: true,
        showPaletteOnly: true,
        showPalette:true,
        palette: [
            ["ff0000", "ff6600", "ffff00", "009900", "3399ff"],
            ["000000", "777777", "ffffff", "6600ff", "ff33cc"],
        ],
        togglePaletteOnly: true,
        togglePaletteLessText: 'less',
        togglePaletteMoreText: 'more',
        localStorageKey: "spectrumColors",
    });
}

 $("#strokeColorPickerPalette").on('move.spectrum', function() {
    var rgbCode = $("#strokeColorPickerPalette").spectrum("get").toRgbString();
    var obj = canvas.getActiveObject();
    setActiveStyle('stroke', rgbCode);
    canvas.renderAll();
});

function MakeColorOverlayPickerPalette(rgbCode){
    $("#color_overlay_palette").spectrum({
        color: rgbCode,
        flat: true,
        showPaletteOnly: true,
        showPalette:true,
        palette: [
            ["ff0000", "ff6600", "ffff00", "009900", "3399ff"],
            ["000000", "777777", "ffffff", "6600ff", "ff33cc"],
        ],
        togglePaletteOnly: true,
        togglePaletteLessText: 'less',
        togglePaletteMoreText: 'more',
        localStorageKey: "spectrumColors",
    });
}

 $("#color_overlay_palette").on('move.spectrum', function() {
    var hexCode = $("#color_overlay_palette").spectrum("get").toHexString();
    var obj = canvas.getActiveObject();
    obj.shadow.color = hexCode;
    canvas.renderAll();
});