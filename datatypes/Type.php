<?php

interface Type {

	public function getType();

	public function getDataValueType();

	public function getParser();

	/**
	 * @abstract
	 * @return ValueFormatter
	 */
	public function getFormatter();

	//public function getValidators();

	public function getLabel( $langCode );

}