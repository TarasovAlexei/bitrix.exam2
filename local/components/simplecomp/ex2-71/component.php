<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;

if (!isset($arParams["CACHE_TIME"]))
{
	$arParams["CACHE_TIME"] = 36000000;
}


if ($this->startResultCache(false, array($USER->GetGroups())))
{
    if (!Loader::includeModule("iblock")) 
    {
        $this->abortResultCache();
        ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
        return;
    }

    //Вытаскиваем классификатор
    $arSelect = array (
        "ID",
        "IBLOCK_ID",
        "NAME",
    );
    
    $arFilter = array (
        "IBLOCK_ID" => $arParams["FIRMS_IBLOCK_ID"],
        "CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"],
        "ACTIVE" => "Y",
    );
        
    $arResult["CLASSIFIER"] = array();
    $rsElement_link = CIBlockElement::GetList(
        false, 
        $arFilter,
        false,
        false,
        $arSelect
    );
    while($arElement = $rsElement_link->GetNext())
    {
        $arResult["CLASSIFIER_ID"][] = $arElement["ID"];
        $arResult["CLASSIFIER"][$arElement["ID"]] = $arElement;
    }
    $arResult["COUNT_CLASS"] = count($arResult["CLASSIFIER"]);
    
    $arSelectElems = array (
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "NAME",
        "PREVIEW_TEXT",
    );
    
    $arFilterElems = array (
        "IBLOCK_ID" => $arParams["PRODUCT_IBLOCK_ID"],
        "CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"],
        "PROPERTY_".$arParams["PROPERTY_FIRMS"] => $arResult["CLASSIFIER_ID"],
        "ACTIVE" => "Y",
    );
    
    $arSortElems = array (
        "SORT" => "ASC"
    );

    $arResult["ELEMENTS"] = array();
        
    $rsElement = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
    while($rsElem = $rsElement->GetNextElement())
    {
        $arEl = $rsElem->GetFields();
        $arEl["PROP"] = $rsElem->GetProperties();
        
        foreach($arEl["PROP"]["COMPANY"]["VALUE"] as $val)
        {
            $arResult["CLASSIFIER"][$val]["ELEMENTS_ID"][] = $arEl["ID"];
        }
        
        $arResult["ELEMENTS"][$arEl["ID"]] = $arEl;
    }
        $this->SetResultCacheKeys(array("CLASSIFIER", "COUNT_CLASS"));
        $this->includeComponentTemplate();
}
$APPLICATION->SetTitle(GetMessage("COUNT_FIRMS_PRODUCT").$arResult["COUNT_CLASS"]);