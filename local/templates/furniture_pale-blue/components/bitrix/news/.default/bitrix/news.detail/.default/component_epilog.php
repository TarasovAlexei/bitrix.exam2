<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arParams['CANONICAL']){ 
      $APPLICATION->SetPageProperty("canonical", $arResult['CANONICAL']['NAME']); 
}