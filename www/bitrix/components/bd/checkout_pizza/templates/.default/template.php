<?php

use Bitrix\Main\Loader;

Loader::includeModule('bd.deliverypizza');

use Bd\Deliverypizza;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
global $USER; ?>
<?php if (!$USER->IsAdmin()) { ?>
	<?php if ($_SESSION['BASKET_SUM'] > 0): ?>
        <?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_CF_SHOP_COUNTRY', '', SITE_ID)!='ua'): ?>
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
        <?php endif; ?>

        <script type="text/javascript">
            window.currentHour = '<?=date('H', strtotime(\COption::GetOptionString('bd.deliverypizza', 'BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) . ' hour') + 3600)?>';
			<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_PICKUP_ENABLED', '', SITE_ID) == 'Y' && \COption::GetOptionString('bd.deliverypizza', 'BD_CF_SHOP_COUNTRY', '', SITE_ID)!='ua'): ?>
            ymaps.ready(init);
            var myMap;

            function init() {
                myMap = new ymaps.Map("map", {
                    center: [<?php echo $arResult["TAKE_AWAY"][0]['COORDINATE']; ?>],
                    zoom: 16
                });

				<?php foreach($arResult["TAKE_AWAY"] as $ta_item): ?>

                window.myPlacemark_<?php echo $ta_item['ID'] ?> = new ymaps.Placemark([<?php echo $ta_item['COORDINATE']; ?>], {
                    hintContent: '<?php echo $ta_item['NAME']; ?>',
                    balloonContent: '<?= GetMessage("checkout_take_away_address"); ?>: <?php echo $ta_item['NAME']; ?> <br /> <?= GetMessage("checkout_take_away_phone"); ?>: <?php echo $ta_item['PHONE']; ?> <br /> <?= GetMessage("checkout_take_away_email"); ?>: <?php echo $ta_item['EMAIL']; ?> <br /> <?= GetMessage("checkout_take_away_work_time"); ?>: <?php echo preg_replace( "/\r|\n/", "<br>", $ta_item['WORK_TIME']); ?>'
                });

                myMap.geoObjects.add(window.myPlacemark_<?php echo $ta_item['ID'] ?>);
				<?php endforeach; ?>
            }
			<?php endif; ?>
        </script>
        <div class="checkout-form">
            <form id="checkout-form" method="post">
                <input type="hidden" name="CSRF" value=""/>
                <div class="col-lg-5 col-xl-5 col-sm-12 col-md-12 col-xs-12 order-content-cont push-xl-7 push-lg-7">
                    <div class="checkout-title"><?= GetMessage('order-content') ?></div>
                    <div class="common-block">
                        <ul class="order-content hidden-md-down">
							<?php
							$basket_m = new Deliverypizza\Models\Basket();
							$basket_id = $basket_m->getBasket(0, session_id(), true);
							$basket = Deliverypizza\Entity\BasketTable::getList(array('filter' => array('=ID' => $basket_id)))->fetch();
							$content = $basket_m->getBasketContent(unserialize($basket['BASKET_CONTENT']));
							foreach ($content['products'] as $key => $value): ?>
                                <li data-pid="<?= $value['ID'] ?>">
                                    <div class="image">
                                        <img src="<?= $value['IMAGE']; ?>"/>
                                    </div>
                                    <div>
                                        <div class="name"><?= $value['NAME'] ?></div>
                                        <div class="section"><?= $value['SECTION'] ?></div>
                                        <div class="content_">
											<?php
											if (!isset($value['IS_GIFT']) && !isset($value['IS_ADDITIONAL']) && !isset($value['IS_CONSTRUCTOR'])) {
												$arSelect = Array('ID', "NAME", 'PROPERTY_BD_PROPS_1', 'PROPERTY_BD_PROPS_2');
												$arFilter = Array("IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[$_SESSION['SITE_ID']]["bd_content_pizza"]["bd_catalog"][0], 'ID' => $value['ID']);
												$res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
												while ($ob = $res->GetNext()) {
													if ($value['OPTIONS'][1] != NULL) {
														?>
                                                        <div class="option_name"><?= $ob['PROPERTY_BD_PROPS_1_VALUE'][0]['PROP'] ?></div>
                                                        <div class="option_value"><?= $ob['PROPERTY_BD_PROPS_1_VALUE'][$value['OPTIONS'][1]]['VALUE'] ?></div>
														<?
													}
													if ($value['OPTIONS'][2] != NULL) {
														?>
                                                        <div class="option_name"><?= $ob['PROPERTY_BD_PROPS_2_VALUE'][0]['PROP'] ?></div>
                                                        <div class="option_value"><?= $ob['PROPERTY_BD_PROPS_2_VALUE'][$value['OPTIONS'][2]]['VALUE'] ?></div>
														<?
													}
												}
											}
											if (isset($value['IS_CONSTRUCTOR'])) {
												$base = \CIBlockElement::GetByID($value['BASE_ID'])->GetNext(); ?>
                                                <div class="option_name"><?= GetMessage('checkout_base') ?></div>
                                                <div class="option_value"><?= $base['NAME']; ?></div>
												<?php
												$souse = \CIBlockElement::GetByID($value['SOUSE_ID'])->GetNext(); ?>
                                                <div class="option_name"><?= GetMessage('checkout_souse') ?></div>
                                                <div class="option_value"><?= $souse['NAME']; ?></div>
                                                <div class="option_name"><?= GetMessage('checkout_content_constructor') ?></div>
												<?php foreach ($value['INGREDIENTS'] as $ing): ?>
													<?php $item = \CIBlockElement::GetByID($ing)->GetNext(); ?>
                                                    <div class="option_value"><?= $item['NAME']; ?></div>
												<?php endforeach; ?>

												<?php
											} ?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="amount">
                                            <span><?= $value['AMOUNT'] ?></span> <?= GetMessage('amount_metric') ?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="price"><span><?= $value['LOCAL_SUM'] ?></span> <span
                                                    class="currency font-fix"><?= CURRENCY_FONT; ?></span></div>
                                    </div>
                                </li>
							<?php endforeach; ?>

                        </ul>
                    </div>
                </div>
                <div class="col-xs-1 hidden-md-down"></div>
                <div class="col-lg-6 col-xl-6 col-sm-12 col-md-12 col-xs-12 delivery-col pull-xl-6 pull-lg-6">
                    <div class="row fields-group">
                        <div class="row fields">
                            <div class="col-xs-6">
                                <div class="bd-input <?php if (!empty($arResult['USER']['NAME'])): ?>filled<?php endif; ?>">
                                    <label class="text-xl-center"><?= GetMessage("checkout_personal_name"); ?></label>
                                    <input type="text" name="ORDER[USER_NAME]" class="text-xs-left"
                                           value="<?php echo (!empty($arResult['USER']['NAME'])) ? $arResult['USER']['NAME'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <?php
                                $phone = '';
                                if(!empty($arResult['USER']['PHONE']) && $arResult['USER']['PHONE'] !== '7')
                                    $phone = $arResult['USER']['PHONE'];
                                if(is_numeric($USER->GetLogin()))
                                    $phone = $USER->GetLogin();
                                ?>
                                <div class="bd-input <?php if ($phone): ?>filled<?php endif; ?>">
                                    <label class="text-xl-center"><?= GetMessage("checkout_personal_phone"); ?></label>
                                    <input name="ORDER[USER_PHONE]" autocomplete="off" type="text" class="text-xs-left"
                                           value="<?php echo (!empty($phone)) ?$phone : ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row fields-group">
                        <div class="row fields">
                            <div class="col-xs-12">
                                <div class="delivery-config-cont">

                                    <div class="delivery-type-toggle font-fix">
                                        <a href="#" data-type="1"
										   <?php if (!isset($_SESSION['USE_PICKUP_DISCOUNT']) || $_SESSION['USE_PICKUP_DISCOUNT'] == 0): ?>class="active"<?php endif; ?>><?= GetMessage("checkout_delivery_type_courier"); ?></a>
										<?php if (\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_PICKUP_ENABLED', '', SITE_ID) == 'Y'): ?>
                                            <a href="#" data-type="2"
											   <?php if (isset($_SESSION['USE_PICKUP_DISCOUNT']) && $_SESSION['USE_PICKUP_DISCOUNT'] > 0): ?>class="active"<?php endif; ?>>
												<?= GetMessage("checkout_delivery_type_take_away"); ?>
												<?php if (\COption::GetOptionString('bd.deliverypizza', 'BD_CF_BASKET_PICKUP_DISCOUNT_ENABLED', '', SITE_ID) == 'Y'): ?>
                                                    <div class="pickup_discount_label"><?= str_replace('DISCOUNT', \COption::GetOptionInt('bd.deliverypizza', 'BD_CF_BASKET_PICKUP_DISCOUNT_VALUE', '', SITE_ID), GetMessage('pickup_discount_label')); ?></div>
												<?php endif; ?>
                                            </a>
										<?php endif; ?>
                                    </div>
                                    <input type="hidden" name="ORDER[DELIVERY_TYPE]"
                                           value="<?php if (isset($_SESSION['USE_PICKUP_DISCOUNT']) && $_SESSION['USE_PICKUP_DISCOUNT'] > 0): ?>2<?php else: ?>1<?php endif; ?>"/>
                                    <div class="delivery-type-content <?php if (\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_PICKUP_ENABLED', '', SITE_ID) !== 'Y'): ?>without-pickup<?php endif; ?>">
                                        <div
											<?php if (isset($_SESSION['USE_PICKUP_DISCOUNT']) && $_SESSION['USE_PICKUP_DISCOUNT'] > 0): ?>style="display: none;" <?php endif; ?>
                                            class="delivery-type-tab-1">
											<?php if (!empty($arResult['ADDRESSES'])): ?>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <div class="bd-select">
                                                            <div class="label"><?= GetMessage("checkout_delivery_my_adress"); ?></div>
                                                            <select class="cs-select cs-skin-slide checkout-user-addresses">
                                                                <option
                                                                        value="null"><?= GetMessage("checkout_choose"); ?></option>
																<?php foreach ($arResult['ADDRESSES'] as $address): ?>
                                                                    <option value=""
                                                                            data-street="<?php echo $address['STREET']; ?>"
                                                                            data-district="<?php echo $address['DISTRICT_ID']; ?>"
                                                                            data-house="<?php echo $address['HOUSE']; ?>"
                                                                            data-apartment="<?php echo $address['APARTMENT']; ?>"><?php echo $address['NAME']; ?></option>
																<?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
											<?php endif; ?>
											<?php if (count($arResult["DESTRICT"]) > 0): ?>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <div class="bd-select">
                                                            <div class="label"><?= GetMessage("checkout_delivery_destrict"); ?></div>
                                                            <select name="ORDER[DISTRICT_ID]"
                                                                    class="cs-select cs-skin-slide">
                                                                <option
                                                                        value="null"><?= GetMessage("checkout_choose"); ?></option>
																<? foreach ($arResult["DESTRICT"] as $key => $DESTRICT): ?>
                                                                    <option value="<?= $DESTRICT['ID'] ?>"><?= $DESTRICT['NAME'] ?></option>
																<? endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 delivery-price" style="display:none;"
                                                         data-free="<?= GetMessage("checkout_free_delivery"); ?>">
                                                        <div class="bd-input">
                                                            <div>
                                                                <label class="text-xs-center delivery-price-label font-fix _with-price"><?= GetMessage("checkout_price_delivery"); ?></label>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div class="_delivery-price-value" style="display: none;">
                                                                <span></span><span
                                                                        class="currency"><?= CURRENCY_FONT; ?></span>
                                                            </div>
                                                        </div>
                                                        <div style="display: none;" class="progress-container font-fix">
                                                            <div class="progress-bar"></div>
                                                            <div class="progress-bar-content">
                                                                <div></div>
                                                                <span></span><span
                                                                        class="currency"><?= CURRENCY_FONT; ?></span><?= GetMessage("checkout_price_delivery_for_free"); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
											<?php endif; ?>
                                            <div class="row _address_config">
                                                <div class="col-xs-12">
                                                    <div class="bd-input">
                                                        <label
                                                                class="text-xl-center"><?= GetMessage("checkout_delivery_street"); ?></label>
                                                        <input name="ORDER[STREET]" type="text" class="text-xs-left">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row _address_config _address_config2">
                                                <div class="col-lg-4 col-xl-4 col-sm-4 col-xs-4">
                                                    <div class="bd-input">
                                                        <label
                                                                class="text-xl-center"><?= GetMessage("checkout_delivery_home"); ?></label>
                                                        <input name="ORDER[HOUSE]" maxlength="6" type="text"
                                                               class="text-xs-left">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-4 col-sm-4 col-xs-4 not_private_house_fields">
                                                    <div class="bd-input">
                                                        <label
                                                                class="text-xl-center"><?= GetMessage("checkout_delivery_room"); ?></label>
                                                        <input name="ORDER[APARTMENT]" maxlength="6" type="text"
                                                               class="text-xs-left">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-4 col-sm-4 col-xs-4">
                                                    <div class="bd-checkbox">
                                                        <input type="checkbox" id="PRIVATE_HOUSE" name="PRIVATE_HOUSE"/>
                                                        <label for="PRIVATE_HOUSE"><span
                                                                    class="private-house"><?= GetMessage("private_house"); ?></span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										<?php if (\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_PICKUP_ENABLED', '', SITE_ID) == 'Y'): ?>
                                            <div
												<?php if (!isset($_SESSION['USE_PICKUP_DISCOUNT']) || $_SESSION['USE_PICKUP_DISCOUNT'] == 0): ?>style="display: none;" <?php endif; ?>
                                                class="delivery-type-tab-2">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="bd-select">
                                                            <div class="label"><?= GetMessage("checkout_delivery_take_away_where"); ?></div>
                                                            <select name="ORDER[DELIVERY_PICKUP_ID]"
                                                                    class="cs-select cs-skin-slide">
                                                                <option
                                                                        value="null"><?= GetMessage("checkout_choose"); ?></option>
																<? foreach ($arResult["TAKE_AWAY"] as $TAKE_AWAY): ?>
                                                                    <option data-coordinate="<?php echo $TAKE_AWAY['COORDINATE']; ?>"
                                                                            value="<?= $TAKE_AWAY['ID'] ?>"><?= $TAKE_AWAY['NAME'] ?></option>
																<? endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row map-row">
                                                    <div class="col-xs-12">
                                                        <div class="map-placeholder">
                                                            <div id="map"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										<?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row comment_row">
                            <div class="col-xs-12">
                                <div class="bd-input">
                                    <label class="text-xl-center"><?= GetMessage("checkout_comment"); ?></label>
                                    <input name="ORDER[COMMENT]" type="text" class="text-xs-left"/>
                                </div>
                            </div>
                        </div>
                        <div class="row type-conf-cont">
                            <div class="col-xs-12">
                                <div class="checkoout-label"><?= GetMessage("checkout_delivery_time"); ?></div>
                            </div>
                            <div
                                    class="col-lg-12 col-xl-12 col-sm-12 col-xs-12">
                                <div class="col-xs-2 nopadl hour-select-cont hour-select-1">
                                    <div class="bd-select">
                                        <div class="label"><?= GetMessage("checkout_hour"); ?></div>
                                        <select name="ORDER[HOUR]" class="cs-select cs-skin-slide">
                                            <option value="null"><?= GetMessage('checkout_choose') ?></option>
											<?php for ($i = 0; $i < 24; $i++):
												if ($i < 10) $f = "0" . $i; else $f = $i; ?>
                                                <option data-hour="<?= $i ?>" value="<?= $f ?>"><?= $f ?></option>
											<?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2 nopadl hour-select-cont">
                                    <div class="bd-select">
                                        <div class="label"><?= GetMessage("checkout_minute"); ?></div>
                                        <select name="ORDER[MINUTE]" class="cs-select cs-skin-slide">
                                            <option value="null"><?= GetMessage('checkout_choose') ?></option>
											<?php for ($i = 0; $i <= 45; $i += 15): ?>
                                                <option value="<?= ($i == 0) ? '0' . $i : $i; ?>"><?= ($i == 0) ? '0' . $i : $i; ?></option>
											<?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-5 text-xs-left hour-select-cont">
                                    <div class="bd-select">
                                        <div class="label"><?= GetMessage("checkout_change_date"); ?></div>
                                        <select name="ORDER[DELIVERY_DATE]">
                                            <option value=""><?= GetMessage("checkout_choose"); ?></option>
											<?php
											$iteration = 3;
											if (\COption::GetOptionString('bd.deliverypizza', 'BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) == '0' || \COption::GetOptionString('bd.deliverypizza', 'BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) == '') {
												$time = time();
											} else {
												$time = strtotime(\COption::GetOptionString('bd.deliverypizza', 'BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) . ' hour');
											}
											for ($i = 0; $i <= $iteration; $i++) {
												?>
                                                <option data-date="<?php echo FormatDate("j", time() + ($i * 86400)); ?>"
												        <?php if ($i == 0): ?>selected<?php endif; ?>
                                                        value="<?php echo FormatDate("j F", time() + ($i * 86400)); ?>"><?php echo FormatDate("j F", $time + ($i * 86400)); ?></option>
												<?php
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-3 delivery-time-type_ nopadl current_">
                                    <div class="bd-checkbox">
                                        <input type="checkbox" name="ORDER[DELIVERY_TIME_TYPE]" id="type_1" value="0"
                                               checked>
                                        <label for="type_1"><span><?= GetMessage("checkout_delivery_this"); ?></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="payment-fields">
                            <div class="row fields-group">
                                <div class="checkout-title"><?= GetMessage("checkout_pay_method"); ?></div>
                                <div class="row fields">
                                    <div class="col-xs-6 radios">
                                        <input type="hidden" name="ORDER[PAY_IDENT]"/>
										<? $i = 0;
										foreach ($arResult["PAYSYS"] as $PAYSYS): ?>
                                            <div>
                                                <label>
                                                    <input <?php if ($i == 0): ?>checked<?php endif; ?>
                                                           name="ORDER[PAYMENT_TYPE]" type="radio"
                                                           data-type="<?php echo $PAYSYS['IDENT_PAY']; ?>"
                                                           data-change="<?php echo $PAYSYS['CHANGE']; ?>"
                                                           value="<?= $PAYSYS['ID'] ?>"/>
                                                    <label>
                                                        <span></span>
                                                    </label>
                                                    <span><?= $PAYSYS['NAME'] ?></span>
                                                </label>
                                            </div>
											<?php if ($i == 0): ?>
                                                <div class="_change_row" style="display: block;">
                                                    <div class="col-xs-12 nopad">
                                                        <div class="bd-input">
                                                            <label class="text-xl-center"><?= GetMessage("checkout_pay_deposit"); ?></label>
                                                            <input type="text" name="ORDER[ODD_MONEY]" maxlength="6"
                                                                   class="text-xs-left">
                                                        </div>
                                                    </div>
                                                </div>
											<?php endif; ?>
											<? $i++; endforeach; ?>

                                    </div>
                                    <div class="col-xs-6">
										<?php if ($USER->IsAuthorized() && \COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED', '', SITE_ID) == 'Y'): ?>
                                            <div class="bonuses-block">
                                                <svg class="hidden-lg-down" version="1.1" id="Capa_1"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                                                     xml:space="preserve">
										<g>
                                            <g>
                                                <path d="M442.491,241.824l-15.808-27.088c-2.08-3.564-6.655-4.766-10.22-2.687c-3.564,2.08-4.768,6.656-2.687,10.22l10.158,17.406
													h-96.192l48.099-82.408l14.088,24.139c2.08,3.565,6.657,4.768,10.22,2.687c3.564-2.08,4.768-6.656,2.687-10.22l-19.712-33.777
													c-1.845-3.161-5.266-5.126-8.927-5.126H137.804c-3.661,0-7.082,1.964-8.926,5.126L69.511,241.821
													c-2.132,3.651-1.842,8.174,0.741,11.525l103.663,134.399c1.472,1.909,3.685,2.909,5.922,2.909c1.593,0,3.199-0.507,4.558-1.556
													c3.268-2.52,3.873-7.213,1.353-10.481l-95.64-123.998h101.311l49.223,195.168l-26.057-33.784
													c-2.519-3.266-7.213-3.873-10.481-1.352c-3.268,2.52-3.873,7.213-1.353,10.48l45.063,58.426c1.972,2.558,4.956,4.025,8.186,4.025
													c3.23,0,6.213-1.467,8.185-4.024L441.75,253.345C444.332,249.995,444.622,245.472,442.491,241.824z M362.827,149.915
													l-47.921,82.104l-46.136-82.104H362.827z M302.065,239.675h-92.13L256,157.696L302.065,239.675z M88.067,239.675l48.093-82.408
													l48.099,82.408H88.067z M149.173,149.915h94.057l-46.136,82.104L149.173,149.915z M256,449.569l-49.168-194.95h98.336L256,449.569
													z M271.358,449.789l49.223-195.169h101.311L271.358,449.789z"></path>
                                            </g>
                                        </g>
                                                    <g>
                                                        <g>
                                                            <path d="M256,24.418c-4.126,0-7.472,3.345-7.472,7.472v33.875c0,4.127,3.345,7.472,7.472,7.472s7.472-3.345,7.472-7.472V31.89
													C263.472,27.763,260.126,24.418,256,24.418z"></path>
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path d="M437.019,82.794c-2.918-2.917-7.649-2.917-10.567,0l-23.953,23.952c-2.918,2.919-2.918,7.649,0,10.568
													c1.459,1.458,3.371,2.188,5.283,2.188c1.912,0,3.825-0.73,5.284-2.188l23.953-23.952
													C439.937,90.443,439.937,85.713,437.019,82.794z"></path>
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path d="M504.528,256.34h-33.875c-4.127,0-7.472,3.345-7.472,7.472s3.346,7.472,7.472,7.472h33.875
													c4.127,0,7.472-3.345,7.472-7.472C512,259.685,508.654,256.34,504.528,256.34z"></path>
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path d="M41.347,256.34H7.472c-4.127,0-7.472,3.345-7.472,7.472s3.346,7.472,7.472,7.472h33.875c4.127,0,7.472-3.345,7.472-7.472
													C48.819,259.685,45.474,256.34,41.347,256.34z"></path>
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path d="M109.502,106.746L85.548,82.793c-2.918-2.917-7.649-2.917-10.567,0c-2.918,2.919-2.918,7.649,0,10.568l23.953,23.953
													c1.459,1.458,3.371,2.188,5.284,2.188c1.913,0,3.825-0.73,5.284-2.188C112.42,114.395,112.42,109.665,109.502,106.746z"></path>
                                                        </g>
                                                    </g>
									</svg>
                                                <div class="title"><?= GetMessage("my_bonuses"); ?></div>
                                                <div class="value"><?php echo number_format($_SESSION['BONUS_VALUE'], 0, '.', ' '); ?>
                                                    <span class="currency font-fix"><?= CURRENCY_FONT; ?></span></div>
                                                <div class="col-xs-12">
                                                    <div class="bd-input">
                                                        <label class="text-xl-center"><?= GetMessage("checkout_bonus_pay"); ?></label>
                                                        <input type="text" name="ORDER[DISCOUNT_BONUSES]">
                                                    </div>
                                                </div>
                                            </div>
										<?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row fields payment-col">
                            <div class="payment-footer">
                                <div class="">
                                    <div class="col-xs-12 nopad">
                                        <div class="order-total">
                                            <div class="summary-label basket-sum"><span><div><?= GetMessage("checkout_basket_sum"); ?></div></span>
                                                <span class="meta-value_ meta-value"><span><?= $_SESSION['basket_sum_native'] ?></span><span
                                                            class="currency"><?= CURRENCY_FONT; ?></span></span></div>
                                            <div class="summary-label delivery-sum" style="display:none;"><span><div><?= GetMessage("checkout_delivery_s"); ?></div></span>
                                                <span class="meta-value_ meta-value"><span></span><span
                                                            class="currency"><?= CURRENCY_FONT; ?></span></span></div>
                                            <div class="summary-label order-discount" style="display:none;"><span><div><?= GetMessage("checkout_discount"); ?></div></span>
                                                <span class="meta-value_ meta-value"><span><?php echo $_SESSION['DISCOUNT']; ?></span>%</span>
                                            </div>
                                            <div class="summary-label user-bonus-sum" style="display:none;"><span><div><?= GetMessage("checkout_bonus_used"); ?></div></span>
                                                <span class="meta-value_ meta-value"><span></span><span
                                                            class="currency"><?= CURRENCY_FONT; ?></span></span></div>
                                            <div class="summary-label user-bonus-append" style="display:none;"><span><div><?= GetMessage("checkout_bonus_append"); ?></div></span>
                                                <span class="meta-value_ meta-value"><span></span><span
                                                            class="currency"><?= CURRENCY_FONT; ?></span></span></div>
                                            <div class="summary-label order_sum_"><span><div><?= GetMessage("checkout_summ"); ?></div></span>
                                                <span class="meta-value_ order-sum font-fix"><span><?php echo $_SESSION['BASKET_SUM']; ?></span><span
                                                            class="currency"><?= CURRENCY_FONT; ?></span></span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <button type="submit"
                                                    class="send-order"><?= GetMessage("checkout_submit"); ?></button>
                                        </div>
                                        <div class="col-xs-6 checkout-min-order-label">
                                            <span><?= GetMessage('min_order_title') ?> <?php echo \COption::GetOptionString('bd.deliverypizza', 'BD_BASKET_MIN_ORDER', '', SITE_ID) ?>
                                                <span class="currency"><?= CURRENCY_FONT ?></span></span>
                                        </div>
                                    </div>
                                    <div class="order-confirm-text col-xs-12">
                                        <p>
											<?= GetMessage('fz_text'); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
	<?php else: ?>
        <main class="content container">
            <div class="content-page page-404 font-fix empty-items">
                <div class="status-title"><?= GetMessage("checkout_empty_basket"); ?></div>
            </div>
        </main>
	<?php endif; ?>
<?php } else { ?>
    <main class="content container">
        <div class="content-page page-404 font-fix empty-items">
            <div class="status-title"><?= GetMessage("soryan_eto_ne_dlya_odmenov"); ?></div>
        </div>
    </main>
<?php } ?>
