$(window).bind("resize", function () {
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

// Local Storage functions
// Set proper body class and plugins based on user configuration
$(document).ready(function () {
    if (localStorageSupport) {
        var collapse = localStorage.getItem("collapse_menu");
        var fixedsidebar = localStorage.getItem("fixedsidebar");
        var fixednavbar = localStorage.getItem("fixednavbar");
        var boxedlayout = localStorage.getItem("boxedlayout");
        var fixedfooter = localStorage.getItem("fixedfooter");

        var body = $('body');

        if (fixedsidebar == 'on') {
            body.addClass('fixed-sidebar');
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }

        if (collapse == 'on') {
            if (body.hasClass('fixed-sidebar')) {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            } else {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }

            }
        }

        if (fixednavbar == 'on') {
            $(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
            body.addClass('fixed-nav');
        }

        if (boxedlayout == 'on') {
            body.addClass('boxed-layout');
        }

        if (fixedfooter == 'on') {
            $(".footer").addClass('fixed');
        }
    }    
});

// check if browser support HTML5 local storage
function localStorageSupport() {
    return (('localStorage' in window) && window['localStorage'] !== null)
}

// For demo purpose - animation css script
function animationHover(element, animation) {
    element = $(element);
    element.hover(
        function () {
            element.addClass('animated ' + animation);
        },
        function () {
            //wait for animation to finish before removing classes
            window.setTimeout(function () {
                element.removeClass('animated ' + animation);
            }, 2000);
        });
}

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(500);
            }, 100);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(500);
            }, 300);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

// Dragable panels
function WinMove() {
    var element = "[class*=col]";
    var handle = ".ibox-title";
    var connect = "[class*=col]";
    $(element).sortable(
        {
            handle: handle,
            connectWith: connect,
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8
        })
        .disableSelection();
}

/*-----------------------*/
function ActiveMainMenu(id)
{
    var s = $('#'+id).attr('data-active');
}


function loadScripts( src, callback ) {
	var script = document.createElement("SCRIPT"),
		head = document.getElementsByTagName( "head" )[ 0 ],
		error = false;

	script.type = "text/javascript";

    script.onload = script.onreadystatechange = function( e ){

	    if ( ( !this.readyState || this.readyState == "loaded" || this.readyState == "complete" ) ) {
			if ( !error ) {
				removeListeners();
		        callback( true );
			} else {
		        callback( false );
			}
	    }
    };

	script.onerror = function() {
		error = true;
		removeListeners();
        callback( false );
	}

	function errorHandle( msg, url, line ) {

		if ( url == src ) {
			error = true;
			removeListeners();
	        callback( false );
		}
		return false;
	}

	function removeListeners() {
       	script.onreadystatechange = script.onload = script.onerror = null;

		if ( window.removeEventListener ) {
			window.removeEventListener('error', errorHandle, false );
		} else {
			window.detachEvent("onerror", errorHandle );
		}
	}

	if ( window.addEventListener ) {
		window.addEventListener('error', errorHandle, false );
	} else {
		window.attachEvent("onerror", errorHandle );
	}

	script.src = src;
    head.appendChild( script );
}
