/**
 * Abstract base widget for editing and representing data values.
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner
 */
( function( dv, dt, $ ) {
	'use strict';

/**
 * Base for all 'valueview' widgets. Default base widget of the jquery.valueview.widget widget
 * factory function.
 *
 * @constructor
 * @abstract
 * @extends jQuery.Widget
 * @since 0.1
 */
$.valueview.Widget = dv.util.inherit( $.Widget, {
	// TODO/FIXME: rename dataValueType and dataTypeId since their naming is rather confusing.
	/**
	 * Defines which type of DataValue can be handled by this 'valueview' widget. Should only be
	 * set if the Widget is not just designed for values suitable for a certain data type.
	 * @type String|null
	 */
	dataValueType: null,

	/**
	 * One DataType ID of a DataType for which instances of this widget can serve DataValue objects.
	 * @type String|null
	 */
	dataTypeId: null,

	/**
	 * @type valueParsers.ValueParser
	 */
	valueParser: null,

	/**
	 * The DOM node, child of widget subject node, which holds all DOM nodes representing the value.
	 * The child nodes of this node can change when switching between edit- and non-edit mode.
	 * @type jQuery
	 */
	$valueDomParent: null,

	/**
	 * This is not to be overwritten by any widget implementations. This will hold the name of the
	 * 'valueview' widget instance. This is basically the name of the property in which the view's
	 * prototype is stored in, in jQuery.valueview
	 * This will be set by
	 * @final
	 * @type String
	 */
	instanceViewName: null,

	/**
	 * Current value
	 * @type dv.DataValue|null
	 */
	_value: null,

	/**
	 * Value from before edit mode.
	 * @type dv.DataValue|null
	 */
	_initialValue: null,

	/**
	 * @type Boolean
	 */
	_isInEditMode: false,

	/**
	 * Default options
	 * @see jQuery.Widget.options
	 */
	options: $.extend( true, {}, $.Widget.prototype.options, {
		// TODO: 'value' option for initial value
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

		$.Widget.prototype._createWidget.apply( this, arguments );
	},

	/**
	 * @see jQuery.Widget._create
	 */
	_create: function() {
		// start widget in static mode
		this.element.addClass( this.widgetBaseClass + '-instaticmode' );

		// add node which will hold the nodes representing the value and display static value:
		this.$valueDomParent = $( '<div/>', {
			'class': this.widgetBaseClass + '-value'
		} ).appendTo( this.element );

		this._replaceValueDom( this._serveStaticValueDom() );
		this._displayValue( this._value );

		// TODO(1/2): could try to extract some initial value from element...
		// TODO(2/2): ...and set it as raw value which will trigger parser to get a proper DataValue
		//this.rawValue( ... );

		var self = this;
		// on each change by the user we have to create a DataValue Object from that
		// TODO: decide if we really want to use 'eachchange' here and if so, move it from Wikibase
		this.element.on( 'eachchange', function( event ) {
			self._updateValue();
			// TODO: should we stop event propagation and trigger an 'eachchange' event after update?
		} );
	},

	/**
	 * @see jQuery.Widget.destroy
	 */
	destroy: function() {
		// remove classes we added in this._createWidget() as well as others
		this.element.removeClass(
			this.widgetBaseClass + ' '
			+ this.widgetName + ' '
			+ this.widgetBaseClass + '-instaticmode '
			+ this.widgetBaseClass + '-ineditmode '
		);

		this.element.removeData( 'valueview' );

		return $.Widget.prototype.destroy.call( this );
	},

	/**
	 * Returns whether the valueview can display the given data value object at all.
	 * @since 0.1
	 * @final
	 *
	 * @param {dv.DataValue|dt.DataType} indicator
	 * @return boolean
	 */
	isSuitableFor: function( indicator ) {
		var valueType;

		if( indicator instanceof dv.DataValue ) {
			valueType = indicator.getType();
		}
		else if( indicator instanceof dt.DataType ) {
			valueType = indicator.getDataValueType();
		}
		else {
			throw new Error( 'No sufficient indicator provided' );
		}

		// suitable if this widget can handle the right kind of data value or if it is designed to
		// handle certain data types who also use the data value type of a given indicator.
		return ( this.dataValueType && valueType === this.dataValueType )
			|| ( this.dataTypeId && valueType === dt.getDataType( this.dataTypeId ).getDataValueType() );
	},

	/**
	 * Returns whether the valueview Widget is considered the best choice for displaying the given
	 * data value object or more specifically, a data value object valid against a given data type
	 * object.
	 * @since 0.1
	 * @final
	 *
	 * @param {dv.DataValue|dt.DataType} indicator
	 * @return boolean
	 */
	isMostSuitableFor: function( indicator ) {
		var bestView = $.valueview.chooseView( indicator );
		return bestView !== null && ( this instanceof $.valueview[ bestView ] );
	},

	/**
	 * When calling this, the view will transform into a form with input fields or advanced widgets
	 * for editing the related data value.
	 *
	 * @since 0.1
	 */
	startEditing: function() {
		if( this.isInEditMode() ) {
			return; // return nothing to allow chaining
		}
		this._initialValue = this._value;
		this._isInEditMode = true;

		this.element
		.addClass( this.widgetBaseClass + '-ineditmode' )
		.removeClass( this.widgetBaseClass + '-instaticmode' );

		// update the view:
		this._replaceValueDom( this._serveEditableValueDom() );
		this._displayValue( this._value );
	},

	/**
	 * Will close the view where editing of the related data value is possible and display a static
	 * version of the value instead. This is similar to the disabled state but will be visually
	 * different since the input interface will not be visible anymore.
	 * By default the current value will be adopted if it is valid. If not valid or if the first
	 * parameter is false, the value from before the edit mode will be restored.
	 *
	 * @since 0.1
	 *
	 * @param {Boolean} [dropValue] If true, the value from before edit mode has been started will
	 *        be reinstated. false by default. Consider using cancelEditing() instead.
	 */
	stopEditing: function( dropValue ) {
		if( !this.isInEditMode() ) {
			return;
		}
		if( dropValue ) {
			// reinstate initial value from before edit mode
			this._value = this._initialValue;
		}
		this._initialValue = null;
		this._isInEditMode = false;

		this.element
		.removeClass( this.widgetBaseClass + '-ineditmode' )
		.addClass( this.widgetBaseClass + '-instaticmode' );

		// update the view:
		this._replaceValueDom( this._serveStaticValueDom() );
		this._displayValue( this._value );
	},

	/**
	 * short-cut for stopEditing( false ). Closes the edit view and restores the value from before
	 * the edit mode has been started.
	 * @since 0.1
	 */
	cancelEditing: function () {
		return this.stopEditing( true );
	},

	/**
	 * Returns whether the edit view is active at the moment.
	 * @since 0.1
	 *
	 * @return Boolean
	 */
	isInEditMode: function() {
		return this._isInEditMode;
	},

	/**
	 * Returns the value from before the edit mode has been started.
	 * If its not in edit mode, the current value will be returned.
	 * @since 0.1
	 */
	initialValue: function() {
		if( !this.isInEditMode() ) {
			return this.value();
		}
		return this._initialValue;
	},

	/**
	 * Returns the value of the view. If the view is in edit mode, this will return the current
	 * value the user is typing. There is no guarantee that the returned value is valid.
	 *
	 * If the first parameter is given, this will change the value represented to that value. This
	 * will trigger validation of the value.
	 *
	 * If null is given or returned, this means that the view is or should be empty.
	 *
	 * @since 0.1
	 *
	 * @param {dv.DataValue|null} value
	 * @return {dv.DataValue|null|undefined} null if no value is set currently
	 *
	 * TODO: Handling of null as value.
	 *
	 * TODO: think about another function which should rather use some kind of "ValidatedDataValue",
	 *       holding a reference to the used data type and the info that it is valid against it.
	 *       As soon as we have validations we have to consider that the given value is invalid,
	 *       this would require the following considerations:
	 *       1) allow setting invalid values (wouldn't be that bad, invalid values should probably
	 *          be displayed anyhow in some cases where we have old values for a property but the
	 *          property definition has changed (e.g. allowed range from 0-1,000 changed to 0-100).
	 *       2) Trigger a validation after the value is set. If invalid, warning in UI
	 *       Probably we want both, a ValidatedDataValue AND the ability to set an invalid value as
	 *       described.
	 *       A ValidatedDataValue could always be returned by another function and be an indicator
	 *       for whether the value is valid or not.
	 */
	value: function( value ) {
		if( value === undefined ) {
			return this._value;
		}
		if( value !== null && !( value instanceof dv.DataValue ) ) {
			throw new Error( 'The given value has to be an instance of dataValue.DataValue or null' );
		}
		return this._setValue( value );
	},

	/**
	 * Sets the value internally and triggers the validation process on the new value, will also
	 * make sure that the new value will be displayed.
	 * @since 0.1
	 *
	 * @param {dv.DataValue|null} value
	 */
	_setValue: function( value ) {
		// check whether given value is actually suitable for the widget:
		if( value !== null // null represents empty value
			&& ( !( value instanceof dv.DataValue )	|| !this.isSuitableFor( value ) )
		) {
			throw new Error( 'Given value type is not compatible with what the view can handle' );
		}
		this._value = value;

		// TODO: trigger validation. Value will still be set independent from whether value is valid

		this._displayValue( value );
	},

	/**
	 * Focuses the widget.
	 * @since 0.1
	 * @abstract
	 */
	focus: dv.util.abstractMember,

	/**
	 * Removes focus from the widget.
	 * @since 0.1
	 * @abstract
	 */
	blur: dv.util.abstractMember,

//	/**
//	 * Returns a $.Deferred resolving as soon as the validation for the current value is done.
//	 * This is necessary since validation might need API request and is happening whenever the
//	 * user types something in edit mode. By the point this function is called, the validation
//	 * might not be done.
//	 *
//	 * @return $.Deferred
//	 */
//	validatedValue: function() {},

	/**
	 * Will return a value which can then be fed to the value parser to create a DataValue. This
	 * function will basically access the input elements (widgets) currently representing the value
	 * and return their current values as something the parser will understand.
	 *
	 * @return {*}
	 */
	rawValue: function() {
		// TODO: would it make sense to overload this function and provide a setter as well?
		return this._getRawValue();
	},

	/**
	 * Will return the value in a way the parser will understand.
	 * @see this.rawValue
	 * @since 0.1
	 * @abstract
	 *
	 * @return {*}
	 */
	_getRawValue: dv.util.abstractMember,

	/**
	 * Responsible for displaying a certain value. This means that the DOM nodes or widgets
	 * currently representing the value have to be updated.
	 * @since 0.1
	 * @abstract
	 *
	 * @param {dv.DataValue|null} value
	 */
	_displayValue: dv.util.abstractMember,

	/**
	 * Returns the DOM node(s) representing the value in its editable state.
	 * @since 0.1
	 * @abstract
	 */
	_serveEditableValueDom: dv.util.abstractMember,

	/**
	 * Returns the DOM node(s) representing the value in its static state (not editable).
	 * @since 0.1
	 * @abstract
	 */
	_serveStaticValueDom: dv.util.abstractMember,

	/**
	 * Updates the inner 'value DOM', representing the value, with a given set of DOM nodes.
	 * No DOM manipulation will be triggered if the given nodes are the same as the current nodes.
	 * @since 0.1
	 *
	 * @param $newValueNodes
	 */
	_replaceValueDom: function( $newValueNodes ) {
		var $oldValueNodes = this.$valueDomParent.children();

		// no need to replace nodes, if they are the same!
		if( $oldValueNodes.length !== $newValueNodes.length
			|| $oldValueNodes.not( $newValueNodes ).length > 0
			|| $newValueNodes.not( $oldValueNodes ).length > 0
		) {
			// replace nodes, representing the value
			$newValueNodes.appendTo( this.$valueDomParent );
		}
	},

	/**
	 * Will take the current raw value of the widget and parse it by taking the value parser
	 * provided in this.valueParser.
	 * Can be overwritten to implement ways of updating the value without a value parser.
	 */
	_updateValue: function() {
		var self = this,
			rawValue = this.rawValue();

		this.__lastUpdateValue = rawValue;

		this.valueParser.parse(
			rawValue
		).done( function( parsedValue ) {
			if( self.__lastUpdateValue === undefined ) {
				// latest update job is done, this one must be a late response for some weird reason
				return;
			}

			self._value = parsedValue;

			if( self.__lastUpdateValue === rawValue ) {
				// this is the response for the latest update! by setting this to undefined, we will
				// ignore all responses which might come back late.
				// Another reason for this could be something like "a", "ab", "a", where the first
				// response comes back and the following two can be ignored.
				// TODO: this will only work if the raw value is a string or other basic type,
				//       if otherwise, we had to implement some equal function for the raw values
				self.__lastUpdateValue = undefined;
			}
		} );
		// TODO: display some message if parsing failed due to bad API connection
	}
} );

}( dataValues, dataTypes, jQuery ) );
