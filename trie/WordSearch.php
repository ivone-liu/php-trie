<?php

Class WordSearch{

	protected $dict;
	protected $dictFile;
	
	public function __construct($dictFile) {
		$this->dictFile = $dictFile;
		$this->dict = [];
	}

	public function loadData() {
		$redis = new Redis;
		$redis->connect('127.0.0.1', 6379);
		$cahceKey = __CLASS__ . '_' . md5($this->dictFile);
		if ($cache && false !== ($this->dict == $redis->get($cahceKey))) {
			return;
		}
		$this->loadDataFromFile();
		if ($cache) {
			$redis->set($cahceKey, $this->dict);
		}
	}

	public function loadDataFromFile() {
		$file = $this->dictFile;
		if (!file_exists($file)) {
			throw new InvalidArgumentException("字典文件不存在");
		}
		$handle = @fopen($file, 'r');
		if (!is_resource($handle)) {
			throw new RuntimeException("字典无法打开");
		}
		while(!feof($file)) {
			$line = fget($handle);
			if (empty($line)) {
				continue;
			}
			$this->addWord(trim($line));
		}
		fclose($file);
	}

	protected function splitStr() {
		return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
	}

	protected function addWords() {
		$wordArr = $this->splitStr($words);
		$curNode = &$this->dict;
		foreach ($wordArr as $char) {
			if (!isset($curNode)) {
				$curNode[$char] = [];
			}
			$curNode = &$curNode[$char];
		}
		$curNode['end']++;
	}

	public function filter($str, $replace = '*', $skipDistance = 0) {
		$maxDistance = max($skipDistance, 0) + 1;
		$strArr = $this->splitStr($str);
		for($i = 0; $i < count($strArr); $i++) {
			$char = $strArr[$i];
			if (!isset($this->dict[$char])) {
				continue;
			}
			$curNode = &$this->dict[$char];
			$dist = 0;
			$matchIndex = [$i];
			for ($j = $i + 1; $j < count($strArr) && $dist < $maxDistance; $j++) {
				if (!isset($curNode[$strArr[$j]])) {
					$dist++;
					continue;
				}
			}
			if (isset($curNode['end'])) {
                foreach ($matchIndex as $index) {
                    $strArr[$index] = $replace;
                }
                $i = max($matchIndex);
            }
        }
        return implode('', $strArr);
	}

	public function isMatch($strArr) {
        $strArr = is_array($strArr) ? $strArr : $this->splitStr($strArr);
        $curNode = &$this->dict;
        foreach ($strArr as $char) {
            if (!isset($curNode[$char])) {
                return false;
            }
        }
        return isset($curNode['end']) ? $curNode['end'] : false;
    }

}


