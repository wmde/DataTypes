/**
 * JavaScript for 'DataTypes' extension
 * @see https://www.mediawiki.org/wiki/Extension:DataTypes
 *
 * @file
 * @ingroup DataTypes
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner
 * @author H. Snater < mediawiki@snater.com >
 */

/**
 * Global 'dataTypes' object
 * @since 0.1
 * @type Object
 */
var dataTypes = new ( function Dt( $, mw, DataValue ) {
	'use strict';

	// TODO: the whole structure of this is a little weird, perhaps there should be a
	//       'dataTypeStore' or something rather than having this in the 'dataTypes' object.
	//       For this 'dataTypeStore' there could be several instances, different extensions could
	//       use their own set of data types without them getting mixed up.

	var dt = this;

	/**
	 * Base constructor for objects representing a data type.
	 * @constructor
	 * @abstract
	 * @since 0.1
	 *
	 * @param {String} typeId
	 * @param {String|Function} dataValueType Can be a DataValue constructor whose type will then be taken.
	 * @param {vp.ValueParser} parser
	 * @param {Object} formatter
	 * @param {Object} validators
	 */
	var SELF = dt.DataType = function DtDataType( typeId, dataValueType, parser, formatter, validators ) {
		if( dataValueType && dataValueType.prototype instanceof DataValue
		) { // DataValue constructor
			dataValueType = dataValueType.TYPE;
		}
		if( typeof dataValueType !== 'string' ) {
			throw new Error( 'A data value type has to be given in form of a string or DataValue constructor' );
		}

		if( !typeId || typeof typeId !== 'string' ) {
			throw new Error( 'A data type\'s ID has to be a string' );
		}

		this._typeId = typeId;
		this._dataValueType = dataValueType;
		this._parser = parser;
		this._formatter = formatter;
		this._validators = validators;
	};

	$.extend( SELF.prototype, {
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
		 * @return vp.ValueParser
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
	} );

	/**
	 * Creates a new DataType object from a given JSON structure.
	 * @since 0.1
	 *
	 * @param {String} typeId Data type id
	 * @param {Object} json JSON structure containing data type info
	 * @return {dt.DataType} DataType object
	 */
	SELF.newFromJSON = function( typeId, json ) {
		// TODO: inmplement parser, formatter and validators parameters
		return new SELF( typeId, json.dataValueType );
	};


	/**
	 * @var {Object} Data type definitions
	 */
	var dts = {};

	$.each( mw.config.get( 'wbDataTypes' ) || {}, function( dtTypeId, dtDefinition ) {
		dts[ dtTypeId ] = SELF.newFromJSON( dtTypeId, dtDefinition );
	} );

	/**
	 * Returns the data type with a specific data type ID.
	 * @since 0.1
	 *
	 * @param {String} dataTypeId
	 * @return {dt.DataType|null} Null if the data type is not known.
	 */
	this.getDataType = function( dataTypeId ) {
		if( !dataTypeId || typeof dataTypeId !== 'string' ) {
			throw new Error( 'The ID given to identify a data type needs to be a string' );
		}
		return dts[ dataTypeId ] || null;
	};

	/**
	 * Returns the ids of the registered DataTypes.
	 *
	 * @since 0.1
	 *
	 * @return {String[]}
	 */
	this.getDataTypeIds = function() {
		var keys = [];

		for ( var key in dts ) {
			if ( dts.hasOwnProperty( key ) ) {
				keys.push( key );
			}
		}

		return keys;
	};

	/**
	 * Returns if there is a DatType with the provided type.
	 * @since 0.1
	 *
	 * @param {String} dataTypeId
	 * @return {Boolean}
	 */
	this.hasDataType = function( dataTypeId ) {
		return ( dts[dataTypeId] !== undefined );
	};

	/**
	 * Registers a new data type.
	 * If there is a data type with the same id, it will be overridden with the provided one.
	 * // TODO/FIXME: not sure this behavior is a good idea
	 *
	 * @since 0.1
	 *
	 * @param {dt.DataType} dataType
	 */
	this.registerDataType = function( dataType ) {
		if( !( dataType instanceof this.DataType ) ) {
			throw new Error( 'Can only register instances of dataTypes.DataType as data types' );
		}
		dts[ dataType.getId() ] = dataType;
	};

} )( jQuery, mediaWiki, dataValues.DataValue );

window.dataTypes = dataTypes; // global alias
