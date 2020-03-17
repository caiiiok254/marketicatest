<? 
    use Bitrix\Main\Loader;
    use Bitrix\Main\Application; 
    use Bitrix\Main\Web\Uri;
     
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	CModule::IncludeModule("iblock");
	
    class Gallery extends CBitrixComponent
    {
        
        public function executeComponent()
        {

                if(is_numeric($this->arParams["IBLOCK_ID"]))
                {
                    $rsIBlock = \CIBlock::GetList(array(), array(
                        "ACTIVE" => "Y",
                        "ID" => $this->arParams["IBLOCK_ID"],
                        "CHECK_PERMISSIONS"=>"N"
                    ));

                }
                else
                {
                    $rsIBlock = \CIBlock::GetList(array(), array(
                        "ACTIVE" => "Y",
                        "CODE" => $this->arParams["IBLOCK_ID"],
                        "SITE_ID" => SITE_ID,
                        "CHECK_PERMISSIONS"=>"N"
                    ));

                }
                    $this->arResult = $rsIBlock->GetNext();
                    $this->arResult["USER_HAVE_ACCESS"] = $bUSER_HAVE_ACCESS;

                    $arSelect = array(
                        "ID",
                        "IBLOCK_ID",
                        "NAME",
                        "CODE",
                        "ACTIVE_FROM",
                        "TIMESTAMP_X",
                        "PREVIEW_PICTURE",
                        "PREVIEW_TEXT",
                     );                
                    
                    $bGetProperty = count($this->arParams["PROPERTY_CODE"])>0;
                    if($bGetProperty){
                        
                        foreach($this->arParams["PROPERTY_CODE"] as $arPropertyCode){
                        $arSelect[] = "PROPERTY_".$arPropertyCode;
                        }
                        
                    }else{
                        
                        $arSelect[]="PROPERTY_*";
                    }
                    //WHERE
                    $arFilter = array (
                        "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
                        "IBLOCK_LID" => SITE_ID,
                        "ACTIVE" => "Y",
                        "CHECK_PERMISSIONS" => $this->arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
                    );

                    //ORDER BY
                    $arSort = array(
                        $this->arParams["SORT_BY1"]=>$this->arParams["SORT_ORDER1"],

                    );
                    if(!array_key_exists("ID", $arSort))
                        $arSort["ID"] = "DESC";

                    $this->arResult["ITEMS"] = array();
  
                    $arrFilter = array();
                    
                    $rsElement = CIBlockElement::GetList($arSort, array_merge($arFilter, $arrFilter), false, false, $arSelect);
                    
                    $arr = array();
                    $arElements = array();
                   
                    while($arItem = $rsElement->GetNext())
                    {
                        $boolShowDescr = "N";
                        $arButtons = CIBlock::GetPanelButtons(
                            $arItem["IBLOCK_ID"],
                            $arItem["ID"],
                            0,
                            array("SECTION_BUTTONS"=>false, "SESSID"=>false)
                        );
                        
                        $arItem["ADD_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
                        $arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
                        $arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];
                        
						
                        if(!empty($arItem["PREVIEW_PICTURE"])){
                            $arFile = CFile::GetFileArray($arItem['PREVIEW_PICTURE']);
                            $arItem["PREVIEW_PICTURE"] = $arFile;
                            
                        }
						
		
						 $this->arResult["ITEMS"][] = $arItem;
                    }

                    $this->includeComponentTemplate();
                    


        }    

        public function onPrepareComponentParams($arParams)
        {
            
            
            if(!isset($arParams["CACHE_TIME"]))
                $arParams["CACHE_TIME"] = 36000000;

            $arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
            if(strlen($arParams["IBLOCK_TYPE"])<=0)
                $arParams["IBLOCK_TYPE"] = "news";
            
            $arParams["IBLOCK_ID"] = trim($arParams["IBLOCK_ID"]);
            $arParams["SET_LAST_MODIFIED"] = $arParams["SET_LAST_MODIFIED"]==="Y";
     
            $arParams["SORT_BY1"] = trim($arParams["SORT_BY1"]);
            if(strlen($arParams["SORT_BY1"])<=0)
                $arParams["SORT_BY1"] = "ACTIVE_FROM";
            if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER1"]))
                $arParams["SORT_ORDER1"]="DESC";

                $arrFilter = array();

            $arParams["CHECK_DATES"] = $arParams["CHECK_DATES"]!="N";

            if(!is_array($arParams["FIELD_CODE"]))
                $arParams["FIELD_CODE"] = array();
            foreach($arParams["FIELD_CODE"] as $key=>$val)
                if(!$val)
                    unset($arParams["FIELD_CODE"][$key]);

            if(!is_array($arParams["PROPERTY_CODE"]))
                $arParams["PROPERTY_CODE"] = array();
            foreach($arParams["PROPERTY_CODE"] as $key=>$val)
                if($val==="")
                    unset($arParams["PROPERTY_CODE"][$key]);

            $arParams["DETAIL_URL"]=trim($arParams["DETAIL_URL"]);

            $arParams["CHECK_PERMISSIONS"] = $arParams["CHECK_PERMISSIONS"]!="N";

            return $arParams;
        }
        
    }
?>