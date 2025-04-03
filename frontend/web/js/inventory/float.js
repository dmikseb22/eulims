
	window.onscroll = function() {myFunction(); myFunction2();};
	//for the cart to float
	var x = document.getElementById("cart");
	var sticky = x.offsetTop;

	function myFunction() {
	  if (window.pageYOffset > sticky) {
	    x.classList.add("sticky");
	  } else {
	    x.classList.remove("sticky");
	  }
	}

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