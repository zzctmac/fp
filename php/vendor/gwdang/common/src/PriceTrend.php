<?php
/**
 * User: 周智超
 * Date: 2016/7/27
 * Time: 11:56
 */

namespace common;


class PriceTrend {
    /**
     * 通过子站价格完善价格历史
     * @param $subList
     * @param $dp_ids
     * @param $subsite_dp_ids_relation
     * @return array
     */
    public static function improveBySubSite($subList,$dp_ids, $subsite_dp_ids_relation) {
        if(empty($subList)) $subList = array();
        $final_trend_datas = array();
        foreach($dp_ids as $item){
            if(array_key_exists($item, $subsite_dp_ids_relation)){
                if(array_key_exists($subsite_dp_ids_relation[$item], $subList)){
                    $final_trend_datas[$item] = $subList[$subsite_dp_ids_relation[$item]];
                    $final_trend_datas[$item]['show_sub'] = TRUE;
                }
            }else{
                if(array_key_exists($item, $subList)){
                    $final_trend_datas[$item] = $subList[$item];
                    $final_trend_datas[$item]['show_sub'] = FALSE;
                }
            }
        }
        return $final_trend_datas;
    }

    /**
     * 通过site_id来保证dp唯一
     * @param $dp_ids
     * @param $now_id
     * @return array
     */
    public static function uniqueBySiteId($dp_ids,$now_id){
        $dps = array();
        $site_ids = array();
        if(!empty($now_id)){
            $now_dp_id = explode('-',$now_id);
            $site_ids[$now_dp_id[1]] = true;
        }
        for($i=0;$i<count($dp_ids);$i++){
            if($dp_ids[$i] === '0-0') continue;
            $dp_id = explode('-',$dp_ids[$i]);
            if(count($dp_id) === 2){
                if(!$site_ids[$dp_id[1]]){
                    $dps[] = $dp_ids[$i];
                    $site_ids[$dp_id[1]] = true;
                }
            }
        }
        return $dps;
    }
}