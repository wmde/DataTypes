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
			// provide parser for strings
			this.valueParser = new vp.StringParser();

			PARENT.prototype._create.call( this );
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
		}
	} );

}( mediaWiki, dataValues, valueParsers, dataTypes, jQuery ) );
