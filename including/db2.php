<?php
// namespace Infoisodb\isodb;

$host = "localhost";
$login = "azuro"; //"root"; //"MHPALACEusr48";
$password = "4ix_hO7Y88"; //""; //"pnZ9*69p";
$base = "demo_azuro";
$db = mysqli_connect($host,$login,$password) or die (mysqli_error());
$database = mysqli_select_db($db, $base) or die (mysqli_error());

mysqli_query($db, "SET NAMES UTF8");
	

class QueryType
{
	public static function query($tb, $fld, $conds = '', $returnone = false, $orderby='', $groupby='', $limit_start = 0, $limit_end = 0) 
	{
		global $db;
		$val_conds = '';
		if (!empty($conds)) {
			$i=0;
		
			foreach($conds as $k => $v) {
				$val_conds .= ($i==0) ? ' WHERE ' : ' AND ';
				$val_conds .= $k.' = \''.mysqli_real_escape_string($db, $v).'\' ';
				$i++;
			}
		}
		$val_orderby = '';
		if (!empty($orderby)){
			$val_orderby = 'ORDER BY '.$orderby;
		}
		$val_groupby = '';
		if (!empty($groupby)){
			$val_groupby = 'GROUP BY '.$groupby;
		}
		$sql = ' SELECT '.$fld.' FROM '.$tb.' '.$val_conds.' '.$val_groupby.' '.$val_orderby;
		if ($returnone){
			$sql .= ' LIMIT 0, 1 ';
		}else{
			if ($limit_end > 0){
				$sql .= ' LIMIT '.$limit_start.', '.$limit_end;
			}
		}		

		// error_log('==>'.$sql.'<br>');
		return QueryExec::querySQL($sql, $returnone);
	}
	
	public static function querySimple($tb, $fld, $wh, $returnone = false, $ord = '', $gby='', $limit_start = 0, $limit_end = 0)
	{
		$val_wh = !empty($wh) ? ' WHERE '.$wh : '';
		$val_ord = !empty($ord) ? ' ORDER BY '.$ord : '';
		$val_gby = !empty($gby) ? ' GROUP BY '.$gby : '';
		$sql = ' SELECT '.$fld.' FROM '.$tb.$val_wh.$val_gby.$val_ord;
		if ($returnone){
			$sql .= ' LIMIT 0, 1 ';
		}else{
			if ($limit_end > 0){
				$sql .= ' LIMIT '.$limit_start.', '.$limit_end;
			}	
		}
		return QueryExec::querySQL($sql, $returnone);
	}
	
	public static function insert($tb, $flds) 
	{
		global $db;
		$sql = ' INSERT INTO '.$tb;
		$fl = '';
		$vl = '';
		$i=0;
		foreach($flds as $k => $v)
		{
			$fl .= ($i==0) ? ' ( ' : ' , ';
			$fl .= $k;
			
			$vl .= ($i==0) ? ' ( ' : ' , ';
			$vl .= '\''.mysqli_real_escape_string($db, $v).'\'';
			
			$i++;
		}
		$sql .= $fl . ' ) VALUES '.$vl.' )';
		
		$res = mysqli_query($db, $sql);
		if (!$res){
			return false;
		}
		$id = mysqli_insert_id($db);
		if ($id && $id > 0){
			return $id;
		}
		else{
			return false;
		}
	}
	
	public static function update($tb, $flds, $wh)
	{
		global $db;
		$sql = ' UPDATE '.$tb.' SET ';
		$i=0;
		foreach($flds as $k => $v) 
		{
			$sql .= ($i==0 ? '' : ',').$k.'=\''.mysqli_real_escape_string($db, $v).'\'';
			$i++;
		}
		
		$sql .= ' WHERE ';
		$i=0;
		foreach($wh as $k => $v)
		{
			$sql .= ($i==0 ? '' : ' AND ').$k.'=\''.mysqli_real_escape_string($db, $v).'\'';
			$i++;
		}

		// echo $sql;
		
		$res = mysqli_query($db, $sql);
		return !$res ? false : true;
	}
	
	public static function updateSimple($tb, $flds, $wh)
	{
		global $db;
		$sql = ' UPDATE '.$tb.' SET '.$flds.' WHERE '.$wh;
		
		$res = mysqli_query($db, $sql);
		
		return !$res ? false : true;		
	}
	
	public static function delete($tb, $wh)
	{
		global $db;
		$sql = ' DELETE FROM '.$tb.' WHERE ';
		$i=0;
		foreach($wh as $k => $v)
		{
			$sql .= ($i==0 ? '' : ' AND ').$k.'=\''.mysqli_real_escape_string($db, $v).'\'';
			$i++;
		}
		
		$res = mysqli_query($db, $sql);
		
		return !$res ? false : true;
	}
	
	public static function deleteSimple($tb, $wh)
	{
		global $db;
		$sql = ' DELETE FROM '.$tb.' WHERE '.$wh;
		$res = mysqli_query($db, $sql);
		
		return !$res ? false : true;		
	}
}
	

class loadSqlArray
{
	public static function objSqlCharge($objDatas, $k='')
	{
		if ($objDatas && $objDatas->num_rows > 0)
		{
			$ar = array();
			foreach($objDatas as $objData)
				if (!empty($k)){
					$ar[$objData[$k]] = $objData;
				}
				else{
					$ar[] = $objData;
				}
			return $ar;
		}
		return false;
	}
	
}
	

class QueryExec
{
	
	public static function querySQL($sql, $returnone = false, $tmp='')
	{
		global $db;
		
		$res = mysqli_query($db, $sql);
		// if($tmp=='1'){
		// 	echo('-----456>'.print_r($res));
		// 		die;
		// }

		if (!$res)
			return false;
			
		if ($returnone){
			return mysqli_fetch_object($res);
		}
		else{
			return $res;
		}
	}
}

