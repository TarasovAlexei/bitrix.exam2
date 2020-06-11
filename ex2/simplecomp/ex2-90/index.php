<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ex2-90");
?><?$APPLICATION->IncludeComponent(
	"simplecomp:ex2-96",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"PRODUCTS_IBLOCK_ID" => "1",
		"PROP_CODE" => "USERFAVOR"
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>