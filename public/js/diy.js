
        var state;
        var undo = [];
        var redo = [];
        var canvas = new fabric.Canvas('fabricCanvas'); 
        var canvas2 = new fabric.Canvas('fabricCanvas2');
        var textInput = $('#textDesign');
        var customText;
        var currentDesign = [];
        var fontColors = $('#fontColors');
        var frontShirtTools = $('#frontView');
        var backShirtTools = $('#backView');

        // Add default image in canvas   
        fabric.Image.fromURL('/images/whiteColor.png', function(img){
            img.set({
                left: 0,
                top: 0,
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height,
                selectable: false
            });
            canvas.add(img);
        });
     
         
        // Show the back of the t shirt 
        function tshirtBack() {
          var confirmShowBack = confirm('Make sure to download your design before confirming, as it will be lost otherwise.');
          if(confirmShowBack) {
            fabric.Image.fromURL('images/Back.png', function(img){
                img.set({
                    left: 0,
                    top: 0,
                    scaleX: canvas.width / img.width,
                    scaleY: canvas.height / img.height,
                    selectable: false
                });
                canvas.clear();
                canvas.add(img);
                frontShirtTools.css('display', 'none');
                backShirtTools.css('display', 'block');
                downloadCanvas.css('display', 'none');
            });
          }
          }
          // Show the front of the T-Shirt 
          function tshirtFront() {
         var confirmDownload = confirm('Make sure to download your design before confirming, as it will be lost otherwise.'); 
         if (confirmDownload) {
          fabric.Image.fromURL('images/whiteColor.png', function(img){
                img.set({
                    left: 0,
                    top: 0,
                    scaleX: canvas.width / img.width,
                    scaleY: canvas.height / img.height,
                    selectable: false
                });
                canvas.clear();
                canvas.add(img);
                frontShirtTools.css('display', 'block');
                backShirtTools.css('display', 'none');
                downloadCanvas.css('display', 'block');
            });
         }
          }


        // --------In this section it includes all the function of the Add text tool------------

        // Click event for revealing and hiding the text tools
          $('#closeTools').click(function(){
          $('#textDesign').toggle();
         });

        // Function for add Text Tool
        $('#addText').click( function(){
             textInput.toggle();
        });
      
        // Click event for adding the font on canvas
        $('#addToCanvas').click( function(){
            var text = $('#textToAdd').val();
             customText = new fabric.Textbox(text, {
              left: 150,
              top: 120,
              fontSize: 30,
              fontStyle: 'normal',
              selectable: true
            });
           if(customText) {
            canvas.add(customText);
           }
           else {
            console.log("No Input");
           }
            currentDesign.push(customText);   
        });

        // Function for changing the font color
        function changeFontColor(color){
          customText.set({
            fill: color
          });
          canvas.renderAll();
        }
        // Function for making the custom text Bold
        function fontBold() {
          var defaultFontStyle = customText.get('fontStyle') || 'normal';
          var boldStyle = defaultFontStyle === 'bold' ? 'normal' : 'bold';
          customText.set({ fontStyle: boldStyle });
          canvas.renderAll();
         }

        // Function for making the text Italic
        function fontItalic() {
         var defaultFontStyle = customText.get('fontStyle') || 'normal';
         var italicStyle  = defaultFontStyle === 'italic' ? 'normal' : 'italic';
        customText.set({ fontStyle: italicStyle });
        canvas.renderAll();
        }
        // Function for changing the font style 

        function changeFontFamily(fontFam) {
          customText.set({
            fontFamily: fontFam
          });
          canvas.renderAll();
        }
      
        // --------------The function for Add Text tools Ends Here--------------------
        

        // -------------Function for the redo and undo tools----------------

        // Push the current state in undo stack and capture the current state
        function save(){
            redo = [];
            $('#redo').prop('disabled', true);

            if(state) {
                undo.push(state);
                $('#undo').prop('disabled', false);
            }
            state = JSON.stringify(canvas);
        }
        
       
        // Function for the buttons 
        function replay(playStack, saveStack, buttonsOn, buttonsOff) {
          saveStack.push(state);
          state = playStack.pop();
          var on = $(buttonsOn);
          var off = $(buttonsOff);
          // turn both buttons off for the moment to prevent rapid clicking
          on.prop('disabled', true);
          off.prop('disabled', true);
          canvas.clear();
          canvas.loadFromJSON(state, function() {
            canvas.renderAll();
            // now turn the buttons back on if applicable
            on.prop('disabled', false);
            if (playStack.length) {
              off.prop('disabled', false);
            }
          });
        }

        // Function for canvas 
        $(function(){
          // save initial state
          save();
          // register event listener for user's actions
          canvas.on('object:modified', function() {
            save();
          });
          
          // undo and redo buttons
          $('#undo').click(function() {
            replay(undo, redo, '#redo', this);
          });
          $('#redo').click(function() {
            replay(redo, undo, '#undo', this);
          })
        });
        
        // --------------The function for Redo and Undo Tools Ends Here------------

        // Function to handle image upload
        function uploadImage() {
            var input = document.getElementById('imageUpload');
            var file = input.files[0];
            if (file) {
                // Load the uploaded image onto the canvas
                fabric.Image.fromURL(URL.createObjectURL(file), function (img) {
                    img.set({
                        left: 10,
                        top: 10,
                        scaleX: canvas.width / img.width,
                        scaleY: canvas.height / img.height
                    });
                                 
                    canvas.add(img);     
                    currentDesign.push(img);    
                });
            }
        }

        // Function that handles the color of the shirts 
        function colorTshirt(imagePath) {
          fabric.Image.fromURL(imagePath, function(img){
            img.set({
                left: 0,
                top:0,
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height,
                selectable: false
            });
                canvas.clear(); 
                canvas.add(img);

                for(var i = 0; i<currentDesign.length; i++) {
                    canvas.add(currentDesign[i]);
                }
          });
        }

        $('.colorButton').click(function(){
          var imagePath = $(this).data('image');
          colorTshirt(imagePath);
        });

         
        // Function for downloading the canvas 

        function downloadCustomDesign() {
         var confirmDownload = confirm("Are you sure you want to download your custom design?");
         if(confirmDownload) {
            var dataURL = canvas.toDataURL('image/png');
            var a = document.createElement('a');
            a.href = dataURL;
            a.download = 'custom_design.png';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
         }
        }

        $('#downloadCanvas').click(function(){
          downloadCustomDesign();
        })

        // remove object 
        $(document).on('keyup', function(event){
          if(event.key === 'Delete' ||  event.key === 'Backspace') {
            var selectedObject = canvas.getActiveObject(); 
            if (selectedObject) {
              canvas.remove(selectedObject);
              canvas2.remove(selectedObject);
            }
          }
        })