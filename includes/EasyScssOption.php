<?php

namespace EasyScss\Shared;

class EasyScssOption {

	public int|null $id;
	public string $meta_key;
	public string $meta_value;

	/**
	 * Build an instance of plugin option
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes)
	{
		$this->id = $attributes['id'];
		$this->meta_key = $attributes['meta_key'];
		$this->meta_value = $attributes['meta_value'];
	}

}
