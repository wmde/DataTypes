/**
 * @licence GNU GPL v2+
 * @author Daniel Werner
 */
( function( dv, dt, $, undefined ) {
	'use strict';

	var PARENT = $.valueview.SingleInputWidget;

/**
 * Can be used as a base for all 'valueview' widgets which use just one input box for value
 * manipulation in edit mode and a link when not in edit mode.
 *
 * @option {String} inputPlaceholder Can be used to display a hint for the user if the input is empty.
 *
 * @constructor
 * @abstract
 * @extends jQuery.valueview.SingleInputWidget
 * @since 0.1
 */
$.valueview.LinkedSingleInputWidget = dv.util.inherit( PARENT, {
	/**
	 * The anchor for displaying the link in non-edit mode. This node will also be there, holding
	 * the input element, when in edit mode. So, this is the 'persistent' DOM element in this view.
	 * @type jQuery
	 */
	$anchor: null,

	/**
	 * The input element within $anchor or null if the view is not in edit mode.
	 */
	$input: null,

	/**
	 * @see jQuery.Widget.options
	 */
	options:  $.extend( true, {}, PARENT.prototype.options, {
		// FURTHER OPTIONS
	} ),

	/**
	 * Creates an 'a' tag with the value input element inside.
	 * The input element will be created in _buildInputDom() which can be overwritten to change the
	 * type of input element.
	 *
	 * @final
	 * @see jQuery.valueview.PersistentDomWidget._buildValueDom
	 */
	_buildValueDom: function() {
		return $( '<a/>' ).append(
			this._buildInputDom()
		);
	},

	/**
	 * Builds the input element for editing, ready to be inserted into the DOM.
	 *
	 * @return {jQuery}
	 * @private
	 */
	_buildInputDom: function() {
		var $input = PARENT.prototype._buildValueDom.call( this )
			.prop( 'placeholder', this.option( 'inputPlaceholder' ) );
		return $input;
	},

	/**
	 * @see jQuery.valueview.PersistentDomWidget._createValueDomShortCuts
	 */
	_createValueDomShortCuts: function( valueDom ) {
		this.$anchor = valueDom.first();
		this.$input = this.$anchor.children().first();
	},

	/**
	 * @see jQuery.valueview.PersistentDomWidget._formatAsStaticValue
	 */
	_formatAsStaticValue: function() {
		var value = this.value();

		this.$input.empty().remove();
		this.$input = null;

		this._displayValue( value );
	},

	/**
	 * @see jQuery.valueview.PersistentDomWidget._formatAsEditableValue
	 */
	_formatAsEditableValue: function() {
		var value = this.value();

		this.$anchor.removeAttr( 'href' ); // can't use removeProp, behaves buggy
		this.$input = this._buildInputDom();
		this.$anchor.empty().append( this.$input );

		this._displayValue( value );
	},

	/**
	 * @see jQuery.valueview.Widget._displayValue
	 */
	_displayValue: function( value ) {
		var textValue = value === null ? '' : value.getValue();

		if( this.$input ) {
			this.$input.val( textValue );
		} else {
			this.$anchor.prop( {
				href: this._getLinkHrefFromValue( value )
			} ).text( this._getLinkTextFromValue( value ) );
		}
	},

	/**
	 * Returns the href for the link based on a given value
	 * @since 0.1
	 *
	 * @param {dv.DataValue|null} value
	 * @return String
	 */
	_getLinkHrefFromValue: function( value ) {
		return '';
	},

	/**
	 * Returns the href for the link based on a given value
	 * @since 0.1
	 *
	 * @param {dv.DataValue|null} value
	 * @return String
	 */
	_getLinkTextFromValue: function( value ) {
		return value === null ? '' : value.getValue();
	},

	/**
	 * @see jQuery.valueview.Widget._getRawValue
	 */
	_getRawValue: function() {
		if( this.$input ) {
			return this.$input.val();
		} else {
			return this.$anchor.text();
		}
	}
} );

}( dataValues, dataTypes, jQuery ) );
