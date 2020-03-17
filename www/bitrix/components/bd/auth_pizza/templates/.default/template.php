<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
?>
<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
<div id="bonuses-info" class="bd-popup">
	<div class="col-xs-4">
		<img src="<?php echo SITE_TEMPLATE_PATH; ?>/images/bonuses-popover-icon.png" alt="">
	</div>
	<div class="col-xs-8">
		<div class="title"><?= GetMessage("promo_get_bonuses_title"); ?></div>
		<div class="description"><?= GetMessage("promo_get_bonuses_text"); ?></div>
	</div> 
</div>
<?php endif; ?>

<div id="auth"
     class="bd-popup <?php if ($USER->IsAuthorized()): ?>is_auth<?php endif; ?> <?php if (\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED', '', SITE_ID) != 'Y'): ?>bonuses-disabled<?php endif; ?>">
	<?php if (!$USER->IsAuthorized()): ?>
		<?php $mode = COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE','',SITE_ID); ?>
		<?php if ($mode == 'email'): ?>
			<div class="auth-tabs">
				<ul>
					<li class="active"><a  data-target="sign-in-email-state" href="#"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></a></li>
					<li><a href="#" data-target="sign-up-email-state"><?= GetMessage("auth_register"); ?></a></li>
				</ul>
			</div>
			<div class="auth-state sign-in-email-state">
				<form id="sign-in-email-form">
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="LOGIN"/>
					<input type="hidden" name="MODE" value="EMAIL"/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_email"); ?></label>
							<input type="text" name="EMAIL">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input type="password" name="PASSWORD">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></button>
					</div>
					<div class="bd-form-row"><a href="#" class="forgot">
							<span><?= GetMessage("AUTH_FORGOT_PASSWORD_2"); ?></span></a></div>
				</form>
			</div>
			<div class="auth-state sign-up-email-state">
				<form id="sign-up-email-form">
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="REGISTER"/>
					<input type="hidden" name="MODE" value="EMAIL"/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_email"); ?></label>
							<input type="text" name="EMAIL">
						</div>
					</div>
					<div class="bd-form-row input-row">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input type="password" name="PASSWORD">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password_again"); ?></label>
							<input type="password" name="PASSWORD2">
						</div>
					</div>
					<div class="bd-form-row">
						<div class="rules">
							<label class="label">
								<input type="checkbox" id="inp_agree">
								<label for="inp_agree"><span></span></label><span><?= GetMessage("auth_term_reg_1"); ?>
									<a data-modal="rules-modal" href="#"
									   class="md-trigger"><?= GetMessage("auth_term_reg_2"); ?></a></span>
							</label>
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button disabled="disabled" type="submit" class="btn"><?= GetMessage("auth_register_button"); ?></button>
					</div>
					
				</form>
			</div>
			<div class="auth-state forgot-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="EMAIL"/>
					<div class="bd-form-row">
						<div class="bd-input bordered">
							<label><?= GetMessage("auth_email"); ?></label>
							<input type="text" name="EMAIL" class="phone">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
				</form>
				<div class="state-info"><?= GetMessage("auth_send_code_desc_email"); ?></div>
			</div>
			<div class="auth-state phone-confirm-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="EMAIL"/>
					<input type="hidden" name="EMAIL" value=""/>
					<div class="bd-form-row">
						<div class="bd-input bordered">
							<label><?= GetMessage("auth_code"); ?></label>
							<input autocomplete="off" type="text" maxlength="4" name="REG_CONFIRM_CODE" class="phone">
						</div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
				</form>

			</div>
			<div class="auth-state set-new-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="EMAIL"/>
					<input type="hidden" name="EMAIL" value=""/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input type="password" name="NEW_PASSWORD" class="phone">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password_again"); ?></label>
							<input  name="NEW_PASSWORD_2" type="password" class="phone">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_change_password"); ?></button>
					</div>
				</form>
			</div>
		<?php else: ?>
			<div class="auth-tabs">
				<ul>
					<li class="active"><a  data-target="sign-in-default-state" href="#"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></a></li>
					<li><a href="#" data-target="sign-up-phone-state"><?= GetMessage("auth_register"); ?></a></li>
				</ul>
			</div>
			<div style="display:block;" class="auth-state sign-in-default-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="LOGIN"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_phone"); ?></label>
							<input type="text" name="PHONE" class="phone">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input type="password" name="PASSWORD" class="phone">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></button>
					</div>
					<div class="bd-form-row"><a href="#" class="forgot">
							<span><?= GetMessage("AUTH_FORGOT_PASSWORD_2"); ?></span></a></div>
				</form>
			</div>
			<div class="auth-state sign-up-phone-state">
				<form id="sms_reg">
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="REGISTER"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_phone"); ?></label>
							<input type="tel" name="PHONE" class="phone">
						</div>
					</div>
					<div class="bd-form-row input-row">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input name="PASSWORD" type="password">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password_again"); ?></label>
							<input name="PASSWORD2" type="password">
						</div>
					</div>
					<div class="bd-form-row">
						<div class="rules">
							<label class="label">
								<input type="checkbox" id="inp_agree">
								<label for="inp_agree"><span></span></label><span><?= GetMessage("auth_term_reg_1"); ?>
									<a data-modal="rules-modal" href="#"
									   class="md-trigger"><?= GetMessage("auth_term_reg_2"); ?></a></span>
							</label>
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button disabled type="submit" class="btn"><?= GetMessage("auth_get_code"); ?></button>
					</div>
				</form>
			</div>
			<div class="auth-state phone-confirm-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="REGISTER"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<input type="hidden" name="PHONE" value=""/>
					<input type="hidden" name="PASSWORD" value=""/>
					<div class="bd-form-row">
						<div class="bd-input bordered">
							<label><?= GetMessage("auth_code"); ?></label>
							<input autocomplete="off" maxlength="4" type="text" name="REG_CONFIRM_CODE" class="phone">
						</div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
				</form>
				<div class="resend-cont"><a href="#" class="code-resend">
						<span><?= GetMessage("auth_repeat_code"); ?></span></a>
					<div class="resend-status"><?= GetMessage("auth_repeat_code_desc"); ?> <span
							class="timer">0:59</span></div>
				</div>
			</div>
			<div class="auth-state forgot-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<div class="bd-form-row">
						<div class="bd-input bordered">
							<label><?= GetMessage("auth_phone"); ?></label>
							<input type="text" name="PHONE" class="phone">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
				</form>
				<div class="state-info"><?= GetMessage("auth_send_code_desc"); ?></div>
			</div>
			<div class="auth-state phone-confirm-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<input type="hidden" name="PHONE" value=""/>
					<div class="bd-form-row">
						<div class="bd-input bordered">
							<label><?= GetMessage("auth_code"); ?></label>
							<input autocomplete="off" type="text" maxlength="4" name="REG_CONFIRM_CODE" class="phone">
						</div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
				</form>
				<div class="resend-cont"><a href="#" class="code-resend">
						<span><?= GetMessage("auth_repeat_code"); ?></span></a>
					<div class="resend-status"><?= GetMessage("auth_repeat_code_desc"); ?> <span
							class="timer">0:59</span></div>
				</div>
			</div>
			<div class="auth-state set-new-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<input type="hidden" name="PHONE" value=""/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input type="password" name="NEW_PASSWORD" class="phone">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password_again"); ?></label>
							<input  name="NEW_PASSWORD_2" type="password" class="phone">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_change_password"); ?></button>
					</div>
				</form>
			</div>
		<?php endif; ?>

	<?php else: ?>
		<div
			class="auth-state logged-in-state <?php if (\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED', '', SITE_ID) != 'Y'): ?>bonuses-disabled<?php endif; ?>">
			<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
			<div class="bonuses">
				<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
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
			z M271.358,449.789l49.223-195.169h101.311L271.358,449.789z"/>
	</g>
</g>
<g>
	<g>
		<path d="M256,24.418c-4.126,0-7.472,3.345-7.472,7.472v33.875c0,4.127,3.345,7.472,7.472,7.472s7.472-3.345,7.472-7.472V31.89
			C263.472,27.763,260.126,24.418,256,24.418z"/>
	</g>
</g>
<g>
	<g>
		<path d="M437.019,82.794c-2.918-2.917-7.649-2.917-10.567,0l-23.953,23.952c-2.918,2.919-2.918,7.649,0,10.568
			c1.459,1.458,3.371,2.188,5.283,2.188c1.912,0,3.825-0.73,5.284-2.188l23.953-23.952
			C439.937,90.443,439.937,85.713,437.019,82.794z"/>
	</g>
</g>
<g>
	<g>
		<path d="M504.528,256.34h-33.875c-4.127,0-7.472,3.345-7.472,7.472s3.346,7.472,7.472,7.472h33.875
			c4.127,0,7.472-3.345,7.472-7.472C512,259.685,508.654,256.34,504.528,256.34z"/>
	</g>
</g>
<g>
	<g>
		<path d="M41.347,256.34H7.472c-4.127,0-7.472,3.345-7.472,7.472s3.346,7.472,7.472,7.472h33.875c4.127,0,7.472-3.345,7.472-7.472
			C48.819,259.685,45.474,256.34,41.347,256.34z"/>
	</g>
</g>
<g>
	<g>
		<path d="M109.502,106.746L85.548,82.793c-2.918-2.917-7.649-2.917-10.567,0c-2.918,2.919-2.918,7.649,0,10.568l23.953,23.953
			c1.459,1.458,3.371,2.188,5.284,2.188c1.913,0,3.825-0.73,5.284-2.188C112.42,114.395,112.42,109.665,109.502,106.746z"/>
	</g>
</g>
</svg>
				<div class="title"><?= GetMessage("my_bonuses"); ?></div>
				<div class="value"><?php echo number_format($_SESSION['BONUS_VALUE'], (substr_count($_SESSION['BONUS_VALUE'], '.') > 0) ? 2 : 0, '.', ' '); ?> <span class="currency font-fix"><?=CURRENCY_FONT;?></span></div>
			</div>
			<?php endif; ?>
			<nav>
				<ul>
					<li><a href="<?=SITE_DIR?>my/"><?= GetMessage("my_history"); ?></a></li>
					<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
					<li><a href="<?=SITE_DIR?>my/bonus/"><?= GetMessage("my_bonuses_page"); ?></a></li>
					<?php endif; ?>
					<li><a href="<?=SITE_DIR?>my/edit/"><?= GetMessage("my_profile"); ?></a></li>
					<li><a class="go-to-love" href="<?=SITE_DIR?>#section-whatIsLove"><?= GetMessage("my_love"); ?></a></li>
				</ul>
			</nav>
			<button onclick="window.location.href='?logout=yes'" class="exit-btn"><?= GetMessage("my_exit"); ?></button>
		</div>
	<?php endif; ?>
</div>
<div id="rules-modal" class="md-modal md-effect-1">
	<div class="md-content"><a href="#" class="md-close">
			<svg viewBox="0 0 129 129">
				<path
					d="M7.6,121.4c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2l51.1-51.1l51.1,51.1c0.8,0.8,1.8,1.2,2.9,1.2c1,0,2.1-0.4,2.9-1.2   c1.6-1.6,1.6-4.2,0-5.8L70.3,64.5l51.1-51.1c1.6-1.6,1.6-4.2,0-5.8s-4.2-1.6-5.8,0L64.5,58.7L13.4,7.6C11.8,6,9.2,6,7.6,7.6   s-1.6,4.2,0,5.8l51.1,51.1L7.6,115.6C6,117.2,6,119.8,7.6,121.4z"/>
			</svg>
		</a>
		<div class="title"><?= GetMessage("auth_agree_personal_information"); ?></div>
		<div class="rules-text-cont scrollbar-macosx">
			<noindex>
                <?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_CF_SHOP_COUNTRY', '', SITE_ID)!='ua'): ?>
<?= GetMessage("auth_inf_1"); ?> <?=\COption::GetOptionString('bd.deliverypizza', 'BD_PERSONAL_DATA_COMPANY_NAME','',SITE_ID);?> <?= GetMessage("auth_inf_2"); ?> <?=\COption::GetOptionString('bd.deliverypizza', 'BD_PERSONAL_DATA_COMPANY_ADDRESS','',SITE_ID);?><?= GetMessage("auth_inf_3"); ?> <?=$_SERVER['HTTP_HOST']?> <?= GetMessage("auth_inf_4"); ?><?=$_SERVER['HTTP_HOST']?> <?= GetMessage("auth_inf_5"); ?>
<?= GetMessage("auth_inf_6"); ?>
                <?php else: ?>
	                <?= GetMessage("auth_inf_1_ua"); ?> <?=$_SERVER['HTTP_HOST']?> <?= GetMessage("auth_inf_2_ua"); ?> <?=\COption::GetOptionString('bd.deliverypizza', 'BD_PERSONAL_DATA_COMPANY_NAME','',SITE_ID);?> <?=\COption::GetOptionString('bd.deliverypizza', 'BD_PERSONAL_DATA_COMPANY_ADDRESS','',SITE_ID);?><?= GetMessage("auth_inf_3_ua"); ?> <?=$_SERVER['HTTP_HOST']?> <?= GetMessage("auth_inf_4_ua"); ?><?=$_SERVER['HTTP_HOST']?> <?= GetMessage("auth_inf_5_ua"); ?>
                <?php endif; ?>
			</noindex>
		</div>
	</div>
</div>