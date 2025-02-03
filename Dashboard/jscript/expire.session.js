let inactivityTimer = setTimeout(function() {
    // User has been inactive for 29 minutes, display message
    if($('#jsLg').val() == 'FR'){
      alert('Votre session a expiré pour cause d\'inactivité.\n\rActualisez la page et/ou reconnectez-vous');
    }else{
      alert('Your session has expired due to inactivity.\n\rRefresh the page and/or log in again');
    }
    
    AppStocks.stopInterval();

  }, 29 * 60 * 1000); // 30 minutes in milliseconds
  // }, 7000); // 30 minutes in milliseconds

  
  // Reset the timer when the user performs an action
function resetTimer() {
   
    clearTimeout(inactivityTimer);
    
    // AppStocks.stopInterval();
    
    inactivityTimer = setTimeout(function() {
      if($('#jsLg').val() == 'FR'){
        alert('Votre session a expiré pour cause d\'inactivité !!.\n\rActualisez la page et/ou reconnectez-vous');
      }else{
        alert('Your session has expired due to inactivity.\n\rRefresh the page and/or log in again');
      }

      AppStocks.stopInterval();
      
    }, 29 * 60 * 1000);
    // }, 7000); // 30 minutes in milliseconds
  }
  
  // Bind resetTimer to various events that indicate user activity
  document.addEventListener('mousemove', resetTimer);
  document.addEventListener('keydown', resetTimer);
  document.addEventListener('keyup', resetTimer);
  document.addEventListener('scroll', resetTimer);
  document.addEventListener('click', resetTimer);
  document.addEventListener('click', resetTimer);


/*    
also u can clear timer if you want when user logout

// Clear the timer when the user logs out
function logout() {
  clearTimeout(inactivityTimer);
  // Do any other logout logic
}

Note : this has nothing to do with ur php this is all done by javascript

Just in addition this might help someone :

Another thing if you dont want session to expire whole day or till browser is closed then you can just make a simple jquery call via ajax to server every 5-10 minutes (accordingly) and it will never expires. You can also update values if needed in client end with this ajax request.

Here is example :

function keepSessionAlive() {
    $.ajax({
        url: "keepSessionAlive.php",
        success: function() {
            // Session is still alive
        },
        error: function() {
            // Session has expired or there was an error
        }
    });
}

setInterval(keepSessionAlive, 5 * 60 * 1000); // 5 minutes in milliseco

*/