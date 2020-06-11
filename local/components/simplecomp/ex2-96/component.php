<?
if (! defined ( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die ();
use Bitrix\Main\Loader;

if (!isset($arParams["CACHE_TIME"]))
{
	$arParams["CACHE_TIME"] = 36000000;
}


if (!$USER->IsAuthorized())
{
	ShowError (GetMessage("NO_AUTORIZ"));
	return;
}


$this->AddIncludeAreaIcons(
    array(
        array(
            "TITLE" => "Hello World!",
            "URL" => $APPLICATION->GetCurPage(true)."?hello=world",
            "IN_PARAMS_MENU" => false, 
        )
    )
);


if ($this->startResultCache(false, false)) 
{	
	
	if (!Loader::includeModule("iblock")) 
	{
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}

	//Пользователи
	$arOrderUser = array("id");
	$sortOrder = "asc";
	$arFilterUser = array(
		"ACTIVE" => "Y"
	);
	
	$arResult["USERS"] = array();
	$rsUsers = CUser::GetList($arOrderUser, $sortOrder, $arFilterUser); // выбираем пользователей
	while($arUser = $rsUsers->GetNext())
	{
		$arResult['USERS'][$arUser["ID"]] = $arUser["LOGIN"];
	}	

	//Элементы
	$arSelectElems = array (
		"ID",
		"IBLOCK_ID",
		"NAME",
		"PREVIEW_TEXT",
		"PROPERTY_PRICE",
		"PROPERTY_MATERIAL",
		"PROPERTY_LIKEUSER",
		"PROPERTY_ARTNUMBER",
		"DETAIL_PAGE_URL",
		"PROPERTY_".$arParams["PROP_CODE"]
	);
	
	$arFilterElems = array (
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
	);

	$arSortElems = array (
		"NAME" => "ASC"
	);

	$arResult["ELEMENTS"] = array();
	$arResult["ELEMENTS_ID"] = array();
	$rsElementElement = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
	while($arElement = $rsElementElement->GetNext())
	{	
		if (!empty($arElement["PROPERTY_".$arParams["PROP_CODE"]."_VALUE"]))
		{
			if ($arElement["PROPERTY_".$arParams["PROP_CODE"]."_VALUE"] == $USER->GetID()) {
				$arResult["LIKES_ID_CURRENT"][] = $arElement["ID"];
			}else{
				$arResult["LIKES_ID"][$arElement["ID"]][$arElement["PROPERTY_".$arParams["PROP_CODE"]."_VALUE"]] = $arResult['USERS'][$arElement["PROPERTY_".$arParams["PROP_CODE"]."_VALUE"]];
				$arResult["LIKES_ID2"][$arElement["PROPERTY_".$arParams["PROP_CODE"]."_VALUE"]][] = $arElement["ID"];
				$arResult["LIKES_ID_OTHER"][] = $arElement["ID"];
			}
		}
		$arResult["ELEMENTS"][$arElement["ID"]] = $arElement;
		$arResult["ELEMENTS_ID"][] = $arElement["ID"];
	}

	// товары текущего пользователя
	$arResult["LIKES_ID_CURRENT"] = array_unique($arResult["LIKES_ID_CURRENT"]); 

	// товары других пользователей
	$arResult["LIKES_ID_OTHER"] = array_unique($arResult["LIKES_ID_OTHER"]); 

	foreach ($arResult["LIKES_ID_CURRENT"] as $key => $value) {
		if (in_array($value, $arResult["LIKES_ID_OTHER"])) {
			$arResult["LIKES_ID_OTHER2"][] = $value;
		}
	}

	foreach ($arResult["LIKES_ID_OTHER2"] as $k => $v) {
		$arResult["LIKES_ID_OTHER3"] = array_keys ($arResult["LIKES_ID"][$v]);
	}
	
	foreach ($arResult["LIKES_ID_OTHER3"] as $kk => $vv) {
		$arResult["LIKES_ID_OTHER4"] = $arResult["LIKES_ID2"][$vv];
	}
	$arResult["LIKES_ID_OTHER4"] = array_unique($arResult["LIKES_ID_OTHER4"]); 

	$arResult["COUNT_CLASSIFIER"] = count($arResult["LIKES_ID_CURRENT"]);


	$this->SetResultCacheKeys(array(
		"ELEMENTS",
		"COUNT_CLASSIFIER",
		"LIKES_ID_CURRENT",
		"LIKES_ID_OTHER4",
	));
	
	$this->includeComponentTemplate();
} 

$APPLICATION->SetTitle("Избранных элементов  - ".$arResult["COUNT_CLASSIFIER"]);