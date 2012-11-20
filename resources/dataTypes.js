/**
 * JavaScript for 'DataTypes' extension
 * @see https://www.mediawiki.org/wiki/Extension:DataTypes
 *
 * @file
 * @ingroup DataValues
 *
 * @licence GNU GPL v2+
 * @author H. Snater < mediawiki@snater.com >
 */

/**
 * Global 'dataTypes' object
 * @type {Object}
 */
var dataTypes = new ( function( $, mw, undefined ) {
	'use strict';

	/**
	 * @var {Object} Data type definitions
	 */
	this._dts = mw.config.get( 'wbDataTypes' );

	/**
	 * Constructs and returns a new DataType of specified type id with the provided data.
	 *
	 * @param {String} dataTypeId
	 * @return {dt.DataType}
	 */
	this.newDataType = function( dataTypeId ) {
		if ( this._dts[dataTypeId] === undefined ) {
			throw new Error( 'Unknown data type: "' + dataTypeId + '" has no associated DataType class.' );
		} else {
			// TODO: inmplement parser, formatter, validators parameters
			return new this.DataType( dataTypeId, this._dts[dataTypeId] );
		}
	};

	/**
	 * Returns the ids of the registered DataTypes.
	 *
	 * @since 0.1
	 *
	 * @return {String[]}
	 */
	this.getDataTypes = function() {
		var keys = [];

		for ( var key in this._dts ) {
			if ( this._dts.hasOwnProperty( key ) ) {
				keys.push( key );
			}
		}

		return keys;
	};

	/**
	 * Returns if there is a DatType with the provided type.
	 *
	 * @param {String} dataTypeId
	 * @return {Boolean}
	 */
	this.hasDataType = function( dataTypeId ) {
		return ( this._dts[dataTypeId] !== undefined );
	};

} )( jQuery, mediaWiki );