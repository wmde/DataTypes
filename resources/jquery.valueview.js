/**
 * Abstract base widget for editing and representing data values and a factory for defining
 * more concrete implementations of that widget, similar to jQuery.widget.
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner
 */
( function( dv, dt, $, undefined ) {
	'use strict';

	$.valueview = {};

	/**
	 * Registers a new sizzle selector for filtering widgets initialized on a DOM node.
	 * @param bridgeName Name of the bridge to the widget, e.g. 'foo' for jQuery.fn.foo()
	 */
	var registerWidgetSelector = function( bridgeName ) {
		$.expr[':'][ bridgeName ] = function( elem ) {
			return !!$.data( elem, bridgeName );
		};
	};

	// register jQuery selector $(':valueview') for selecting any valueview widget
	registerWidgetSelector( 'valueview' );

	/**
	 * Map from DataValue types to widgets responsible for the type.
	 * @type Object
	 */
	var valueViews = {};

	/**
	 * Helper function, will return a function as created by $.widget.bridge
	 *
	 * @param {String} widgetName The name of the widget within $.valueview
	 * @return Function
	 */
	var getBridgeToSubView = function( widgetName ) {
		var preBridge = $.fn.valueview;

		// temporarily bridge '$.valueview' to the specific widget...
		$.widget.bridge( 'valueview', $.valueview[ widgetName ] );

		// ... grab the newly created bridge function
		var bridge = $.fn.valueview;

		// undo this immediately and return bridge
		$.fn.valueview = preBridge;
		return bridge;
	};

	/**
	 * Serves a widget for editing and displaying a DataValue usable with a given DataType.
	 * @since 0.1
	 *
	 * @param {Object} options
	 * @return jQuery
	 *
	 * @throws {Error} if 'on' option is not set properly and no view can be chosen based on it.
	 */
	$.fn.valueview = function( options /**, ... more options */ ) {
		var args = Array.prototype.slice.call( arguments, 0 ),
			subArgs = [ this ].concat( args ),
			result = this;

		if( typeof options === 'string' ) {
			// widget method execution.
			result = $.fn.valueview.execute.apply( null, subArgs );
		} else {
			// will initialize the right 'valueview' widget for each node and according to the
			// given 'options.on'. Consider that more than one option objects can be given!
			$.fn.valueview.fabricate.apply( null, subArgs );
		}
		return result;
	};

	/**
	 * Part of the bridge to a valueview view. Handles execution of functions.
	 * @since 0.1
	 *
	 * @param {jQuery} $subject
	 * @param {String} method Name of the member function to be executed
	 * @returns {*}
	 */
	$.fn.valueview.execute = function( $subject, method /**, ... args ... */ ) {
		var bridgeArgs = Array.prototype.slice.call( arguments, 1 ),
			returnValue = $subject;

		// consider that there are several nodes in the $subject
		$subject.each( function() {
			var instance = $.data( this, 'valueview' ),
				realWidgetName = valueViews[ instance.dataValueType ],
				methodValue;

			if( !instance ) {
				return true; // no widget on this DOM node, skip it
			}

			// call bridge to to the specific widget
			methodValue = getBridgeToSubView( realWidgetName ).apply( $subject, bridgeArgs );

			// if the method has returned something special, return it (standard bridge behavior)
			if( methodValue !== instance && methodValue !== undefined ) {
				returnValue = methodValue;
				return false; // stop loop
			}
		} );

		return returnValue;
	};

	/**
	 * Part of the bridge to a valueview view. Handles creation of new instances.
	 * @since 0.1
	 *
	 * @param {jQuery} $subject
	 * @param {String} method Name of the member function to be executed
	 * @returns {*}
	 *
	 * @throws {Error} if 'on' option is not set properly and no view can be chosen based on it.
	 */
	$.fn.valueview.fabricate = function( $subject, options /**, ... more options ... */ ) {
		// allow to give a DataType instance rather than options as short-cut

		var viewName = $.valueview.chooseView(
			$.isPlainObject( options ) ? options.on : options );

		// TODO: if 'on' is a DataValue, we probably want to set the initial value to its value.

		if( viewName === null ) {
			throw new Error( "The 'on' option or first parameter has to be set to a sufficient criteria for choosing a view" );
		}

		// allow multiple option hashes (just like $.widget.bridge):
		var args = Array.prototype.slice.call( arguments, 2 );
		$.extend.apply( null, [ true, options ].concat( args ) ); // merge all options in 'options'

		var bridgeName = 'valueview_' + viewName;

		// the widget doesn't need to know about this option
		options.on = undefined;

		// call the bridge to the specific widget;
		// this will finally initiate the widget on all subject nodes
		getBridgeToSubView( viewName ).call( $subject, options );

		// make sure we can access .data( 'valueview' ) in addition to .data( 'valueview_some' )
		$subject.filter( ':' + bridgeName ).each( function() {
			$( this ).data( 'valueview', $( this ).data( bridgeName ) );
		} );
	};

	/**
	 * Will return the name of a specific valueview view based on a given hint.
	 *
	 * @param {dv.DataValue|dt.DataType} onTheBasisOf
	 * @return {String|null} null if there is no view available
	 *
	 * @throws {Error} if no sufficient first parameter is given.
	 */
	$.valueview.chooseView = function( onTheBasisOf ) {
		var valueType;

		if( onTheBasisOf instanceof dv.DataValue ) {
			valueType = onTheBasisOf.getType();
		}
		else if( onTheBasisOf instanceof dt.DataType ) {
			valueType = onTheBasisOf.getDataValueType();
		}
		else {
			throw new Error( 'No sufficient indicator provided for choosing a valueview view widget' );
		}

		return valueViews[ valueType ] || null;
	};

	/**
	 * Returns whether there is a view available for representing a data value or a data value
	 * valid against a given data type.
	 *
	 * @param {dv.DataValue|dt.DataType} dataHint
	 * @return {Boolean} false if no view is available
	 */
	$.valueview.canChooseView = function( onTheBasisOf ) {
		return $.valueview.chooseView( onTheBasisOf ) !== null;
	};

	/**
	 * Enhanced version of the jQuery.widget factory. Widgets defined here have the purpose of
	 * acting as interfaces to the user, allowing to create DataValue instances for a certain
	 * type of DataValue or for a certain DataType (the latter one is not yet supported).
	 *
	 * All data interface widgets have a common base in valueview.Widget. This ensures a common
	 * programming interface.
	 *
	 * @param {String} name The name of the widget, without 'valueview' namespace or prefix!
	 * @param {String|Object} [base]
	 * @param {Object} prototype
	 *
	 * @since 0.1
	 */
	$.valueview.widget = function( name, base, prototype ) {
		// base is optional and defaults to $.valueview.Widget
		if( !prototype ) {
			prototype = base;
			base = $.valueview.Widget;
		}
		else if( typeof base === 'string' ) {
			var baseName = base;
			base = $.valueview[ baseName ];

			if( base === undefined ) {
				throw new Error( "Can't use undefined widget 'jQuery.valueview." + baseName + "' as base" );
			}
			if( !( base instanceof $.valueview.Widget ) ) {
				throw new Error( "The base widget must be an instance of 'jQuery.valueview.Widget'" );
			}
		}

		// make sure there is no option introduced by the widget that is used by the 'valueview'
		// TODO: think about whether this is the way to go, consider the 'editview' widget which
		//       will most likely have additional options as well.
		if( prototype.options && prototype.options.on !== undefined ) {
			throw new Error( "'on' is an option reserved by '$.fn.valueview' and can't be used in any 'valueview' widget" );
		}

		var bridgeName = 'valueview_' + name;

		// $.widget() will create a bridge even though we don't want it, so we will manually
		// re-locate it. If there was another bridge already, we want to restore it later.
		var fnBeforeBridge = $.fn[ name ],
			exprBeforeWidget = $.expr[':'][ 'valueview-' + name ]; // same with widget selector

		// register widget.
		// all widget fabricated with this are supposed to be in the 'valueview' namespace.
		$.widget( 'valueview.' + name, base, $.extend( prototype, {
			widgetName: bridgeName,
			widgetBaseClass: 'valueview'
		} ) );

		if( fnBeforeBridge !== undefined ) {
			// restore whatever has been there before $.widget() put the bridge there
			$.fn[ name ] = fnBeforeBridge;
		} else {
			// delete bridge created by $.widget()
			delete $.fn.Widget;
		}

		// create our actual bridge, e.g. $('...').valueviewsomething(...)
		$.widget.bridge( bridgeName, $.valueview[ name ] );

		// create the widget selector we really want
		registerWidgetSelector( bridgeName );

		// and remove the widget selector created by $.widget()
		if( exprBeforeWidget !== undefined ) {
			// in case there was some other selector, restore it
			$.expr[':'][ 'valueview-' + name ] = exprBeforeWidget;
		} else {
			delete $.expr[':'][ 'valueview-' + name ];
		}

		// get the 'dataValueType' property from the new prototype. Can't take this from the
		// original prototype because this might be taken from the base prototype.
		var widgetsValueType = $.valueview[ name ].prototype.dataValueType;

		if( !widgetsValueType ) {
			throw new Error( "The 'valueview' widget has no 'dataValueType' property, can't register this view." );
		}

		// TODO: consider multiple widgets per type and...
		// TODO: ...think about criteria definitions to choose between them in $.fn.valueview()
		valueViews[ widgetsValueType ] = name;
	};

}( dataValues, dataTypes, jQuery ) );
