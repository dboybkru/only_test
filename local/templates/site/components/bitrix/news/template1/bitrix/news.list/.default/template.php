<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="article-card">
    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?><br />
    <?endif;?>

    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="block-content" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="display: flex; align-items: flex-start; margin-bottom: 2px;">
            <?if($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                <div class="article-card__image sticky";>
                    <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                            <img
                                class="preview_picture"
                                src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
                                height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
                                alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                                data-object-fit="cover"
                            />
                        </a>
                    <?else:?>
                        <img
                            class="preview_picture"
                            src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                            width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
                            height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                            data-object-fit="cover"
                        />
                    <?endif;?>
                </div>
            <?endif;?>

            <div class="article-card__text">
                <?if($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                    <span class="article-card__date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></span>
                <?endif;?>

                <?if($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]):?>
                    <h3>
                        <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><b><?=$arItem["NAME"]?></b></a>
                        <?else:?>
                            <b><?=$arItem["NAME"]?></b>
                        <?endif;?>
                    </h3>
                <?endif;?>

                <?if($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]):?>
                    <p><?=$arItem["PREVIEW_TEXT"];?></p>
                <?endif;?>

                <?foreach($arItem["FIELDS"] as $code => $value):?>
                    <small><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?></small><br />
                <?endforeach;?>

                <?foreach($arItem["DISPLAY_PROPERTIES"] as $pid => $arProperty):?>
                    <small>
                        <?=$arProperty["NAME"]?>:&nbsp;
                        <?if(is_array($arProperty["DISPLAY_VALUE"])):?>
                            <?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
                        <?else:?>
                            <?=$arProperty["DISPLAY_VALUE"];?>
                        <?endif;?>
                    </small><br />
                <?endforeach;?>
            </div>
        </div>
    <?endforeach;?>

    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <br /><?=$arResult["NAV_STRING"]?>
    <?endif;?>
</div>