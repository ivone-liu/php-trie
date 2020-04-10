<?php


class MakeRelation {

	public function __construct() {
		// 品智港
		$this->pinzhi_db = new mysqli('127.0.0.1', 'root', 'liu1feng', 'shop');
		if(mysqli_connect_error()){
		    echo mysqli_connect_error();
		    return;
		}
		$this->pinzhi_db->set_charset("utf8");
		// 央联港
		$this->yanglian_db = new mysqli('127.0.0.1', 'root', 'liu1feng', 'yang');
		if(mysqli_connect_error()){
		    echo mysqli_connect_error();
		    return;
		}
		$this->yanglian_db->set_charset("utf8");
	}

	/**
	 * 生成完整的地区对应关系
	 * @Author   Ivone      i@ivone.me
	 * @DateTime 2020-04-10
	 * @return   [type]     [description]
	 */
	public function run() {
		$final_relation = []; // 最终的关系数组
		$this->pinzhi_db->query("ALTER table `dsc_region` ADD `is_update` TINYINT DEFAULT 0"); 
		$creating = 1;
		while ($creating) {
			$line = $this->pinzhi_db->query("SELECT * FROM `dsc_region` WHERE `is_update` = 0 LIMIT 1"); 
			$region = $line->fetch_assoc();
			if (empty($region)) {
				$creating = 0;
			} else {
				$relation = $this->yanglian_db->query("SELECT * FROM `dsc_region` WHERE `region_name` LIKE '".$region['region_name']."%' AND `region_type`=".$region['region_type']);
				$rows = $relation->num_rows;
				if ($rows > 1) {
					$save = "行政区域: ".$region['region_name'].", 区域等级: ".$region['region_type'].", 重复个数: ".$rows."\n";
					$this->saveFile($save, './repeatd.log', 'a+');
				}
				$result = $relation->fetch_assoc();
				if (!empty($result)) {
					$final_relation[$region['region_id']] = $result['region_id'];
				} else {
					$final_relation[$region['region_id']] = 0;
				}
				echo $region['region_name'] . " was Pocesssed. \n";
			}
			$this->pinzhi_db->query("UPDATE `dsc_region` SET `is_update` = 1 WHERE `region_id`=".$region['region_id']); 
		}
		$this->pinzhi_db->query("ALTER table `dsc_region` DROP `is_update`"); 
		// $f = serialize($final_relation);
		$f = json_encode($final_relation);
		$this->saveFile($f);
	}

	/**
	 * 从品智港的快递模板中读取
	 * @Author   Ivone      i@ivone.me
	 * @DateTime 2020-04-10
	 * @return   [type]     [description]
	 */
	public function run_tpl() {
		$final_relation = []; // 最终的关系数组
		$this->pinzhi_db->query("ALTER table `dsc_goods_transport_tpl` ADD `is_update` TINYINT DEFAULT 0"); 
		$creating = 1;
		while ($creating) {
			$line = $this->pinzhi_db->query("SELECT * FROM `dsc_goods_transport_tpl` WHERE `is_update` = 0 LIMIT 1"); 
			$shipping = $line->fetch_assoc();
			if (empty($shipping)) {
				$creating = 0;
			} else {
				$regions = explode(',', $shipping['region_id']);
				foreach ($regions as $reg) {
					$region_info = $this->pinzhi_db->query("SELECT * FROM `dsc_region` WHERE `region_id`=".$reg); 
					$info = $region_info->fetch_assoc();
					$relation = $this->yanglian_db->query("SELECT * FROM `dsc_region` WHERE `region_name` LIKE '".$info['region_name']."%' AND `region_type`=".$info['region_type']);
					$rows = $relation->num_rows;
					if ($rows > 1 || $rows == 0) {
						$save = "行政区域: ".$info['region_name'].", 区域等级: ".$info['region_type'].", 央联港查询结果行数: ".$rows.", 区域ID: ".$reg.", dsc_goods_transport_tpl 表ID: ".$shipping['id']."\n";
						$this->saveFile($save, './repeatd.log', 'a+');
					}
					$result = $relation->fetch_assoc();
					if (!empty($result)) {
						$final_relation[$info['region_id']] = $result['region_id'];
					} else {
						$final_relation[$info['region_id']] = 0;
					}
				}
				echo $shipping['tpl_name'] . " was Pocesssed. \n";
			}
			$this->pinzhi_db->query("UPDATE `dsc_goods_transport_tpl` SET `is_update` = 1 WHERE `id`=".$shipping['id']); 
		}
		$this->pinzhi_db->query("ALTER table `dsc_goods_transport_tpl` DROP `is_update`"); 
		// $f = serialize($final_relation);
		$f = json_encode($final_relation);
		$this->saveFile($f);
	}

	/**
	 * 日志记录
	 * @Author   Ivone      i@ivone.me
	 * @DateTime 2020-04-10
	 * @param    [type]     $data      [description]
	 * @param    string     $path      [description]
	 * @param    string     $mode      [description]
	 * @return   [type]                [description]
	 */
	public function saveFile($data, $path = './save.log', $mode = 'w') {
		if (empty($data)) {
			return;
		}
		$file = fopen($path, $mode);
		fwrite($file, $data);
		fclose($file);
	}

}


$make = new MakeRelation();
$make->run_tpl();

