/**
 * @licence GNU GPL v2+
 * @author Daniel Werner
 * @author H. Snater < mediawiki@snater.com >
 */

this.dataTypes = this.dataTypes || {};

dataTypes.DataType = new ( function DataType( $ ) {
	'use strict';

	/**
	 * Base constructor for objects representing a data type.
	 * @constructor
	 * @abstract
	 * @since 0.1
	 *
	 * @param {string} dataTypeId
	 * @param {string} dataValueType
	 */
	var DataType = function DtDataType( dataTypeId, dataValueType ) {
		if( typeof dataValueType !== 'string' ) {
			throw new Error( 'A data value type has to be given in form of a string or DataValue '
				+ 'constructor' );
		}

		if( !dataTypeId || typeof dataTypeId !== 'string' ) {
			throw new Error( 'A data type\'s ID has to be a string' );
		}

		this._id = dataTypeId;
		this._dataValueType = dataValueType;
	};

	$.extend( DataType.prototype, {

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
	DataType.newFromJSON = function( dataTypeId, json ) {
		return new DataType( dataTypeId, json.dataValueType );
	};

	return DataType;

} )( jQuery );
