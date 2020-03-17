<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$moduleID = strtolower($arGadget['GADGET_ID']);
$jsFunctionName = 'bdGadget_GetDateSupport_'.str_replace('@', '', $arGadget['ID']);
$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/gadgets/bd/'.$moduleID.'/styles.css');
?>
<div class="bd-gadgets-pizza">
    <div class="bd-gadgets-spinner"></div>
    <div class="bd-gadgets-logo-pizza"></div>
    <div class="bd-gadgets-title" title="<?=$arGadget['NAME']?>"><?=$arGadget['NAME']?></div>
    <div class="bd-gadgets-content-layout"></div>
    <script type="text/javascript">
    if(typeof <?=$jsFunctionName?> !== 'function'){
        function <?=$jsFunctionName?>() {
            var obGadget = BX('t<?=$arGadget['ID']?>');
            if(obGadget){
                var obBDGadget = BX.findChildren(obGadget, {'className':'bd-gadgets-pizza'}, true);
                var obBDGadgetLayout = BX.findChildren(obGadget, {'className':'bd-gadgets-content-layout'}, true);
            }
            BX.ajax({
                url: '<?='/bitrix/gadgets/bd/'.$moduleID.'/ajax.php'?>',
                method: 'POST',
                data: {'mid': '<?=$moduleID?>'},
                dataType: 'html',
                timeout: 30,
                async: true,
                processData: true,
                scriptsRunFirst: true,
                emulateOnload: true,
                start: true,
                cache: false,
                onsuccess: function(data){
                    if(obGadget){
                        if(obBDGadget.length){
                            BX.addClass(obBDGadget[0], 'bd-gadgets-ready');
                        }
                        if(obBDGadgetLayout.length){
                            BX.adjust(obBDGadgetLayout[0], {html: data});
                        }
                    }
                },
                onfailure: function(){
                    if(obGadget){
                        if(obBDGadget.length){
                            BX.addClass(obBDGadget[0], 'bd-gadgets-ready');
                        }
                        if(obBDGadgetLayout.length){
                            BX.adjust(obBDGadgetLayout[0], {html: '<div class="bd-gadgets-title2 pink"><?=GetMessage('GD_BD_ERROR')?></div>'});
                        }
                    }
                }
            });
        }
    }

    <?=$jsFunctionName?>();
    </script>
</div>