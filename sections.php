	public function getSections($key='ID',$arFilter,$arSelect=array("ID", "NAME"),$arSort=array("ID"=>"ASC"),$pageParams = false)
	{
        if(!CModule::IncludeModule("iblock")) return false;
        if(empty($arFilter)) return false;
        $arResult = false;
 
        $obCache = new CPHPCache;
        $life_time = 3600;
        $cache_params = $arFilter;
        $cache_params['key'] = $key;
        $cache_params['func']='getSections';
        $cache_params['arSelect']=$arSelect;
        $cache_params['sort']=$arSort;
        $cache_params['pageParams']=$pageParams;
        $cache_id = md5(serialize($cache_params));
        if($obCache->InitCache($life_time, $cache_id, "/")) :
            $arResult = $obCache->GetVars();
        else :

        	$rsSections = CIBlockSection::GetList($arSort, $arFilter, false, $arSelect, $pageParams);
	        while($arSection = $rsSections->GetNext())
	        {   
	            $arResult[$arSection[$key]] = $arSection;
	        }
        endif;
 
        if($obCache->StartDataCache()):
            $obCache->EndDataCache($arResult);
        endif;
 
        return $arResult;
	}
