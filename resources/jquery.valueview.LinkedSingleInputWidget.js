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
	 * @see jQuery.Widget._create
	 */
	_create: function() {
		this.element.addClass( 'linkedsingleinputvalueview' );
		PARENT.prototype._create.call( this );
	},

	/**
	 * @see jQuery.Widget.destroy
	 */
	destroy: function() {
		this.element.removeClass( 'linkedsingleinputvalueview' );
		return PARENT.prototype.destroy.call( this );
	},

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
	},

	/**
	 * @see jQuery.valueview.PersistentDomWidget._formatAsEditableValue
	 */
	_formatAsEditableValue: function() {
		var value = this.value();

		this.$anchor.removeAttr( 'href' ); // can't use removeProp, behaves buggy
		this.$input = this._buildInputDom();
		this.$anchor.empty().append( this.$input );
	},

	/**
	 * @see jQuery.valueview.Widget._displayValue
	 */
	_displayValue: function( value ) {
		var textValue = value === null ? '' : value.getValue();

		if( this.$input ) {
			// in edit mode:
			this.$input.val( textValue );
		} else {
			// in static mode:
			var linkContent = this._getLinkContentFromValue( value );

			this.$anchor.prop( {
				href: this._getLinkHrefFromValue( value )
			} );

			if( typeof linkContent === 'string' ) {
				this.$anchor.text( linkContent );
			} else {
				this.$anchor.append( linkContent );
			}
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
	 * Returns what should be inserted as the link's inner DOM. Can also return a plain string,
	 * which will then be escaped and inserted as simple text.
	 * @since 0.1
	 *
	 * @param {dv.DataValue|null} value
	 * @return String|jQuery
	 */
	_getLinkContentFromValue: function( value ) {
		return value === null ? '' : value.getValue();
	},

	/**
	 * @see jQuery.valueview.Widget._getRawValue
	 */
	_getRawValue: function() {
		return this.$input
			? this.$input.val()
			: this.$anchor.text();
	}
} );

}( dataValues, dataTypes, jQuery ) );
