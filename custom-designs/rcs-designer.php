<div id="CdModal" ng-app="kitchensink">
    <div class="main-modal-content">
        <span class="closeDesigner">&times;</span>

        <div id="thankYou" style="background-color: #b9c6cf; color: #07668e; padding: 30px; text-align: center;">This software is currently in development. If you have any feedback, please scroll to the bottom to send me a message.<br>
        If everything seems too big, please try zooming out. The controls should be to the right of the design area.<br>
        This website is currently made to run with Chrome. Other browsers may or may not work.
        <br><br>Thank you for testing it out!</div>
        
        <div id="bd-wrapper" ng-controller="CanvasControls">
              <!--[if IE]><script src="http://fabricjs.com/lib/fonts/Delicious.font.js"></script><![endif]-->
        
            <div id="slider"></div>
              
            
            <!--        Deal with the fade in from this but get rid of the weird ass formatting.
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
            -->
    
            <!-- Modals -->
            
            <div class="modalNoClickout" id="cropModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                        <h5 class="modal-title" id="modalLabel">Cropper</h5>
                        
                        <form id="cropperType">
                            <input type="radio" id="cropperTypeSquare" name="cropperType" />
                            <label for="cropperTypeSquare">Square</label>
                            
                            <input type="radio" id="cropperTypeRectangle" name="cropperType" />
                            <label for="cropperTypeRectangle">Rectangle</label>
                            
                            <input type="radio" id="cropperTypeCircle" name="cropperType" checked="checked" />
                            <label for="cropperTypeCircle">Circle</label>
                            
                            <input type="radio" id="cropperTypeOval" name="cropperType" />
                            <label for="cropperTypeOval">Oval</label>
                        </form>
                        
                    </div>
                      
                    <div class="modal-body">
                        <div id="cropImgContainer"></div>
                    </div>
                    
                    <div class="modal-footer">
                        <input type="button" id="button" value="Crop">
                    </div>
                </div>
            </div>
    
    
            <div id="bgImageFromDBModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>If you haven't already picked out a background image, please refer to the background book over on the table.</p>
                    <form id="bgForm">
                        Your Background Number: <input type="number" max="99999" name="bgNumber" id="bgNumber" >
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
                
            <div id="clearModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>Are you sure you want to clear the page?<br>
                    <input type="button" id="clearConfirmBtn" value="Yes, remove everything. I want to start over!"></p>
                </div>
            </div>
    
			
            <div id="clipartModal" class="modal">
                <div class="modal-content">
                    <span id="close-clipart">&times;</span>
                    <p>
						Clipart text will go here.
					</p>
                </div>
            </div>
			
                
            <div id="finishModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>Are you sure you're finished?<br>
                    Please make sure everything is spelled properly. Changes cannot be made after this point. <br>
                    <input type="button" id="finishConfirmBtn" value="Yes, I'm sure everything is correct"></p>
                </div>
            </div>
                
            <div id="finishConfirmModal" class="modal">
                <div class="modal-content">
                    <span id="close-all">&times;</span>
                    <p>Finished!<br>
                    Please add the item to your cart now.<br>
                	If you would like to make another design, add this item to your cart before designing a new plate.</p>
                </div>
            </div>
        
            <!-- End Modals -->
            
    
            <br>
            
            <div id="content" ng-click="maybeLoadShape($event)">
				<input type="button"  id="clipartBtn" value="Clipart"> 
				
                <div id="cd_top">
                	<div id="cd_1">
                        <form id="textForm">
                            <textarea id="text-spot" placeholder="Add Your Name or Other Text Here"></textarea>
                            <input type="submit" id="text-button" value="Add Text"> 
                        </form><br>
                        <form id="uploadImage">
                            Add Your Own Image: <input type="file" id="uploadImg" accept="image/gif, image/jpeg, image/png, image/gif, image/bmp" style="color: transparent;">
                        </form>
                        <br>
                	    Add Shape:
                    	    <img src="../../wp-content/plugins/custom-designer/images/shapes/square.png" class="add_shape" alt="Square">
                    	    <img src="../../wp-content/plugins/custom-designer/images/shapes/circle.png" class="add_shape" alt="Circle">
                    	    <img src="../../wp-content/plugins/custom-designer/images/shapes/triangle.png" class="add_shape" alt="Triangle">
                    	    <img src="../../wp-content/plugins/custom-designer/images/shapes/star.png" class="add_shape" alt="Star">
                    	    <img src="../../wp-content/plugins/custom-designer/images/shapes/heart.png" class="add_shape" alt="Heart">
                    	    <img src="../../wp-content/plugins/custom-designer/images/shapes/line.png" class="add_shape" alt="Line">
                	</div>
                	<div id="cd_2">
                		<label for="canvas-background-picker">Background Color:</label> <input type='text' id="backgroundColorPickerPalette" bind-value-to="canvasBgColor" /> <br>
                		<input type="button"  id="showGuidelines" value="Guidelines">
                	</div>
                	<div id="cd_3">
                        <input type="button"  id="finishBtn" value="Finish"> 
                        <input type="button"  id="clearBtn" value="Clear">
                    </div>
                </div>
            
                <!-- In Progress -->
                <input type="button"   bind-value-to="fill" style="float: left; display: none !important;" value="If you see this button, something went wrong. Try refreshing the page."> 
            
            
                <div id="canvas-wrapper">
                	<script>  function Set_Canvas_Dimension(){
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
                        Set_Canvas_Dimension();  
                    </script>
                </div>
            
                <div class="tab-content">
                    <div class="tab-pane active object-controls" id="object" object-buttons-enabled="getSelected()">
                        <div id="controls-wrapper" >
                            <!-- <div id="text-controls" ng-show="getText()"> -->
                            <div id="textControls" style="display: none;">
                                <p>Text specific controls</p>
                                <textarea bind-value-to="text" rows="3" columns="80"></textarea><br />
                                <label for="font-family" style="display:inline-block">Font:</label>
                                <select id="font-family" class="btn-object-action" bind-value-to="fontFamily">
                                    <option value="arial">Arial</option>
                                    <option value="helvetica" selected>Helvetica</option>
                                    <option value="verdana">Verdana</option>
                                    <option value="georgia">Georgia</option>
                                    <option value="courier">Courier</option>
                                    <option value="comic sans ms">Comic Sans MS</option>
                                    <option value="impact">Impact</option>
                                    <option value="lobster">Lobster</option>
                                    <option value="Tangerine">Tangerine</option>
                                    <option value="Baloo Tamma">Baloo Tamma</option>
                                    <option value="Days One">Days One</option>
                                    <option value="Great Vibes">Great Vibes</option>
                                    <option value="Milonga">Milonga</option>
                                </select>
                                
                                <br>
                                <label for="text-align" style="display:inline-block">Align Text in Red Box:</label>
                                <select id="text-align" class="btn-object-action" bind-value-to="textAlign">
                                    <option>Left</option>
                                    <option>Center</option>
                                    <option>Right</option>
                                    <option>Justify</option>
                                </select>
                                
                                <br>
                                <!-- <div>
                                  <label for="text-font-size">Font size:</label>
                                  <input type="range" value="" min="200" max="1500" step="1" id="text-font-size" class="btn-object-action"
                                    bind-value-to="fontSize">
                                </div>-->
                                
                                <input type="button"  type="button" class="btn btn-object-action"
                                    ng-click="toggleBold()"
                                    ng-class="{'btn-inverse': isBold()}" value="Bold">
                                
                                <input type="button"  type="button" class="btn btn-object-action" id="text-cmd-italic"
                                    ng-click="toggleItalic()"
                                    ng-class="{'btn-inverse': isItalic()}" value="Italic">
                                
                                <input type="button"  type="button" class="btn btn-object-action" id="text-cmd-underline"
                                    ng-click="toggleUnderline()"
                                    ng-class="{'btn-inverse': isUnderline()}" value="Underline">
                                    
                                <div id="colorChart">
                                    Font Color: <input type='text' id="colorPickerPalette" /> 
                                </div>
                            </div>
                          

                            <div id="imageControls" style="display: none;">
                                <input type="button" id="cropBtn" data-target="#modal" value="Crop"><br>
                                
                                <div id="image_filter_controls">
                                    Image Filter:<br>
                                    <label class="cd_image_filters">None
                                        <input type="radio" value="none" name="cd_image_filters">
                                    </label>
                                    
                                    <label class="cd_image_filters">Grayscale
                                        <input type="radio" value="grayscale" name="cd_image_filters">
                                    </label>
                                    
                                    <label class="cd_image_filters">Black/White
                                        <input type="radio" value="blackwhite" name="cd_image_filters">
                                    </label>
                                    
                                    <label class="cd_image_filters">Color
                                        <input type="radio" value="blend-color" name="cd_image_filters">
                                    </label>
                                    
                                    <br>
                                    
                                    <label class="cd_image_filters">Sepia
                                        <input type="radio" value="sepia" name="cd_image_filters">
                                    </label>
                                    
                                    <label class="cd_image_filters">Vintage
                                        <input type="radio" value="vintage" name="cd_image_filters">
                                    </label>
                                    
                                    <label class="cd_image_filters">Kodachrome
                                        <input type="radio" value="kodachrome" name="cd_image_filters">
                                    </label>
                                    
                                    <label class="cd_image_filters">Polaroid
                                        <input type="radio" value="polaroid" name="cd_image_filters">
                                    </label>
                                    <br>
                                    
                                    <!-- Add a color box here -->
                                    
                                    <div id="filter_color_controls">
                                        <label class="cd_color_type">Add
                                            <input type="radio" value="add" name="cd_color_type" checked="checked">
                                        </label>
                                        
                                        <label class="cd_color_type">Multiply
                                            <input type="radio" value="multiply" name="cd_color_type">
                                        </label>
                                        
                                        <label class="cd_color_type">Tint
                                            <input type="radio" value="tint" name="cd_color_type">
                                        </label>
                                        <br>
                                        
                                        Color Strength: <div id="color_alpha"></div>
                                        <br>
                                    </div>
									<div id="cd_color_overlay">
										<input type="button"  id="set_color_overlay" class="btn btn-object-action" ng-click="Set_Color_Overlay()" value="Get rid of button">
										<div id="cd_color_overlay_palette"><input type='text' id="color_overlay_palette" /></div>
									</div>
                                </div>
                            </div>
                          
                            <!-- In Progress -->
                            <script>
                              $('#imageFilter').change(function(){
                                  var filter = $('#imageFilter').find(":selected").val();
                                  var i = new fabric.Image.filters.Grayscale()
                                  canvas.getActiveObject().filters = [new fabric.Image.filters.Grayscale()];
                              });
                            </script>
                          
                          
                            <div id="allControls" style="display: none;">
                                <input type="button"  id="setShadow" class="btn btn-object-action" ng-click="setShadow()" value="Shadow">
                                <div id="glow">
                                    <input type="button"  id="setGlow" class="btn btn-object-action" ng-click="setGlow()" value="Glow">
                                    <div id="glowPalette"><input type='text' id="glowColorPickerPalette"  /></div>
                                </div>
                                <!--<input type="button"  id="clip" class="btn btn-object-action" ng-click="clip()" value="Clip">-->
                                <input type="button"  id="strokeBtn" ng-click="setStroke(2)" value="Outline">
                                <div id="strokeControls" style="display: none;">
                                    <div id="strokePalette"><input type='text' id="strokeColorPickerPalette"  /></div>
                                    Width:  <div id="strokeWidth"></div>
                                    <!-- <div id="strokeWidth" bind-value-to="strokeWidth" ></div>
                                    <input value="2" min="0" max="30" type="range" bind-value-to="strokeWidth" class="btn-object-action"><br /> -->
                                </div>
                            
                                <div id="center">
                                    Center In Design Area:<br>
                                    <input type="button"  class="centerBtn" onclick="Center('H')" value="Horizontally">
                                    <input type="button"  class="centerBtn" onclick="Center('V')" value="Vertically">
                                    <input type="button"  class="centerBtn" onclick="Center('')" value="Both">
                                </div>
                              
                                <div id="rotate">
                                    <input type="button"  id="rotateRight" onclick='Rotate("right")' value="Rotate Right">
                                    <input type="button"  id="rotateLeft" onclick='Rotate("left")' value="Rotate Left">
                                    <input type="button"  id="rotateReset" onclick='Rotate("reset")' value="Reset Rotation">
                                </div>
                                <div id="flipX">
                                    <input type="button"  id="flipX" value="Flip Image/Text">
                                </div>
                            
                                <div>
                                    Layer Order:
                                    <input type="button"  id="send-backwards" class="btn btn-object-action"
                                        ng-click="sendBackwards()" value="Send backwards">
                                
                                    <input type="button"  id="bring-forward" class="btn btn-object-action"
                                        ng-click="bringForward()" value="Bring forwards">
                                </div>
                            
                                <input type="button"  class="btn btn-object-action" id="remove-selected"
                                    ng-click="removeSelected()" value="Remove selected Image/Text">
                            </div>
                        </div>
                
                        <div id="clickSomething" style="display: none;">Click on something to bring up the controls.</div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Bottom Section -->
        
        <div id="currentProblems" style="width: 800px;">
            <h3>Currently known problems:</h3>
            <ul>
                <li>Outlines on images cause the controls to "disappear" (it actually just goes far off the screen, but they're still there).</li>
                <li>The crop tool does not auto size to the page size. You have to scroll to use it sometimes.</li>
            </ul>
        </div>
        
        <div id="adviceSubmittedConfirm" style="background-color: #07668e; color: #b9c6cf;"></div>
        <div id="sendingMsg" style="background-color: #07668e; color: #b9c6cf;">Sending message...</div>
        
        
        <div id="adviceSubmitted">
            <form id="adviceForm" style="background-color: #b9c6cf;" method="post">
                Name: <input id="adviceName" type="text"><br>
                Email: <input id="adviceEmail" type="text"><br>
                Bugs/Problems found: <textarea id="adviceBugs" rows="4" cols="50"></textarea><br>
                Suggestions for additional features: <textarea id="adviceAdd" rows="4" cols="50"></textarea><br>
                <input type="button"  id="submitFeedback" value="Submit">
            </form>
        </div>
        
        
        
        <script>
          var kitchensink = { };
          var canvas = new fabric.Canvas('canvas');
        </script>
    </div>
</div>
