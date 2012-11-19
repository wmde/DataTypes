/**
 * Widget for editing string DataValue type.
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner
 */
( function( dv, vp, dt, $, undefined ) {
	'use strict';

	var PARENT = $.valueview.SingleInputWidget;

	$.valueview.widget( 'string', PARENT, {
		/**
		 * @see jQuery.valueview.Widget.dataValueType
		 */
		dataValueType: 'string',

		/**
		 * @see jQuery.Widget._create
		 */
		_create: function() {
			// provide parser for strings
			this.valueParser = new vp.StringParser();

			PARENT.prototype._create.call( this );
		}
	} );

}( dataValues, valueParsers, dataTypes, jQuery ) );
