var msgSent = false;
$('#adviceSubmittedConfirm').hide();
$('#sendingMsg').hide();

$('#submitFeedback').click( function(){
    var name = document.getElementById("adviceName").value;
    var email = document.getElementById("adviceEmail").value;
    var bugs = document.getElementById("adviceBugs").value;
    var add = document.getElementById("adviceAdd").value;
    var myEmail = "tararowland77@gmail.com";
    
    $('#sendingMsg').fadeIn(1000);

    if(!name){
        name = "No Name";
    }
    if(!email){
        email = "No Email";
    }
    if(!bugs){
        bugs = "No Bugs";
    }
    if(!add){
        add = "No Feedback";
    }

    msg = "Designs By RCS feedback report: \n\n" + 
    "Name: " + name + "\n" +
    "Email: " + email + "\n\n" +
    "Bugs: \n" +
    bugs + "\n\n" +
    "Feedback: \n" +
    add + "\n\n" +
    "Canvas: \n" +
    JSON.stringify(canvas);
    
    var data = {
        name: "Designs By RCS - Feedback",
        email: "jake@designsbyrcs.com",
        message: msg
    }
    
    $.ajax({
        type: "POST",
        url: "sendEmail.php",
        data: data,
        success: function(){
            if(msgSent === true){
                $('#adviceSubmittedConfirm').append('<br>');
            }  
            msgSent = true;
            
            $('#sendingMsg').hide();
            $('#adviceSubmittedConfirm').append("Message was sent. Thank you!").fadeIn(1000);
        }
    });
});

    function FeedbackSubmitted(){
        var msg = "Your";
        if(document.getElementById("adviceSubmitted").innerHTML !== ""){
            msg += " additional";
        }
        
        msg += " feedback has been submitted. Thank you";
        
        if(document.getElementById("adviceSubmitted").innerHTML !== ""){
            msg += " again";
        }
        
        msg += "!<br>";
        
        document.getElementById("adviceSubmitted").innerHTML += $msg;
        
        return false;
    }