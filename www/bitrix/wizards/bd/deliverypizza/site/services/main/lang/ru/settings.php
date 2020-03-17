<?
$MESS["MAIN_OPT_DESCRIPTION"] = "Описание страницы";
$MESS["MAIN_OPT_KEYWORDS"] = "Ключевые слова";
$MESS["MAIN_OPT_TITLE"] = "Заголовок окна браузера";
$MESS["MAIN_OPT_KEYWORDS_INNER"] = "Продвигаемые слова";

$MESS["BD_ORDER_NAME"] = "Новый заказ";
$MESS["BD_ORDER_DESCRIPTION"] = "";
$MESS["BD_ORDER_SUBJECT"] = "Новый заказ на сайте #SITE_NAME#";
$MESS["BD_ORDER_BODY"] = "
<!DOCTYPE html>
<html>
<head>
	<meta charset=\"utf-8\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
	<title></title>        
</head>
    <body style=\"margin: 0; padding: 0; background-color: #3a393e;\">
    <link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400\" rel=\"stylesheet\"> 
        <center>
            <table  style=\"color: #292f32; max-width: 640px;min-width: 300px; font-family: 'Roboto Condensed','Verdana', sans-serif;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
            	<tr>
            		<td>
            			<table bgcolor=\"#3a393e\"  style=\"background-color: #3a393e; color: #fff; max-width: 640px;min-width: 300px; font-family: 'Roboto Condensed','Verdana', sans-serif;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">  
			            	<tr>
			            		<td height=\"20\"></td>
			            	</tr>            			    
			            	<tr>
			            		<td align=\"center\"><p style=\"font-size: 36px;padding: 0; margin: 0;\">Заказ ##ID#</p></td>
			            	</tr>
			            	<tr>
			            		<td align=\"center\"><p style=\"font-size: 14px;padding: 0; margin: 0;\">#ORDER_DATE#</p></td>
			            	</tr>
			            	<tr>
			            		<td height=\"20\"></td>
			            	</tr>			            	
            			</table>      			
            		</td>
            	</tr>
            	<tr>
            		<td>
            			<table bgcolor=\"#37b5c4\"  style=\"background-color: #37b5c4; color: #fff; max-width: 640px;min-width: 300px; border-radius: 5px 5px 0 0; font-family: 'Roboto Condensed','Verdana', sans-serif;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
			            	<tr>
			            		<td colspan=\"3\" height=\"20\"></td>
			            	</tr>             			
			            	<tr>
			            		<td width=\"30\"></td>
			            		<td rowspan=\"2\" width=\"100\"><img src=\"#ICON#\" alt=\"\"></td>
			            		<td><p style=\"font-size: 30px;padding: 0;margin: 0;\">#USER_NAME#</p></td>
			            	</tr>
	            			<tr>
	            				<td width=\"30\"></td>
	            				<td><p style=\"font-size: 20px;padding: 0;margin: 0;\">#USER_PHONE#</p></td>
	            			</tr>
			            	<tr>
			            		<td colspan=\"3\" height=\"20\"></td>
			            	</tr>  	            				            			
            			</table>
            		</td>
            	</tr>
            	<tr>
            		<td>
            			<table bgcolor=\"#fff\"  style=\"background-color: #fff; color: #292f32; border-bottom: 1px dashed #cccccc; max-width: 640px;min-width: 300px; font-family: 'Roboto Condensed','Verdana', sans-serif;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
            				<tr>
            					<td colspan=\"3\" height=\"20\"></td>
            				</tr>
            				<tr>
            					<td width=\"38\"></td>
            					<td>
            						                <p style=\"color: #37b5c4;padding: 0;margin: 0;font-size: 18px;\">Информация о доставке</p><br>
	            					                #DELIVERY_TYPE#
									#DELIVERY_CONFIG#
									#COMMENT#<br>
									#DELIVERY_TIME#
								</td>
								<td width=\"38\"></td>
            				</tr>
            				<tr>
            					<td colspan=\"3\" height=\"20\"></td>
            				</tr>            				
            			</table>
            		</td>            		
            	</tr>
            	<tr>
            		<td>
            			<table bgcolor=\"#fff\"  style=\"background-color: #fff; color: #292f32; max-width: 640px;min-width: 300px; font-family: 'Roboto Condensed','Verdana', sans-serif;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
            				<tr>
            					<td colspan=\"3\" height=\"20\"></td>
            				</tr>            			
            				<tr>
            					<td width=\"38\"></td>
            					<td>
            						<p style=\"color: #37b5c4;padding: 0;margin: 0;font-size: 18px;\">Информация об оплате</p><br>
	            					#PAYMENT_TYPE#
	            					#ODD_MONEY#
									
								</td>
								<td width=\"38\"></td>
            				</tr>
            				<tr>
            					<td colspan=\"3\" height=\"20\"></td>
            				</tr>            				
            			</table>
            		</td>            		
            	</tr>
            	<tr>
            		<td>
            			<table bgcolor=\"#fff\"  style=\"background-color: #fff; border-bottom: 1px solid #cccccc; color: #292f32; max-width: 640px;min-width: 300px; font-family: 'Roboto Condensed','Verdana', sans-serif;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
            				<tr>
            					<td colspan=\"3\" height=\"20\"></td>
            				</tr>            			
            				<tr>
            					<td width=\"38\"></td>
            					<td>
            						<p style=\"color: #37b5c4;padding: 0;margin: 0;font-size: 18px;\">Состав заказа</p>
								</td>
								<td width=\"38\"></td>
            				</tr>
            				<tr>
            					<td colspan=\"3\" height=\"20\"></td>
            				</tr>            				
            			</table>            			
            		</td>
            	</tr>
            	#BASKET_CONTENT#     	
            	<tr>
            		<td>
             			<table bgcolor=\"#fff\"  style=\"background-color: #fff; color: #292f32; max-width: 640px;min-width: 300px; font-family: 'Roboto Condensed','Verdana', sans-serif;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
            				<tr>
            					<td colspan=\"3\" height=\"20\"></td>
            				</tr>            			
            				<tr>
            					<td width=\"38\"></td>
            					<td>
            						<table bgcolor=\"#fdfcf3\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
	            						<tr>
	            							<td>
												<table bgcolor=\"#fdfcf3\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
													<tr>
														<td colspan=\"3\" height=\"20\"></td>
													</tr>
													<tr>
														<td width=\"30\"></td>
														<td>
				            								<p style=\"font-size: 16px;padding: 0;margin: 0;font-weight: 300;\">Сумма заказа:  <b style=\"font-size: 18px;font-weight: 400;\">#ORDER_SUM#</b></p>
															<p style=\"font-size: 16px;padding: 0;margin: 0;font-weight: 300;\">Стоимость доставки:  <b style=\"font-size: 18px;font-weight: 400;\">#DELIVERY_PRICE#</b></p>
															#PROMO_DISCOUNT#
                                                            #PICKUP_DISCOUNT#
															#BONUSES_DISCOUNT#
														</td>
														<td width=\"30\"></td>
													</tr>
													<tr>
														<td colspan=\"3\" height=\"10\"></td>
													</tr>													
													<tr>
														<td></td>
														<td bgcolor=\"#ccc\" height=\"1\"></td>
														<td></td>
													</tr>													
													<tr>
														<td colspan=\"3\" height=\"10\"></td>
													</tr>													
													<tr>
														<td width=\"30\"></td>
														<td>
				            								<p style=\"font-size: 24px;padding: 0;margin: 0;font-weight: 400;\">Итого: #ORDER_TOTAL#</p>
														</td>
														<td width=\"30\"></td>
													</tr>													
													<tr>
														<td colspan=\"3\" height=\"20\"></td>
													</tr>													
												</table>
	            							</td>
	            						</tr>
            						</table>									
								</td>
								<td width=\"38\"></td>
            				</tr>
            				<tr>
            					<td colspan=\"3\" height=\"20\"></td>
            				</tr>            				
            			</table>
            		</td>
            	</tr>
            	<tr>
            		<td>
            			<table bgcolor=\"#fff\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\" style=\"border-radius: 0 0 5px 5px;\">
            				<tr>
            					<td colspan=\"3\" height=\"20\"></td>
            				</tr>            			
            				<tr>
            					<td width=\"38\"></td>
            					<td align=\"center\">
            						<a style=\"background-color: #3f484d; color: #fff; text-decoration: none;padding:15px 0; width: 100%; display: block; border-radius: 5px;margin-bottom:15px;\" href=\"#SERVER_NAME_#/crm/#order-#ID#\">Посмотреть в CRM</a>								
								</td>
								<td width=\"38\"></td>
            				</tr>
            				<tr>
            					<td colspan=\"3\" height=\"40\"></td>
            				</tr>             				
            			</table>
            		</td>
            	</tr>
			</table>
					<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
        		<tr>
        			<td height=\"20\"></td>
        		</tr>
        	</table>
        </center>
    </body>
</html>";


$MESS["BD_ORDER_PAID_NAME"] = "Заказ оплачен";
$MESS["BD_ORDER_PAID_DESCRIPTION"] = "";
$MESS["BD_ORDER_PAID_SUBJECT"] = "Заказ оплачен на сайте #SITE_NAME# ";
$MESS["BD_ORDER_PAID_BODY"] = "
<!DOCTYPE html>
<html>
<head>
	<meta charset=\"utf-8\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
	<title></title>        
</head>
    <body style=\"margin: 0; padding: 0; background-color: #3a393e;\">
    <link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400\" rel=\"stylesheet\"> 
      <center>
        	<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
        		<tr>
        			<td height=\"20\"></td>
        		</tr>
        	</table>      
        <table bgcolor=\"#f8f8f8\"  style=\"background-color: #f8f8f8; color: #292f32; max-width: 640px;min-width: 300px; font-family: 'Roboto Condensed','Verdana', sans-serif;border-radius: 5px;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
      	<tr>
      		<td height=\"20\"></td>
      	</tr>
				<tr>
					<td align=\"center\"><p style=\"font-size: 24px;margin: 0;padding: 0;\">##ORDER_ID#</p></td>
				</tr>
				<tr>
					<td align=\"center\"><h3 style=\"font-size: 40px;font-weight: 400;margin: 0;padding: 0;\">Заказ оплачен</h3></td>
				</tr>
        	<tr>
        		<td height=\"20\"></td>
        	</tr>				
				<tr>
					<td>
						<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
							<tr>
								<td width=\"30\"></td>
								<td>
									<table bgcolor=\"#c2d259\"  style=\"background-color: #c2d259; color: #292f32; max-width: 640px;min-width: 300px; font-family: 'Roboto Condensed','Verdana', sans-serif;border-radius: 5px;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
										<tr>
											<td height=\"20\"></td>
										</tr>
										<tr>
											<td align=\"center\">
												<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
													<tr>
														<td width=\"20\"></td>
														<td align=\"center\">
															Состав заказа и информацию о клиенте вы можете посмотреть в CRM
														</td>
														<td width=\"20\"></td>
													</tr>
												</table>								
											</td>
										</tr>
										<tr>
											<td height=\"20\"></td>
										</tr>							
										<tr>
											<td align=\"center\">
												<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
													<tr>
														<td width=\"30\"></td>
														<td align=\"center\">
															<a style=\"background-color: #3f484d; color: #fff; text-decoration: none;padding:10px 20px;border-radius: 5px;display: block;\" href=\"#SERVER_NAME#/crm/#order-#ORDER_ID#\">Перейти в CRM</a>
														</td>
														<td width=\"30\"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height=\"30\"></td>
										</tr>
									</table>									

								</td>
								<td width=\"30\"></td>
							</tr>
						</table>
					</td>
				</tr>
			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
        		<tr>
        			<td height=\"30\"></td>
        		</tr>
        	</table>		
			</table>
   </center>
</body>
</html>
";


$MESS["BD_USER_RESET_PASSWORD_NAME"] = "Сброс пароля";
$MESS["BD_USER_RESET_PASSWORD_DESCRIPTION"] = "";
$MESS["BD_USER_RESET_PASSWORD_SUBJECT"] = "Сброс пароля на сайте #SITE_NAME# ";
$MESS["BD_USER_RESET_PASSWORD_BODY"] = "

<!DOCTYPE html>
<html>
<head>
	<meta charset=\"utf-8\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
	<title></title>        
</head>
    <body style=\"margin: 0; padding: 0; background-color: #3a393e;\">
    <link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400\" rel=\"stylesheet\"> 
        <center>
        	<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
        		<tr>
        			<td height=\"20\"></td>
        		</tr>
        	</table>
            <table bgcolor=\"#ff6665\"  style=\"background-color: #ff6665; color: #fff; max-width: 640px;min-width: 300px; font-family: 'Roboto Condensed','Verdana', sans-serif;border-radius: 5px;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
            	<tr><td height=\"30\"></td></tr>
                <tr>
                    <td align=\"center\" valign=\"top\"><img src=\"#SERVER_NAME_#lock.jpg\" alt=\"\"></td>
				</tr>
				<tr><td height=\"24\"></td></tr>				
				<tr>
					<td align=\"center\"><h3 style=\"font-size: 36px;font-weight: normal;line-height: normal;padding: 0;margin: 0;\">Забыли пароль?</h3></td>
				</tr>
				<tr><td height=\"15\"></td></tr>
				<tr>
					<td align=\"center\">
						<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
							<tr>
								<td width=\"15\"></td>
								<td align=\"center\"><p style=\"font-size: 18px; font-weight: 300;padding: 0;margin: 0;\">Вы запросили новый пароль для вашей  учетной записи на сайте #SITE_NAME# .</p></td>
								<td width=\"15\"></td>
							</tr>
						</table>					
					</td>
				</tr>
				<tr><td height=\"7\"></td></tr>				
				<tr>
					<td align=\"center\">
						<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
							<tr>
								<td width=\"15\"></td>
								<td align=\"center\"><p style=\"font-size: 18px; font-weight: 300;padding: 0;margin: 0;\">Если вы не используете этот код, пароль не будет изменен.</p></td>
								<td width=\"15\"></td>
							</tr>
						</table>					
					</td>
				</tr>
				<tr><td height=\"26\"></td></tr>				
				<tr>
					<td align=\"center\">ваш код</td>
				</tr>
				<tr><td height=\"7\"></td></tr>					
				<tr>
					<td>
						<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
							<tr>
								<td width=\"25%\"></td>
								<td width=\"50%\" bgcolor=\"#fff\" align=\"center\" style=\"color: #3f484d; font-size: 24px;border-radius: 5px;padding: 12px 0;\">#CODE#</td>
								<td width=\"25%\"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr><td height=\"40\"></td></tr>
			</table>
			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
				<tr>
					<td colspan=\"3\" height=\"13\"></td>
				</tr>
				<tr>
					<td width=\"15\"></td>
					<td align=\"center\"><p style=\"color: #ff6665;font-family: 'Roboto Condensed','Verdana', sans-serif;font-size: 16px;font-weight: 300;padding: 0;margin: 0;\">Чтобы отписаться от рассылки войдите в свой<br><a style=\"color: #ff6665\" href=\"#PROFILE_LINK#\">личный кабинет</a></p></td>
					<td width=\"15\"></td>
				</tr>
			</table>
			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\">
        		<tr>
        			<td height=\"20\"></td>
        		</tr>
        	</table>
        </center>
    </body>
</html>

";
?>