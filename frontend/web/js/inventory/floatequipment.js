
	window.onscroll = function() {myFunction2();};

	//for the searchbox to float
	var y = document.getElementById("srcbox");
	var sticky = y.offsetTop;
	var swtc =0;
	 if (window.pageYOffset > sticky) {
	 	swtc =1;
	 	$(btnx).click();
	 }
	function myFunction2() {
	  if (window.pageYOffset > sticky) {
	    y.classList.add("stickysrchbox");
	    if(swtc==0){
	    	$(btnx).click();
	    }
	    swtc++;
	  } else {
	  	swtc=0;
	  	$(btnx).click();
	    y.classList.remove("stickysrchbox");
	  }
	}