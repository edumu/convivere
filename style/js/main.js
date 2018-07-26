/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */

(function() {

	var bodyEl   = document.body,
            content  = document.querySelector( '.content-wrap' ),
            openbtn  = document.getElementById( 'open-button' ),
            closebtn = document.getElementById( 'close-button' ),
            isOpen   = false;

	function init() { initEvents(); }

	function initEvents() {
		openbtn.addEventListener( 'click', toggleMenu );
		if( closebtn ) { closebtn.addEventListener( 'click', toggleMenu ); }
	}

	function toggleMenu() {
		if( isOpen ) { classie.remove( bodyEl, 'show-menu' );
                               $("#confirmlogin").removeClass("msjErrCentro").removeClass("msjOk2").removeClass("msjOk").removeClass("msjErr").addClass("msjconfirm").html(""); 
                               $("#usuario").val('');
                               $("#pwd"    ).val('');
                            }
		else         { classie.add( bodyEl, 'show-menu' ); }
		isOpen = !isOpen;
	}

	init();

})();
