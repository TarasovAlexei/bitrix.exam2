<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;


if($this->startResultCache(false, false)){
	        if (!Loader::includeModule("iblock")) 
        {
            $this->abortResultCache();
            ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
            return;
        }
	
	//Разделы инфоблока альтернативного классификатора
	$arSelect = array (
		"ID",
		"IBLOCK_ID",
		"NAME",
	);
	
	$arFilter = array (
		"IBLOCK_ID" => $arParams["ALTER_IBLOCK_ID"], 
		"ACTIVE" => "Y",
	);
		
	$arResult["CLASSIFIER"] = array();
	$rsElement = CIBlockSection::GetList(false, $arFilter, false, $arSelect, false);
	while($arElement = $rsElement->GetNext())
	{
		$arResult["CLASSIFIER"][$arElement["ID"]] = $arElement;
	}
	$arResult["COUNT"] = count($arResult["CLASSIFIER"]);
	


	//Разделы
	$arSelectSection = array(
		"ID",
		"IBLOCK_ID",
		"NAME",
		$arParams["CODE_ALTER"]
	);
	
	$arFilterSection = array (
		"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
		"ACTIVE" => "Y",
	);
	
	$arResult["SECTIONS"] = array();
	$rsElementSection = CIBlockSection::GetList(false, $arFilterSection, false, $arSelectSection, false);
	while($arElement = $rsElementSection->GetNext())
	{
		
		if($arElement[$arParams["CODE_ALTER"]] > 0)
		{
			$arResult["CLASSIFIER"][$arElement[$arParams["CODE_ALTER"]]]["LINK_SECTIONS"][] = $arElement["ID"];
		}
		$arResult["SECTIONS"][$arElement["ID"]] = $arElement;
	}



	//Элементы
	$arSelectElems = array (
		"ID",
		"IBLOCK_ID",
		"IBLOCK_SECTION_ID",
		"NAME",
		"PREVIEW_TEXT",
		"PROPERTY_PRICE",
		"PROPERTY_MATERIAL",
		"PROPERTY_ARTNUMBER"
	);
	
	$arFilterElems = array (
		"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
		"ACTIVE" => "Y"
	);
	
	$arSortElems = array (
		"NAME" => "ASC"
	);

	$arResult["ELEMENTS"] = array();
		
	$rsElementElement = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
	while($arElement = $rsElementElement->GetNext())
	{	
		
		if($arResult["CLASSIFIER"][$arResult["SECTIONS"][$arElement["IBLOCK_SECTION_ID"]][$arParams["CODE_ALTER"]]] > 0)
		{
			$arResult["CLASSIFIER"][$arResult["SECTIONS"][$arElement["IBLOCK_SECTION_ID"]][$arParams["CODE_ALTER"]]]["LINK_ELEMENTS"][] = $arElement["ID"];
		}
		
		$arResult["ELEMENTS"][$arElement["ID"]] = $arElement;
	}

	$this->SetResultCacheKeys(array(
		"CLASSIFIER",
		"SECTIONS",
		"COUNT",
	));
	
	$this->includeComponentTemplate();
} 


$APPLICATION->SetTitle("Разделы ".$arResult["COUNT"]);
?>