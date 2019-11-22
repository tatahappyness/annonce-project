
//page loading before
 window.onload = function () {
	
   
  };
  
// When the user scrolls the page, execute myFunction 
//window.onscroll = function() {myFunction()};

/*
function myFunction() {
  var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrolled = (winScroll / height) * 100;
  document.getElementById("myBar").style.width = scrolled + "%";
  
}
*/

//ZOOM Image Gallery Pro
function zoom(e){
  var zoomer = e.currentTarget;
  e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
  e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
  x = offsetX/zoomer.offsetWidth*100
  y = offsetY/zoomer.offsetHeight*100
  zoomer.style.backgroundPosition = x + '% ' + y + '%';
}

//reCapchat
	// grecaptcha.ready(function() {
    //   grecaptcha.execute('6Lcr-qsUAAAAAPrCqD5Yk1iDIw9xBtzP6KSackqm', {action: 'homepage'}).then(function(token) {
    //       console.log(token);
    //   });
  // });
  

  

