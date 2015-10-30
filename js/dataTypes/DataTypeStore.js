( function( $, dt ) {
	'use strict';

/**
 * DataType store.
 * @class dataTypes.DataTypeStore
 * @since 0.2
 * @licence GNU GPL v2+
 * @author H. Snater < mediawiki@snater.com >
 *
 * @constructor
 */
var SELF = dt.DataTypeStore = function DtDataTypeStore() {
	this._dataTypes = {};
};

$.extend( SELF.prototype, {
	/**
	 * Data type definitions.
	 * @property {Object} [_dataTypes={}]
	 * @private
	 */
	_dataTypes: null,

	/**
	 * Returns the data type of a specific data type id.
	 *
	 * @param {string} dataTypeId
	 * @return {dataTypes.DataType|null}
	 *
	 * @throws {Error} when supplied data type id is not a string.
	 */
	getDataType: function( dataTypeId ) {
		if ( !dataTypeId || typeof dataTypeId !== 'string' ) {
			throw new Error( 'The ID given to identify a data type needs to be a string' );
		}
		return this._dataTypes[dataTypeId] || null;
	},

	/**
	 * Returns if there is a DataType of the provided type.
	 *
	 * @param {string} dataTypeId
	 * @return {boolean}
	 */
	hasDataType: function( dataTypeId ) {
		return this._dataTypes[dataTypeId] !== undefined;
	},

	/**
	 * Registers a new data type. A data type already registered for the id of the new data type
	 * will be overwritten.
	 *
	 * @param {dataTypes.DataType} dataType
	 *
	 * @throws {Error} if data type is not a dt.DataType instance.
	 */
	registerDataType: function( dataType ) {
		if ( !( dataType instanceof dataTypes.DataType ) ) {
			throw new Error( 'Can only register instances of dataTypes.DataType' );
		}
		this._dataTypes[dataType.getId()] = dataType;
	}
} );

}( jQuery, dataTypes ) );
