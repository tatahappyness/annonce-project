 
	$(document).ready(function() {
					
	});

	//MENU LARGE SCREEN
	/* Set the width of the sidebar to 250px (show it) */
	function openNav() {
		document.getElementById("mySidepanel").style.width = "100%";
		}
	
	/* Set the width of the sidebar to 0 (hide it) */
	function closeNav() {
	document.getElementById("mySidepanel").style.width = "0";
	}
		
	// MENU COLLAPSE FOR MOBILE
	var coll = document.getElementsByClassName("collapsible");
	var i;
	
	for (i = 0; i < coll.length; i++) {
		coll[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var content = this.nextElementSibling;
			if (content.style.maxHeight){
			content.style.maxHeight = null;
			} else {
			content.style.maxHeight = content.scrollHeight + "px";
			} 
		});
	}
	 