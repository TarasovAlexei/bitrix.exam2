<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ex2-70");
?><?$APPLICATION->IncludeComponent(
	"simplecomp:ex2-70",
	"",
	Array(
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"NEWS_IBLOCK_ID" => "1",
		"PRODUCT_IBLOCK_ID" => "2",
		"PROPERTY_NEWS_CODE" => "UF_NEWS_LINK"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>