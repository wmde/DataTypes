/**
 * @file
 * @ingroup DataValues
 * @licence GNU GPL v2+
 * @author Daniel Werner
 */
( function( mw, dt, dv, vp, $, undefined ) {
	'use strict';

	/**
	 * Base constructor for objects representing a data type.
	 *
	 * @param {String} typeId
	 * @param {String} dataValueType
	 * @param {vp.Parser} parser
	 * @param {Object} formatter
	 * @param {Object} validators
	 * @constructor
	 * @abstract
	 * @since 0.1
	 */
	dt.DataType = function( typeId, dataValueType, parser, formatter, validators ) {
		if( dataValueType === undefined ) {
			throw new Error( 'All arguments must be provided for creating a new DataType object' );
		}
		this._typeId = typeId;
		this._dataValueType = dataValueType;
		this._parser = parser;
		this._formatter = formatter;
		this._validators = validators;
	};
	dt.DataType.prototype = {
		/**
		 * Returns the data type's identifier.
		 * @since 0.1
		 *
		 * @return String
		 */
		getId: function() {
			return this._typeId;
		},

		/**
		 * Returns the DataValue used by this data type.
		 * @since 0.1
		 *
		 * @return String
		 */
		getDataValueType: function() {
			return this._dataValueType;
		},

		/**
		 * Returns the ValueParser used by this data type.
		 * @since 0.1
		 *
		 * @return dv.ValueParser
		 */
		getParser: function() {
			return this._parser;
		},

		// TODO: add other getters

		/**
		 * Returns the label of data type.
		 * @since 0.1
		 *
		 * @return String
		 */
		getLabel: function() {
			return mw.message( 'datatypes-type-' + this.getId() );
		}
	};

}( mediaWiki, dataTypes, dataValues, valueParsers, jQuery ) );
