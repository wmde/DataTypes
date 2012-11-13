/**
 * Abstract base widget for editing and representing data values.
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner
 */
( function( dv, dt, $, undefined ) {
	'use strict';

/**
 * Base for all 'valueview' widgets. Default base widget of the jquery.valueview.widget widget
 * factory function.
 *
 * @constructor
 * @extends jQuery.Widget
 * @since 0.1
 */
$.valueview.Widget = dv.util.inherit( $.Widget, {
	/**
	 * Defines which type of DataValue can be handled by this 'valueview' widget.
	 * @type String
	 */
	dataValueType: null,

	/**
	 * Default options
	 * @see jQuery.Widget.options
	 */
	options: $.extend( true, {}, $.Widget.prototype.options, {
		// some other options
	} ),

	/**
	 * @see jQuery.Widget._createWidget
	 */
	_createWidget: function( options, element ) {
		// add 'valueview' data for all kinds of valueview views. This has be done here (in addition
		// to inside the bridge) for directly initializing some specific view.
		$.data( element, 'valueview', this );

		// add classes. widgetBaseClass should be 'valueview', same for all valueview views
		$( element ).addClass( this.widgetBaseClass + ' ' + this.widgetName );

		return $.Widget.prototype._createWidget.apply( this, arguments );
	},

	/**
	 * @see jQuery.Widget.destroy
	 */
	destroy: function() {
		// remove classes we added in this._createWidget()
		this.element.removeClass( this.widgetBaseClass + ' ' + this.widgetName );

		return $.Widget.prototype.destroy.call( this );
	}

} );

}( dataValues, dataTypes, jQuery ) );
