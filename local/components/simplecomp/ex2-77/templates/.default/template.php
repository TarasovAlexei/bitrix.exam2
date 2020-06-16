<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<ul>
<?
foreach($arResult["CLASSIFIER"] as $section)
{
	?>
	<li><b><?=$section["NAME"]?></b> 
	<?
	$arNameSections = array();
	foreach($section["LINK_SECTIONS"] as $idSection)
		$arNameSections[] = $arResult["SECTIONS"][$idSection]["NAME"]
	?>
	(<?=implode(", ", $arNameSections)?>)
	</li>
	<ul>
	<?foreach($section["LINK_ELEMENTS"] as $idElement):?>
		<li><?=$arResult["ELEMENTS"][$idElement]["NAME"]?> - <?=$arResult["ELEMENTS"][$idElement]["PROPERTY_PRICE_VALUE"]?> - <?=$arResult["ELEMENTS"][$idElement]["PROPERTY_MATERIAL_VALUE"]?> - <?=$arResult["ELEMENTS"][$idElement]["PROPERTY_ARTNUMBER_VALUE"]?> 
	<?endforeach;?>
	</li>
	</ul>
<?
}
?>
</ul>
