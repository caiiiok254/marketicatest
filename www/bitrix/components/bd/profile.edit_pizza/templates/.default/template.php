<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="profile-content col-xs-12 padt0">
	<form action="" method="post">
		<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-6">
			<input type="hidden" name="USER[ID]" value="<?php echo $arResult['USER']['ID']; ?>">
			<div class="row">
				<div class="col-xs-8">
					<div class="bd-input <?php if (!empty($arResult['USER']['NAME'])): ?>filled<?php endif; ?>">
						<label class="text-xs-left"><?= GetMessage("profile_name"); ?></label>
						<input type="text" class="text-xs-left" name="USER[NAME]"
						       value="<?php echo $arResult['USER']['NAME']; ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<div class="bd-input <?php if (!empty($arResult['USER']['BIRTHDAY'])): ?>filled<?php endif; ?>">
						<label class="text-xs-left"><?= GetMessage("profile_birthday"); ?></label>
						<input type="text" maxlength="10" class="text-xs-left" name="USER[BIRTHDAY]"
						       value="<?php echo $arResult['USER']['BIRTHDAY']; ?>">
					</div>
				</div>
			</div>
			<?php if (COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE', '', SITE_ID) == 'sms'): ?>
				<div class="row">
					<div class="col-xs-8">
						<div class="bd-input <?php if (!empty($arResult['USER']['EMAIL'])): ?>filled<?php endif; ?>">
							<label class="text-xs-left"><?= GetMessage("profile_email"); ?></label>
							<input type="text" class="text-xs-left" name="USER[EMAIL]"
							       value="<?php echo $arResult['USER']['EMAIL']; ?>">
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="row">
					<div class="col-xs-8">
						<div
							class="bd-input <?php if (!empty($arResult['USER']['PHONE']) && $arResult['USER']['PHONE'] !== PHONE_CODE): ?>filled<?php endif; ?>">
							<label class="text-xs-left"><?= GetMessage("profile_phone"); ?></label>
							<input type="text" class="text-xs-left" name="USER[PHONE]"
							       value="<?php echo (!empty($arResult['USER']['PHONE']) && $arResult['USER']['PHONE'] !== PHONE_CODE) ? $arResult['USER']['PHONE'] : ''; ?>">
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-6 notify-config-block">
			<?php if (COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE', '', SITE_ID) == 'sms'): ?>

				<div class="row profile-phone">
					<div class="col-xl-12 col-lg-12 col-sm-6 col-md-4 col-xs-6">
						<div class="current-phone"><?php echo $arResult['USER']['PHONE']; ?></div>
						<div
							class="change-phone"><?= GetMessage("profile_text_change_phone"); ?><?php echo \COption::GetOptionString('bd.deliverypizza', 'BD_SITE_PHONE', '', SITE_ID) ?></div>
					</div>
				</div>
			<?php endif; ?>

			<?php if (COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE', '', SITE_ID) == 'email'): ?>

				<div class="row profile-phone">
					<div class="col-xl-3 col-lg-3 col-sm-6 col-md-4 col-xs-6">
						<div class="current-phone"><?php echo $arResult['USER']['EMAIL']; ?></div>
						<div
							class="change-phone"><?= GetMessage("profile_text_change_email"); ?><?php echo \COption::GetOptionString('bd.deliverypizza', 'BD_SITE_PHONE', '', SITE_ID) ?></div>
					</div>
				</div>
			<?php endif; ?>

			<div class="row notify-config">
				<div class="col-xs-12">
					<input type="hidden" name="USER[NOTIFY_SMS]"
					       value="<?php echo $arResult['USER']['NOTIFY_SMS']; ?>"/>
					<input type="hidden" name="USER[NOTIFY_EMAIL]"
					       value="<?php echo $arResult['USER']['NOTIFY_EMAIL']; ?>"/>
					<div class="bd-checkbox">
						<input id="NOTIFY_SMS"
						       type="checkbox" <?php if ($arResult['USER']['NOTIFY_SMS'] == 1): ?> checked <?php endif; ?>
						       data-target="NOTIFY_SMS">
						<label for="NOTIFY_SMS"><span><?= GetMessage("profile_get_sms"); ?></span>
						</label>
					</div>
					<div class="bd-checkbox">
						<input
							id="NOTIFY_EMAIL" <?php if ($arResult['USER']['NOTIFY_EMAIL'] == 1): ?> checked <?php endif; ?>
							type="checkbox"
							data-target="NOTIFY_EMAIL">
						<label for="NOTIFY_EMAIL">
							<span><?= GetMessage("profile_get_email"); ?></span>
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row address-list-container">
			<div class="title col-xs-12"><?= GetMessage("addresses_title"); ?></div>
			<div class="address-list row">
				<?php foreach ($arResult['USER']['ADDRESSES'] as $address): ?>
					<div class="address-item col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="hidden" class="to_delete" name="ADDRESS[<?php echo $address['ID']; ?>][TO_DELETE]"
						       value="0"/>
						<div class="row sub-row">
							<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-xs-6">
								<div class="bd-input <?php if (!empty($address['NAME'])): ?>filled <?php endif; ?>">
									<label class="text-xs-left"><?= GetMessage("profile_address_name"); ?></label>
									<input readonly type="text" name="ADDRESS[<?php echo $address['ID']; ?>][NAME]"
									       value="<?php echo $address['NAME']; ?>" class="text-xs-left">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-xs-6">
								<a href="#"
								   class="address-button edit-address closed_field"><?= GetMessage("profile_edit_adress"); ?></a>
								<div class="opened_field">
									<a href="#" class="remove-address"><?= GetMessage("profile_delite_adress"); ?></a>
								</div>
							</div>
						</div>
						<div class="row sub-row opened_field">
							<?php if (count($arResult["DESTRICT"]) > 0): ?>
								<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-xs-6">
									<div class="bd-select">
										<div class="label"><?= GetMessage("profile_destrict"); ?></div>
										<select name="ADDRESS[<?php echo $address['ID']; ?>][DISTRICT_ID]"
										        class="cs-select cs-skin-slide">
											<option value="null"><?= GetMessage("profile_destrict"); ?></option>
											<?php foreach ($arResult["DESTRICT"] as $d): ?>
												<option
													<?php if ($address['DISTRICT_ID'] == $d['ID']): ?>selected<?php endif; ?>
													value="<?php echo $d['ID']; ?>"><?php echo $d['NAME']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php endif; ?>
							<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-xs-6">
								<div class="bd-input <?php if (!empty($address['STREET'])): ?>filled <?php endif; ?>">
									<label class="text-xs-left"><?= GetMessage("profile_street"); ?></label>
									<input type="text" name="ADDRESS[<?php echo $address['ID']; ?>][STREET]"
									       value="<?php echo $address['STREET']; ?>" class="text-xs-left">
								</div>
							</div>
						</div>
						<div class="row sub-row opened_field">

							<div class="col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4">
								<div class="bd-input <?php if (!empty($address['HOUSE'])): ?>filled <?php endif; ?>">
									<label class="text-xs-left"><?= GetMessage("profile_home"); ?></label>
									<input type="text" class="text-xs-left"
									       name="ADDRESS[<?php echo $address['ID']; ?>][HOUSE]"
									       value="<?php echo $address['HOUSE']; ?>">
								</div>
							</div>
							<div
								class="col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4 nopadl not_private_house_fields" <?php if ($address['IS_PRIVATE'] == 'Y'): ?> style="display: none;" <?php endif; ?>>
								<div
									class="bd-input <?php if (!empty($address['APARTMENT'])): ?>filled <?php endif; ?>">
									<label class="text-xs-left"><?= GetMessage("profile_appartment"); ?></label>
									<input type="text" class="text-xs-left"
									       name="ADDRESS[<?php echo $address['ID']; ?>][APARTMENT]"
									       value="<?php echo $address['APARTMENT']; ?>">
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4 nopadl address_private">
								<div class="bd-checkbox">
									<input name="ADDRESS[<?php echo $address['ID']; ?>][IS_PRIVATE]" value="Y"
									       id="PRIVATE_<?php echo $address['ID']; ?>"
									       type="checkbox" <?php if ($address['IS_PRIVATE'] == 'Y'): ?> checked <?php endif; ?>
									       data-target="PRIVATE_<?php echo $address['ID']; ?>">
									<label
										for="PRIVATE_<?php echo $address['ID']; ?>"><span><?= GetMessage("private_house"); ?></span>
									</label>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="address-template_" style="display: none;">

				<div class="address-item col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12 opened">
					<div class="clearfix"></div>
					<input type="hidden" class="to_delete" name="NEW_ADDRESS[TO_DELETE][]" value="0"/>
					<div class="row sub-row">
						<div class="col-xs-6">
							<div class="bd-input">
								<label class="text-xs-left"><?= GetMessage("profile_address_name"); ?></label>
								<input type="text" class="text-xs-left" name="NEW_ADDRESS[NAME][]">
							</div>
						</div>
						<div class="col-xs-6"><a href="#"
						                         class="remove-address"><?= GetMessage("profile_delite_adress"); ?></a>
						</div>
					</div>
					<div class="row sub-row">
						<?php if (count($arResult["DESTRICT"]) > 0): ?>
							<div class="col-xs-6">
								<div class="bd-select">
									<div class="label"><?= GetMessage("profile_destrict"); ?></div>
									<select name="NEW_ADDRESS[DISTRICT_ID][]" class="cs-select cs-skin-slide">
										<option value="null"><?= GetMessage("profile_destrict"); ?></option>
										<?php foreach ($arResult["DESTRICT"] as $d): ?>
											<option value="<?php echo $d['ID']; ?>"><?php echo $d['NAME']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						<?php endif; ?>
						<div class="col-xs-6">
							<div class="bd-input">
								<label class="text-xs-left"><?= GetMessage("profile_street"); ?></label>
								<input type="text" class="text-xs-left" name="NEW_ADDRESS[STREET][]">
							</div>
						</div>
					</div>
					<div class="row sub-row">

						<div class="col-xs-4">
							<div class="bd-input">
								<label class="text-xs-left"><?= GetMessage("profile_home"); ?></label>
								<input type="text" class="text-xs-left" name="NEW_ADDRESS[HOUSE][]">
							</div>
						</div>
						<div class="col-xs-4 nopadl not_private_house_fields">
							<div class="bd-input">
								<label class="text-xs-left"><?= GetMessage("profile_appartment"); ?></label>
								<input type="text" class="text-xs-left" name="NEW_ADDRESS[APARTMENT][]">
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4 nopadl address_private">
							<div class="bd-checkbox">
								<input name="NEW_ADDRESS[IS_PRIVATE][]" value="Y" id="PRIVATE_"
								       type="checkbox" data-target="PRIVATE_">
								<label for="PRIVATE_"><span><?= GetMessage("private_house"); ?></span>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-10"><a href="#"
			                          class="address-button add-address"><?= GetMessage("profile_add_adress"); ?></a>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="col-xs-6">
					<button type="submit" class="save-profile"><?= GetMessage("profile_save"); ?></button>
				</div>
			</div>
		</div>
	</form>
</div>