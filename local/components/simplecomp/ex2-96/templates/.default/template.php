<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("LIKES_ELS")?></b></p>
<?
foreach($arResult["LIKES_ID_CURRENT"] as $a => $b){?>
	<ul>
		<li>
			<?=$arResult["ELEMENTS"][$b]["NAME"]?>
			<a href="<?=$arResult["ELEMENTS"][$b]["DETAIL_PAGE_URL"]?>"><?=" (".$arResult["ELEMENTS"][$b]["DETAIL_PAGE_URL"].") "?></a>
			- <?=$arResult["ELEMENTS"][$b]["PROPERTY_PRICE_VALUE"]?>
			- <?=$arResult["ELEMENTS"][$b]["PROPERTY_MATERIAL_VALUE"]?>
			- <?=$arResult["ELEMENTS"][$b]["PROPERTY_ARTNUMBER_VALUE"]?>
		</li>
	</ul>
<?}?>
<p><b><?=GetMessage("LIKES_YOURS")?></b></p>
<?
foreach($arResult["LIKES_ID_OTHER4"] as $xxx => $arElemIDs){
	if (!in_array($arElemIDs, $arResult["LIKES_ID_OTHER2"])) {?>
		<ul>
			<li>
				<?=$arResult["ELEMENTS"][$arElemIDs]["NAME"]?>
				<a href="<?=$arResult["ELEMENTS"][$xxx]["DETAIL_PAGE_URL"]?>"><?=" (".$arResult["ELEMENTS"][$arElemIDs]["DETAIL_PAGE_URL"].") "?></a>
				- <?=$arResult["ELEMENTS"][$arElemIDs]["PROPERTY_PRICE_VALUE"]?>
				- <?=$arResult["ELEMENTS"][$arElemIDs]["PROPERTY_MATERIAL_VALUE"]?>
				- <?=$arResult["ELEMENTS"][$arElemIDs]["PROPERTY_ARTNUMBER_VALUE"]?></br>
				<?=GetMessage("LIKES_USERS")?><?=implode(", ", $arResult["LIKES_ID"][$arElemIDs]);?>
			</li>
		</ul>
	<?}?>
<?}?>