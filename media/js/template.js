$(document).ready(function() {
    function start_session(time) {
       var time_start = time;
       var interval = setInterval(function() {
           var green_bar = time/time_start;
           var red_bar = (time_start-time)/time_start;
           $('#session_bar_green').css('width',green_bar*19.9+'em');
           $('#session_bar_red').css('width',red_bar*19.9+'em');
           if(time==0) {
               $('#session_text').html("זמן פעולה תם");
               clearInterval(interval);
               window.location.href = "/login?se=1&page="+window.location.href;
               return;
           }

           var minutes = Math.floor( time/60 );
          
           var seconds = time % 60;
           
           var hours = Math.floor(minutes/60);
           if(hours===0) hours = '';
           else {
               minutes = minutes - hours*60;
           }
           if (minutes < 10) minutes = "0" + minutes;
           if (seconds < 10) seconds = "0" + seconds; 
           if(hours!==0) hours = hours + ':';
           var text = hours + minutes + ':' + seconds; 
          
           $('#session_clock').html(text);
           time--;
       }, 1000);
    }
   
    $.post('/ajax/get_session_lifetime',{'ajax_security':'b9HDrQCQqVyApRKob2IVRraGrWqOGyaA'} ).done(function(data) {start_session(data)} );
    $('.required').attr('title','שדה זה נדרש');
    
    $('.notice').click(function() {
        $(this).hide('slow');
    });
    $('.numeric').keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
    $('.dropdown').hover(function() {
       $(this).css('background','green');
    });
    $('#add_contact').click(function() {
        $(this).hide();
        $('#add_contact_form').css('display','inline-block'); 
    });
    $('#addcontact').click(function() {
        
    });
});
