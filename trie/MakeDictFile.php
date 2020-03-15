<?php

class MakeDictFile{

	protected $fire_dir;

	public function __construct($file = './poetry.txt';) {
		$this->fire_dir = $file;
		if (!file_exists($this->fire_dir)) {
			
		}
	}

}