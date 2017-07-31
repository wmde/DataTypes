( function ( $, dt ) {
	'use strict';

	/**
	 * Base constructor for objects representing a data type.
	 * @class dataTypes.DataType
	 * @abstract
	 * @since 0.1
	 * @license GPL-2.0+
	 * @author Daniel Werner
	 * @author H. Snater < mediawiki@snater.com >
	 *
	 * @constructor
	 * @param {string} dataTypeId
	 * @param {string} dataValueType
	 *
	 * @throws {Error} if data type id is not provided as a string.
	 * @throws {Error} if data value type is not provided as a string.
	 */
	var SELF = dt.DataType = function DtDataType( dataTypeId, dataValueType ) {
		if ( !dataTypeId || typeof dataTypeId !== 'string' ) {
			throw new Error( 'A data type\'s ID has to be a string' );
		}

		if ( typeof dataValueType !== 'string' ) {
			throw new Error( 'A data value type has to be given in form of a string' );
		}

		this._id = dataTypeId;
		this._dataValueType = dataValueType;
	};

	$.extend( SELF.prototype, {
		/**
		 * DataType identifier.
		 * @property {string}
		 * @private
		 */
		_id: null,

		/**
		 * DataValue identifier.
		 * @property {string}
		 * @private
		 */
		_dataValueType: null,

		/**
		 * Returns the data type's identifier.
		 *
		 * @return {string}
		 */
		getId: function () {
			return this._id;
		},

		/**
		 * Returns the DataValue used by this data type.
		 *
		 * @return {string}
		 */
		getDataValueType: function () {
			return this._dataValueType;
		}
	} );

	/**
	 * Creates a new DataType object from a given JSON structure.
	 * @static
	 *
	 * @param {string} dataTypeId
	 * @param {Object} json
	 * @return {dataTypes.DataType}
	 */
	SELF.newFromJSON = function ( dataTypeId, json ) {
		return new SELF( dataTypeId, json.dataValueType );
	};

}( jQuery, dataTypes ) );
