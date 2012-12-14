/**
 * Widget for editing values of the commonsMedia DataType.
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner < daniel.werner@wikimedia.de >
 */
( function( mw, dv, vp, dt, $ ) {
	'use strict';

	var PARENT = $.valueview.LinkedSingleInputWidget;

	$.valueview.widget( 'commonsmedia', PARENT, {
		/**
		 * @see jQuery.valueview.Widget.dataTypeId
		 */
		dataTypeId: 'commonsMedia',

		/**
		 * @see jQuery.Widget._create
		 */
		_create: function() {
			var self = this;

			// provide parser for strings
			this.valueParser = new vp.StringParser();

			PARENT.prototype._create.call( this );

			this.element.on( 'suggesterresponse', function( event, response ) {
				self._updateValue();
				self.$input.data( 'AutoExpandInput' ).expand();
				self.$input.data( 'suggester' ).repositionMenu();
			} );
		},

		/**
		 * @see $.valueview.LinkedSingleInputWidget._getLinkHrefFromValue
		 */
		_getLinkHrefFromValue: function( value ) {
			if( value === null ) {
				return null;
			}
			return 'http://commons.wikimedia.org/wiki/File:'
				+ mw.util.wikiUrlencode( value.getValue() );
		},

		/**
		 * @see $.valueview.LinkedSingleInputWidget._buildInputDom
		 */
		_buildInputDom: function() {
			var $input = PARENT.prototype._buildInputDom.call( this );
			$input.suggester( {
				ajax: {
					url: 'http://commons.wikimedia.org/w/api.php',
					params: {
						action: 'opensearch',
						namespace: 6
					}
				},
				replace: [/^File:/, '']
			} );

			$input.eachchange( function( event, oldValue ) {
				$input.data( 'suggester' ).repositionMenu();
			} );

			return $input;
		}
	} );

}( mediaWiki, dataValues, valueParsers, dataTypes, jQuery ) );
