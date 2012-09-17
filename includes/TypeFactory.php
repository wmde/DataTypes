<?php

class TypeFactory {

	/**
	 * Maps type id to Type.
	 * @var array of Type
	 */
	protected $types;

	public function singleton() {
		if ( true ) {
			$instance = 0;

			$instance->initizlise();
		}


		return $instance;
	}

	protected function initizlise()  {

	}

	/**
	 * @return array of $typeId
	 */
	public function getTypesIds() {
		return array_keys( $this->types );
	}

	/**
	 * @param $typeId
	 * @return Type
	 */
	public function getType( $typeId ) {
		return $this->types[$typeId];
	}

	/**
	 * @return array of Type
	 */
	public function getTypes() {
		return $this->types;
	}

}