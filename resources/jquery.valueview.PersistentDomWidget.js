/**
 * @licence GNU GPL v2+
 * @author Daniel Werner
 */
( function( dv, dt, $, undefined ) {
	'use strict';

	var PARENT = $.valueview.Widget;

	/**
	 * Private helper, serving the value DOM by building it or transforming the existing one.
	 */
	var serveValueDom = function( editable ) {
		var valueDom = this.$valueDomParent.children();
		if( valueDom.length === 0 ) {
			// build value DOM for the first time
			valueDom = this._buildValueDom();

			// so this.$valueDomParent can be used next in _createValueDomShortCuts()
			this.$valueDomParent.append( valueDom );

			this._createValueDomShortCuts( valueDom );
		}
		if( editable ) {
			this._formatAsEditableValue();
		} else {
			this._formatAsStaticValue();
		}
		return valueDom;
	};

/**
 * Can be used as a base for all 'valueview' widgets which should be designed in a way that the
 * input interface DOM is always displayed but simply styled differently when in non-edit mode.
 * This renders the '_serveEditableValueDom' and '_serveStaticValueDom' obsolete and introduces a
 * '_buildValueDom' function instead to fabricate the original DOM for the editable representation
 * of the value. The '_formatAsStaticValue' and '_formatAsEditableValue' functions introduced by
 * this will then have the job to do the transition between both changes without changing the DOM
 * structure radically.
 *
 * @option {String} inputPlaceholder Can be used to display a hint for the user if the input is empty.
 *
 * @constructor
 * @abstract
 * @extends jQuery.valueview.Widget
 * @since 0.1
 */
$.valueview.PersistentDomWidget = dv.util.inherit( PARENT, {
	/**
	 * @see jQuery.Widget._create
	 */
	_create: function() {
		this.element.addClass( 'persistentdomvalueview' );
		PARENT.prototype._create.call( this );
	},

	/**
	 * @see jQuery.Widget.destroy
	 */
	destroy: function() {
		this.element.removeClass( 'persistentdomvalueview' );
		return PARENT.prototype.destroy.call( this );
	},

	/**
	 * @see jQuery.valueview.Widget._serveStaticValueDom
	 * @final static view is still same DOM but formatted differently by this._formatAsStaticValue
	 */
	_serveStaticValueDom: function() {
		return serveValueDom.call( this, false );
	},

	/**
	 * @see jQuery.valueview.Widget._serveEditableValueDom
	 * @final editable view is still same DOM but formatted differently by this._formatAsEditableValue
	 */
	_serveEditableValueDom: function() {
		return serveValueDom.call( this, true );
	},

	/**
	 * Builds the input element(s) for editing, ready to be inserted into the DOM. The widget will
	 * append these nodes into the 'this.$valueDomParent' node.
	 *
	 * @since 0.1
	 * @abstract
	 *
	 * @return {jQuery} one or more DOM nodes serving as input for editing the value, at the same
	 *         time this will serve as static view with the '_formatAsStaticValue' and the
	 *         '_formatAsEditableValue' functions doing some simple re-formatting to switch the mode.
	 */
	_buildValueDom: dv.util.abstractMember,

	/**
	 * Allows to set some internal properties as references to certain input fields of the value.
	 * This is useful to use those references rather than having to select the right DOM nodes
	 * over and over again.
	 * E.g. using 'this.$datePicker' rather than 'this.$valueDomParent.children().first()' by
	 * mapping 'this.$datePicker' to the long form.
	 * The given jQuery object 'valueDom' is what will be appended to 'this.$valueDomParent'.
	 *
	 * @example <code>function() { this.$datePicker = valueDom.first() }</code>
	 *          Allows to use 'this.$datePicker' instead of 'this.$valueDomParent.children().first()'
	 *
	 * @param {jQuery} valueDom All the DOM nodes which will be appended to 'this.$valueDomParent'.
	 * @private
	 */
	_createValueDomShortCuts: function( valueDom ) { /* not abstract! */ },

	/**
	 * Has the task to re-format the DOM structure originally built by '_buildValueDom' and appended
	 * to this.$valueDomParent. After the formatting all inputs elements for editing the value
	 * should not look like accessible inputs anymore.
	 * Can be used to bind/unbind events, change styles and CSS classes or other properties of
	 * DOM nodes in this.$valueDomParent.
	 *
	 * @since 0.1
	 * @abstract
	 */
	_formatAsStaticValue: dv.util.abstractMember,

	/**
	 * Has the task to re-format the DOM structure originally built by '_buildValueDom' and appended
	 * to this.$valueDomParent. After the formatting all input elements for editing the value should
	 * be accessible by the user to edit the value.
	 * Can be used to bind/unbind events, change styles and CSS classes or other properties of
	 * DOM nodes in this.$valueDomParent.
	 *
	 * @since 0.1
	 * @abstract
	 */
	_formatAsEditableValue: dv.util.abstractMember
} );

}( dataValues, dataTypes, jQuery ) );
