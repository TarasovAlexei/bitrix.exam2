<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);

if (isset($arResult['MIN_PRICE']) && isset($arResult['MAX_PRICE'])) {
	$infoTemplate = '<div style="color:red; margin: 34px 15px 35px 15px">#text#</div>';
	$text = Loc::getMessage("MIN_PRICE").$arResult['MIN_PRICE'].", ".Loc::getMessage("MAX_PRICE").$arResult['MAX_PRICE'];
	$info = str_replace('#text#', $text, $infoTemplate);

	$APPLICATION->AddViewContent('prices', $info);
}?>
