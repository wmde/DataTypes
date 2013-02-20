/**
 * @licence GNU GPL v2+
 * @author Daniel Werner
 */
( function( dv, dt, $, undefined ) {
	'use strict';

	var PARENT = $.valueview.PersistentDomWidget;

/**
 * Can be used as a base for all 'valueview' widgets which use just one input box for value
 * manipulation and stick with that DOM rather than replacing it when switching between edit modes.
 *
 * @option {String} inputPlaceholder Can be used to display a hint for the user if the input is empty.
 *
 * @constructor
 * @abstract
 * @extends jQuery.valueview.PersistentDomWidget
 * @since 0.1
 */
$.valueview.SingleInputWidget = dv.util.inherit( PARENT, {
	/**
	 * The nodes of the input elements. Basically $valueDomParent.children() but with the guarantee
	 * that they won't change since this is a valueview widget keeping the editable DOM even in
	 * static DOM mode. This is achieved by simply styling the input differently in static mode.
	 * @type jQuery
	 */
	$input: null,

	/**
	 * @see jQuery.Widget.options
	 */
	options:  $.extend( true, {}, PARENT.prototype.options, {
		'inputPlaceholder': 'insert value'
	} ),

	/**
	 * @see jQuery.valueview.PersistentDomWidget.destroy
	 */
	destroy: function() {
		if ( this.$input ) {
			this.$input.removeClass( 'valueview-disabled' );
		}
		PARENT.prototype.destroy.call( this );
	},

	/**
	 * @see jQuery.valueview.PersistentDomWidget._buildValueDom
	 */
	_buildValueDom: function() {
		// use a textarea rather than input field to display line breaks nicely.
		return $( '<textarea/>', {
			'class': this.widgetBaseClass + '-input',
			'type': 'text'
		} )
		.inputAutoExpand( { expandWidth: false, expandHeight:true, suppressNewLine: true } )
		.eachchange(); // TODO: see TODO in jquery.valueview.Widget about 'eachchange'
	},

	/**
	 * @see jQuery.valueview.PersistentDomWidget._createValueDomShortCuts
	 */
	_createValueDomShortCuts: function( valueDom ) {
		// add reference to our only input element so we can use it in the _formatAs...() functions
		this.$input = valueDom.first();
	},

	/**
	 * @see jQuery.valueview.PersistentDomWidget._formatAsStaticValue
	 */
	_formatAsStaticValue: function() {
		this.$input.prop( {
			// using readOnly instead of disabled since IE would overwrite font color with default
			// system style regardless of any own definition
			readOnly: true,
			tabIndex: -1,
			spellcheck: false,
			placeholder: '' // don't want to see any placeholder text in static mode
		} );
	},

	/**
	 * @see jQuery.valueview.PersistentDomWidget._formatAsEditableValue
	 */
	_formatAsEditableValue: function() {
		this.$input.prop( {
			readOnly: false,
			spellcheck: true, // TODO: doesn't really work, seems fully disabled in Chrome now
			placeholder: this.option( 'inputPlaceholder' )
		} ).removeProp( 'tabIndex' );

		// TODO: placeholder option should change placeholder at a later point as well
	},

	/**
	 * @see jQuery.valueview.Widget._displayValue
	 */
	_displayValue: function( value ) {
		var textValue = value === null ? '' : value.getValue();
		this.$input.val( textValue ).inputAutoExpand();
	},

	/**
	 * @see jQuery.valueview.Widget.disable
	 */
	disable: function() {
		if ( !this.$input ) {
			return; // no point in disabling when there is nothing to disable
		}
		PARENT.prototype.disable.call( this );
		this.$input.prop( 'disabled', true );
	},

	/**
	 * @see jQuery.valueview.Widget.enable
	 */
	enable: function() {
		if ( !this.$input ) {
			return; // no point in enabling when there is nothing to enable
		}
		PARENT.prototype.enable.call( this );
		this.$input.prop( 'disabled', false );
	},

	/**
	 * @see jQuery.valueview.Widget.focus
	 */
	focus: function() {
		if( !this.$input ) {
			return; // can't focus in non-edit mode
		}
		// move text cursor to the end of the textarea
		var value = this.$input.val();
		this.$input.val( '' );
		this.$input.focus();
		this.$input.val( value );
	},

	/**
	 * @see jQuery.valueview.Widget.blur
	 */
	blur: function() {
		if( !this.$input ) {
			return; // can't blur in non-edit mode
		}
		this.$input.blur();
	},

	/**
	 * @see jQuery.valueview.Widget._getRawValue
	 */
	_getRawValue: function() {
		return this.$input.val();
	}
} );

}( dataValues, dataTypes, jQuery ) );
