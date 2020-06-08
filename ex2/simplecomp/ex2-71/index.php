<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ex2-71");
?><?$APPLICATION->IncludeComponent(
	"simplecomp:ex2-71", 
	".default", 
	array(
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"FIRMS_IBLOCK_ID" => "6",
		"PRODUCT_IBLOCK_ID" => "2",
		"PROPERTY_FIRMS_CODE" => "COMPANY",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>