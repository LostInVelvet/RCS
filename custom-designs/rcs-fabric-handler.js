(function(global) {
  function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  function pad(str, length) {
    while (str.length < length) {
      str = '0' + str;
    }
    return str;
  }

  var supportsInputOfType = function(type) {
    return function() {
      var el = document.createElement('input');
      try {
        el.type = type;
      }
      catch(err) { }
      return el.type === type;
    };
  };

  var supportsSlider = supportsInputOfType('range'),
      supportsColorpicker = supportsInputOfType('color');

  global.supportsSlider = supportsSlider;
  global.supportsColorpicker = supportsColorpicker;
  global.capitalize = capitalize;

})(this);


// --------------------------------------------------------
// Kitchensink Stuff

var kitchensink = angular.module('kitchensink', []);
kitchensink.config(function($interpolateProvider) {
  $interpolateProvider
    .startSymbol('{[')
    .endSymbol(']}');
});

kitchensink.directive('bindValueTo', function() {
  
  return {
    restrict: 'A',

    link: function ($scope, $element, $attrs) {

      var prop = capitalize($attrs.bindValueTo),
          getter = 'get' + prop,
          setter = 'set' + prop;

      $element.on('change keyup select', function() {
        if ($element[0].type !== 'checkbox') {
          $scope[setter] && $scope[setter](this.value);
        }
      });

      $element.on('click', function() {
        if ($element[0].type === 'checkbox') {
          if ($element[0].checked) {
            $scope[setter] && $scope[setter](true);
          }
          else {
            $scope[setter] && $scope[setter](false);
          }
        }
      })

      $scope.$watch($scope[getter], function(newVal) {
        if ($element[0].type === 'radio') {
          var radioGroup = document.getElementsByName($element[0].name);
          for (var i = 0, len = radioGroup.length; i < len; i++) {
            radioGroup[i].checked = radioGroup[i].value === newVal;
          }
        }
        else if ($element[0].type === 'checkbox') {
          $element[0].checked = newVal;
        }
        else {
          $element.val(newVal);
        }
      });
    }
  };
});

kitchensink.directive('objectButtonsEnabled', function() {
  return {
    restrict: 'A',

    link: function ($scope, $element, $attrs) {
      $scope.$watch($attrs.objectButtonsEnabled, function(newVal) {

        $($element).find('.btn-object-action')
          .prop('disabled', !newVal);
      });
    }
  };
});












function getActiveStyle(styleName, object) {
  object = object || canvas.getActiveObject();
  if (!object) return '';

  return (object.getSelectionStyles && object.isEditing)
    ? (object.getSelectionStyles()[styleName] || '')
    : (object[styleName] || '');
};

function setActiveStyle(styleName, value, object) {
  object = object || canvas.getActiveObject();
	
  if (!object) return;

  if (object.setSelectionStyles && object.isEditing) {
    var style = { };
    style[styleName] = value;
    object.setSelectionStyles(style);
    object.setCoords();
  }
  else {
    object.set(styleName, value);
  }

  object.setCoords();
  canvas.requestRenderAll();
};

function getActiveProp(name) {
  var object = canvas.getActiveObject();
  if (!object) return '';

  return object[name] || '';
}

function setActiveProp(name, value) {
  var object = canvas.getActiveObject();
  if (!object) return;
  object.set(name, value).setCoords();
  canvas.requestRenderAll();
}

var colorChosen;
function addAccessors($scope) {

  $scope.getFill = function() {
    var rgbCode = rgbCode = getActiveStyle('fill');
    if(rgbCode == null){
        rgbCode = colorChosen;
    }
    //MakeColorPicker(rgbCode);
    MakeColorPickerPalette(rgbCode);
    return getActiveStyle('fill');
  };
  $scope.setFill = function(value) {
    setActiveStyle('fill', value);
    canvas.requestRenderAll();
  };

  $scope.isBold = function() {
    return getActiveStyle('fontWeight') === 'bold';
  };
  $scope.toggleBold = function() {
    setActiveStyle('fontWeight',
      getActiveStyle('fontWeight') === 'bold' ? '' : 'bold');
  };
  $scope.isItalic = function() {
    return getActiveStyle('fontStyle') === 'italic';
  };
  $scope.toggleItalic = function() {
    setActiveStyle('fontStyle',
      getActiveStyle('fontStyle') === 'italic' ? '' : 'italic');
  };

  $scope.isUnderline = function() {
    return getActiveStyle('textDecoration').indexOf('underline') > -1 || getActiveStyle('underline');
  };
  $scope.toggleUnderline = function() {
    var value = $scope.isUnderline()
      ? getActiveStyle('textDecoration').replace('underline', '')
      : (getActiveStyle('textDecoration') + ' underline');

    setActiveStyle('textDecoration', value);
    setActiveStyle('underline', !getActiveStyle('underline'));
  };

  $scope.getText = function() {
    return getActiveProp('text');
  };
  $scope.setText = function(value) {
    setActiveProp('text', value);
  };

  $scope.getTextAlign = function() {
    return capitalize(getActiveProp('textAlign'));
  };
  $scope.setTextAlign = function(value) {
    setActiveProp('textAlign', value.toLowerCase());
  };

  $scope.getFontFamily = function() {
    return getActiveProp('fontFamily').toLowerCase();
  };
  $scope.setFontFamily = function(value) {
    setActiveProp('fontFamily', value.toLowerCase());
  };

  $scope.getStroke = function() {
    return getActiveStyle('stroke');
  };
  $scope.setStroke = function(value) {
    var defaultStrokeWidth = 4;
    var obj = canvas.getActiveObject();
    var strokeControls = document.getElementById('strokeControls');
    
    if (!obj) return;

    if (obj.stroke && obj.strokeWidth > 0) {
        obj.strokeWidth = 0;
        strokeControls.style.display = "none";
    }
    else {
        if(obj.fill == 'rgb(0,0,0)'){
            setActiveStyle('stroke', 'rgb(256, 256, 256)');
        }
        else {
            setActiveStyle('stroke', 'rgb(0,0,0)');
        }
        setActiveStyle('strokeWidth', defaultStrokeWidth);
        $('#strokeWidth').slider('value', defaultStrokeWidth);
        strokeControls.style.display = "block";
    }
    canvas.requestRenderAll();
    setActiveStyle('stroke', value);
  };

  $scope.getStrokeWidth = function() {
    return getActiveStyle('strokeWidth');
  };
  $scope.setStrokeWidth = function(value) {
    setActiveStyle('strokeWidth', parseInt(value, 10));
  };

  $scope.getFontSize = function() {
    return getActiveStyle('fontSize');
  };
  $scope.setFontSize = function(value) {
    setActiveStyle('fontSize', parseInt(value, 10));
  };

  $scope.getBold = function() {
    return getActiveStyle('fontWeight');
  };
  $scope.setBold = function(value) {
    setActiveStyle('fontWeight', value ? 'bold' : '');
  };

  $scope.getCanvasBgColor = function() {
    return canvas.backgroundColor;
  };
  $scope.setCanvasBgColor = function(value) {
    
    
    canvas.backgroundColor = value;
    canvas.requestRenderAll();
  };
  
  $scope.getSelected = function() {
    return canvas.getActiveObject();
  };
  
  $scope.removeSelected = function() {
    var activeObject = canvas.getSelection();
    if(activeObject){
        if(confirm('Are you sure you want to remove this image/text?')){
            canvas.remove(activeObject);
        }
    }
    else if(activeGroup){
        if (confirm('Are you sure you want to remove this group?')) {
            var groupOfObjects = activeGroup.getObjects();
            canvas.discardActiveGroup();
            
            groupOfObjects.forEach(function(object) {
                canvas.remove(object);
            });
        }
    }
  };

  $scope.sendBackwards = function() {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
      canvas.sendBackwards(activeObject);
    }
  };

  $scope.bringForward = function() {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
      canvas.bringForward(activeObject);
    }
  };

  $scope.clip = function() {
    var obj = canvas.getActiveObject();
    if (!obj) return;

    if (obj.clipTo) {
      obj.clipTo = null;
    }
    else {
      var radius = obj.width < obj.height ? (obj.width / 2) : (obj.height / 2);
      obj.clipTo = function (ctx) {
        ctx.arc(0, 0, radius, 0, Math.PI * 2, true);
      };
    }
    canvas.requestRenderAll();
  };

  $scope.setShadow = function() {
    var obj = canvas.getActiveObject();
    var palette = document.getElementById("glowPalette");
    
    if (!obj) return;

    if (obj.shadow == "20px 20px 50px rgba(0,0,0,0.9)") {
      obj.shadow = null;
    }
    else {
        palette.style.display = "none";
        obj.setShadow({
            color: 'rgba(0,0,0,0.9)',
            blur: 50,
            offsetX: 20,
            offsetY: 20
        });
    }
    canvas.requestRenderAll();
  };
  
  $scope.setGlow = function() {
    var obj = canvas.getActiveObject();
    var palette = document.getElementById("glowPalette");
    if (!obj) return;

    if (obj.shadow && obj.shadow != "20px 20px 50px rgba(0,0,0,0.9)") {
      obj.shadow = null;
      palette.style.display = "none";
    }
    else {
        obj.setShadow({
            color: 'rgba(0,0,0,1)',
            blur: 50,
            offsetX: 0,
            offsetY: 0
        });
        palette.style.display = "block";
    }
    var glow = getActiveStyle('shadow');
    rgbCode = glow.color;
    MakeGlowColorPickerPalette(rgbCode);
    canvas.requestRenderAll();
  };


  function initCustomization() {
    canvas.backgroundColor = '#ffffff';
    canvas.controlsAboveOverlay = true;
    canvas.preserveObjectStacking = true;
    canvas.selection = false;
    
    
    fabric.Object.prototype.borderColor = "#ff0000";
    fabric.Object.prototype.borderScaleFactor = 7;
    fabric.Object.prototype.cornerColor = "#ff0000";
    fabric.Object.prototype.cornerSize = 50;
    if (/(iPhone|iPod|iPad)/i.test(navigator.userAgent)) {
      fabric.Object.prototype.cornerSize = 120;
    }
    fabric.Object.prototype.padding = parseInt(0);  /* Padding > 0 causing issues with cropping. Text has it's own padding atm. */
    fabric.Object.prototype.rotatingPointOffset = 200;
    fabric.Object.prototype.transparentCorners = false;
    
    SetPlateOverlay();
    canvas.requestRenderAll();
  }
  $scope.rasterizeJSON = function() {
    $scope.setConsoleJSON(JSON.stringify(canvas));
  };
  
  $scope.getConsoleJSON = function() {
    return consoleJSONValue;
  };
  var consoleJSONValue;
  $scope.setConsoleJSON = function(value) {
    consoleJSONValue = value;
  };
  
  /*
  $scope.saveJSON = function() {
    _saveJSON(JSON.stringify(canvas));
  };

  var _saveJSON = function(json) {
    $scope.setConsoleJSON(json);
  };
  */
  
  $scope.loadJSON = function() {
    _loadJSON(consoleJSONValue);
  };

  var _loadJSON = function(json) {
    canvas.loadFromJSON(json, function(){
      canvas.requestRenderAll();
    });
  };
  
  $scope.setConsoleJSON = function(value) {
    consoleJSONValue = value;
  };

  initCustomization();
}


function watchCanvas($scope) {

  function updateScope() {
    $scope.$$phase || $scope.$digest();
    canvas.requestRenderAll();
  }

  canvas
    .on('selection:created', updateScope)
    .on('selection:updated', updateScope)
    .on('path:created', updateScope)
    .on('selection:cleared', updateScope);
}

kitchensink.controller('CanvasControls', ['$scope', function($scope) {
  $scope.canvas = canvas;
  $scope.getActiveStyle = getActiveStyle;
  addAccessors($scope);
  watchCanvas($scope);
}]);