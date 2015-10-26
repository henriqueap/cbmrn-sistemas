<?php


if ( ! function_exists('arr_set_index')) {
	function arr_set_index($arr, $str){
		if (count($arr) != 0) {
			foreach ($arr as $key => $value) {
				$i=$str.'_'.$key;
				$novo_arr[$i]=$value;
			}
			return $novo_arr;
		}
		else return false;
	}
}

