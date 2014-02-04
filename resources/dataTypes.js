/**
 * @licence GNU GPL v2+
 * @author Daniel Werner
 * @author H. Snater < mediawiki@snater.com >
 */

/**
 * Global 'dataTypes' object
 * @since 0.1
 * @type Object
 */
this.dataTypes = new ( function Dt( $ ) {
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
	 * @param {string} dataTypeId
	 * @param {string} dataValueType
	 */
	var SELF = dt.DataType = function DtDataType( dataTypeId, dataValueType ) {
		if( typeof dataValueType !== 'string' ) {
			throw new Error( 'A data value type has to be given in form of a string or DataValue ' +
				'constructor' );
		}

		if( !dataTypeId || typeof dataTypeId !== 'string' ) {
			throw new Error( 'A data type\'s ID has to be a string' );
		}

		this._id = dataTypeId;
		this._dataValueType = dataValueType;
	};

	$.extend( SELF.prototype, {

		/**
		 * DataType identifier.
		 * @type {string}
		 */
		_id: null,

		/**
		 * DataValue identifier.
		 * @type {string}
		 */
		_dataValueType: null,

		/**
		 * Returns the data type's identifier.
		 * @since 0.1
		 *
		 * @return {string}
		 */
		getId: function() {
			return this._id;
		},

		/**
		 * Returns the DataValue used by this data type.
		 * @since 0.1
		 *
		 * @return {string}
		 */
		getDataValueType: function() {
			return this._dataValueType;
		}
	} );

	/**
	 * Creates a new DataType object from a given JSON structure.
	 * @since 0.1
	 *
	 * @param {string} dataTypeId
	 * @param {Object} json
	 * @return {dataTypes.DataType}
	 */
	SELF.newFromJSON = function( dataTypeId, json ) {
		// TODO: Implement validators parameter:
		return new SELF( dataTypeId, json.dataValueType );
	};


	/**
	 * @var {Object} Data type definitions
	 */
	var dts = {};

	/**
	 * Returns the data type with a specific data type ID.
	 * @since 0.1
	 *
	 * @param {string} dataTypeId
	 * @return {dataTypes.DataType|null} Null if the data type is not known.
	 */
	this.getDataType = function( dataTypeId ) {
		if( !dataTypeId || typeof dataTypeId !== 'string' ) {
			throw new Error( 'The ID given to identify a data type needs to be a string' );
		}
		return dts[ dataTypeId ] || null;
	};

	/**
	 * Returns the ids of the registered DataTypes.
	 * @since 0.1
	 *
	 * @return {string[]}
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
	 * @param {string} dataTypeId
	 * @return {boolean}
	 */
	this.hasDataType = function( dataTypeId ) {
		return ( dts[dataTypeId] !== undefined );
	};

	/**
	 * Registers a new data type. A data type already registered for the id of the new data type
	 * will be overwritten.
	 * @since 0.1
	 *
	 * @param {dataTypes.DataType} dataType
	 */
	this.registerDataType = function( dataType ) {
		if( !( dataType instanceof this.DataType ) ) {
			throw new Error( 'Can only register instances of dataTypes.DataType as data types' );
		}
		dts[ dataType.getId() ] = dataType;
	};

} )( jQuery );

