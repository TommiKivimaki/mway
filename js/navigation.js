/* global mwayScreenReaderText */
/**
* Theme functions file.
*
* Contains handlers for navigation and widget area.
*/

(function( $ ) {
	var masthead, menuToggle, siteNavContain, siteNavigation;
  
	function initMainNavigation( container ) {
    
		// Add dropdown toggle that displays child menu items.
		var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false })
    .append( $( '<span />', { 'class': 'dropdown-symbol', text: '+' }) )
    .append( $( '<span />', { 'class': 'screen-reader-text', text: mwayScreenReaderText.expand }) );
    
    // Find menu and page items with children and which have a link inside of them. Then append dropdownToggle
		container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );
    
    // Expands the menu if we are on the page that has a submenu
		// Set the active submenu dropdown toggle button initial state.
		// container.find( '.current-menu-ancestor > button' )
    // .addClass( 'toggled-on' )
    // .attr( 'aria-expanded', 'true' )
    // .find( '.screen-reader-text' )
    // .text( mwayScreenReaderText.collapse );
		// Set the active submenu initial state.
		// container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );
    
    // Toggle functionality
		container.find( '.dropdown-toggle' ).click( function( e ) {
			var _this = $( this ),
      screenReaderSpan = _this.find( '.screen-reader-text' );
      dropdownSymbol = _this.find( '.dropdown-symbol');
      dropdownSymbol.text(dropdownSymbol.text() === '-' ? '+' : '-');

			e.preventDefault();
			_this.toggleClass( 'toggled-on' );
			_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
      
			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
      
			screenReaderSpan.text( screenReaderSpan.text() === mwayScreenReaderText.expand ? mwayScreenReaderText.collapse : mwayScreenReaderText.expand );
		});
	}
  
	initMainNavigation( $( '.main-navigation' ) );
  
	masthead       = $( '#masthead' );
	menuToggle     = masthead.find( '.menu-toggle' );
	siteNavContain = masthead.find( '.main-navigation' );
	siteNavigation = masthead.find( '.main-navigation > div > ul' );
  
	// Enable menuToggle, which is the button that toggles the menu on and off on a compact display
	(function() {
    
		// Return early if menuToggle is missing.
		if ( ! menuToggle.length ) {
			return;
		}
    
		// Add an initial value for the attribute.
		menuToggle.attr( 'aria-expanded', 'false' );
    
		menuToggle.on( 'click.mway', function() {
			siteNavContain.toggleClass( 'toggled-on' );
      
			$( this ).attr( 'aria-expanded', siteNavContain.hasClass( 'toggled-on' ) );
		});
	})();
  
	// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	(function() {
		if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
			return;
		}
    
		// Toggle `focus` class to allow submenu access on tablets.
		function toggleFocusClassTouchScreen() {
			if ( 'none' === $( '.menu-toggle' ).css( 'display' ) ) {
        
				$( document.body ).on( 'touchstart.mway', function( e ) {
					if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
						$( '.main-navigation li' ).removeClass( 'focus' );
					}
				});
        
				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' )
        .on( 'touchstart.mway', function( e ) {
          var el = $( this ).parent( 'li' );
          
          if ( ! el.hasClass( 'focus' ) ) {
            e.preventDefault();
            el.toggleClass( 'focus' );
            el.siblings( '.focus' ).removeClass( 'focus' );
          }
        });
        
			} else {
				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).unbind( 'touchstart.mway' );
			}
		}
    
		if ( 'ontouchstart' in window ) {
			$( window ).on( 'resize.mway', toggleFocusClassTouchScreen );
			toggleFocusClassTouchScreen();
		}
    
		siteNavigation.find( 'a' ).on( 'focus.mway blur.mway', function() {
			$( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
		});
	})();
})( jQuery );
