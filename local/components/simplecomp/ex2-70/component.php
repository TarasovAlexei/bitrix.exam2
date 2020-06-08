<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;


if (!isset($arParams["CACHE_TIME"]))
{
	$arParams["CACHE_TIME"] = 36000000;
}


if ($this->startResultCache(false, false))
{
    if (!Loader::includeModule("iblock")) 
    {
        $this->abortResultCache();
        ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
        return;
    }

    // Выбор новостей
    $news = \CIBlockElement::GetList(
        array(),
        array('IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'], 'ACTIVE' => 'Y'),
        false,
        false,
        array('NAME', 'ACTIVE_FROM', 'ID')
    );
	
      while ($newsElement = $news->Fetch()) {
       
        $arButtons = CIBlock::GetPanelButtons(
            $newsElement["IBLOCK_ID"],
            $newsElement["ID"],
            0,
            array("SECTION_BUTTONS"=>false, "SESSID"=>false)
        );
        $arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
        $arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];
        $newsElement["ITEMS"] = $arItem;
    

        $newsIds[] = $newsElement["ID"];
        $newsList[$newsElement["ID"]] = $newsElement;
    }
  
    if ($APPLICATION->GetShowIncludeAreas()) {
        $arButtons = CIBlock::GetPanelButtons(
            $arParams["NEWS_IBLOCK_ID"],
            0
        );
        $this->addIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
    }
    
	
	
	
// Выбор разделов с привязкой к новостям
    $sections = \CIBlockSection::GetList(
        array(),
        array(
            'IBLOCK_ID' => $arParams['PRODUCT_IBLOCK_ID'],
            $arParams['PROPERTY_NEWS_CODE'] => $newsIds,
            'ACTIVE' => 'Y',
            'CNT_ACTIVE'
        ),
        true,
        array('NAME', 'IBLOCK_ID', 'ID', $arParams['PROPERTY_NEWS_CODE']),
        false
    );
    while ($section = $sections->Fetch()) {
        $sectionIds[] = $section['ID'];
        $sectionList[$section['ID']] = $section;
    }
	
	
	
// Выбор товаров с привязкой разделов, привязанных к новостям
    $products = \CIBlockElement::GetList(
        array(),
        array(
        	'IBLOCK_ID' => $arParams['PRODUCT_IBLOCK_ID'],
            'ACTIVE' => 'Y',
            'SECTION_ID' => $sectionIds
        ),
        false,
        false,
        array('NAME', 'IBLOCK_SECTION_ID', 'ID', 'IBLOCK_ID', 'PROPERTY_ARTNUMBER', 'PROPERTY_MATERIAL', 'PROPERTY_PRICE')
    );
     // Распределение продукции по новостям
     while ($product = $products->Fetch()) {
        foreach ($sectionList[$product['IBLOCK_SECTION_ID']]['UF_NEWS_LINK'] as $newsId) {
            $newsList[$newsId]['PRODUCTS'][] = $product;
        }
    }


    
    // Распределение разделов по новостям
    $arResult['PRODUCT_CNT'] = 0;
    foreach ($sectionList as $section) {
        $arResult['PRODUCT_CNT'] += $section['ELEMENT_CNT'];
        foreach ($section['UF_NEWS_LINK'] as $newsId) {
            $newsList[$newsId]['SECTIONS'][] = $section['NAME'];
        }
    }
    $arResult['NEWS'] = $newsList;
    $this->SetResultCacheKeys(array('NEWS', 'PRODUCT_CNT'));
    $this->IncludeComponentTemplate();
}
$APPLICATION->SetTitle(GetMessage('COUNT_CATALOG_PRODUCT').$arResult['PRODUCT_CNT']);
