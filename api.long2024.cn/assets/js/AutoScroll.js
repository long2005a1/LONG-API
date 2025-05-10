function AutoScroll(a) {
    	//console.log(new Date());
    	$(a).find("ul:first").animate({
    		marginTop: "-10px"
    	}, 300, function() {
    		$(this).css({
    			marginTop: "0px"
    		}).find("li:first").appendTo(this)
    	})
    }
    text = setInterval('AutoScroll(".txt")', 3000);