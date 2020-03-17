<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
use Bd\Deliverypizza\Models;
?>

<div class="profile-content order-history">
            <div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
	            <?php if(count($arResult['ORDERS'])>0): ?>
                <table class="order-history-table">
                  <thead>
                    <tr>
                      <td><?= GetMessage("history_date"); ?></td>
                      <td><?= GetMessage("history_order"); ?></td>
                      <td><?= GetMessage("history_summ"); ?></td>
                      <td><?= GetMessage("history_status"); ?></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($arResult['ORDERS'] as $order): ?>
                    <tr class="complete">
                      <td class="order-date"><?php echo date('d.m.Y',$order['ORDER_DATE']); ?></td>
                      <td>
                        <?php
                          $basket = unserialize($order['BASKET_CONTENT']);
                          $m = new Bd\Deliverypizza\Models\Basket();
                          $products = $m->getBasketContentForHistory($basket);
                        ?>
                        <a href="#" data-handler="popover" data-target="#history-pop<?php echo $order['ID']; ?>" data-id="history-pop<?php echo $order['ID']; ?>" class="order-detail-btn"><?php echo formatLabel(count($basket),array(GetMessage("quantity"),GetMessage("quantitys"),GetMessage("quantitys_2"))); ?></a>
                        <div class="webui-popover-content" id="history-pop<?php echo $order['ID']; ?>">
	                        <div class="bd-scrollbar scrollbar-macosx history_content_popover">
						   <table class="product-list">
                          <?php foreach($products['products'] as $prod): ?>
                              <?php if(!empty($prod['NAME'])): ?>
                                <tr>
	                              <td class="prod-image"><img src="<?=$prod['IMAGE'];?>"></td>
                                  <td class="name">
                                      <div><a data-modal="product-detail" href="#" <?php if(!in_array($prod['ID'],$products['ids'])): ?>class="without_info" onclick="return false;"<?php else: ?> onclick="getProductDetail(<?php echo $prod['ID'] ?>); return false;" class="md-trigger"  <?php endif; ?>><?php echo $prod['NAME'] ?></a></div>
                                      <div class="section"><?php echo $prod['SECTION']; ?></div>
                                  </td>
                                  <td class="amount"><?php echo $prod['AMOUNT']; ?> <?= GetMessage("history_col"); ?></td>
                                  <td class="local_sum">
                                    <?php echo number_format($prod['LOCAL_SUM'],0 ,'.',' '); ?><span class="currency font-fix"><?=CURRENCY_FONT; ?></span>
                                  </td>
                                  
                                </tr>
                              <?php endif; ?>
                          <?php endforeach; ?>

                        </table>
	                        </div>
						</div>
                        </td>
                      <td><?php echo number_format($order['ORDER_SUM'],0 ,'.',' '); ?><span class="currency font-fix"><?=CURRENCY_FONT; ?></span></td>
                      <td class="order-status">
	                      <div style="background-color: <?php echo Models\Order::$statuses[$order['STATUS']]['color']; ?>;"><?php echo Models\Order::$statuses[$order['STATUS']]['name']; ?></div></td>
                      <td>
                        <?php if($order['STATUS']==4): ?>
                          <a href="/payment-init.php?order=<?php echo $order['ID']; ?>" class="repay-btn"><?= GetMessage("history_repay"); ?></a>
                        <?php else: ?>
                        <a href="#" class="reorder-btn" data-id="<?php echo $order['ID']; ?>"><?= GetMessage("history_repeat"); ?></a>
                        <?php endif; ?>
                      </td>
                    </tr>

                  <?php endforeach; ?>
                  </tbody>
                </table>
                <?php else: ?>
                <div class="col-xs-12">
                  <div class="has-not-orders"><?= GetMessage("history_dont_have"); ?></div>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

