( function( $, dt ) {
	'use strict';

/**
 * DataType store.
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
	 * @var {Object}
	 */
	_dataTypes: null,

	/**
	 * Returns the data type of a specific data type id.
	 * @since 0.2
	 *
	 * @param {string} dataTypeId
	 * @return {dataTypes.DataType|null}
	 */
	getDataType: function( dataTypeId ) {
		if( !dataTypeId || typeof dataTypeId !== 'string' ) {
			throw new Error( 'The ID given to identify a data type needs to be a string' );
		}
		return this._dataTypes[dataTypeId] || null;
	},

	/**
	 * Returns if there is a DataType of the provided type.
	 * @since 0.2
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
	 * @since 0.2
	 *
	 * @param {dataTypes.DataType} dataType
	 */
	registerDataType: function( dataType ) {
		if( !( dataType instanceof dataTypes.DataType ) ) {
			throw new Error( 'Can only register instances of dataTypes.DataType' );
		}
		this._dataTypes[dataType.getId()] = dataType;
	}
} );

}( jQuery, dataTypes ) );
