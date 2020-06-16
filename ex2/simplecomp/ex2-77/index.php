<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ex2-77");
?><?$APPLICATION->IncludeComponent(
	"simplecomp:ex2-77", 
	".default", 
	array(
		"ALTER_IBLOCK_ID" => "7",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CODE_ALTER" => "UF_NEW_CLASSIFIER",
		"PRODUCTS_IBLOCK_ID" => "2",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>