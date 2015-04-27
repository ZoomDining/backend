<?php
use common\models\Menu;
use common\models\Orders;
use common\models\OrdersItems;
use common\models\RestaurantProfile;
use yii\helpers\Html;

$order_info = Orders::findOne($order_id);
$order_items = OrdersItems::find()->where("order_id =".$order_id)->all();
$restaurant_info = RestaurantProfile::findOne($order_info->restaurant_id);
$restaurant_image = $restaurant_info->getFileUrl("image");

$sum = 0;
$tax = 0;
if (!empty($order_items)) {
    foreach ((array)$order_items as $_info) {
        $sum += $_info->price * $_info->count;
        $tax = $_info->tax;
    }
}

$tax_price = ($sum/100)*$tax;
?>

<table width='260' style="border: 1px solid #000;">
    <tr>
        <td style="text-align:center;border-bottom:1px dotted #000;">
			<?php
			if(!empty($restaurant_image)){
			?>
            <p>
                <img src="<?= "http://".$_SERVER["HTTP_HOST"].$restaurant_image ?>" width="140" />
            </p>
			<?php
			}
			?>
            <p>
                <?= $restaurant_info->name ?>
            </p>

            <p style="vertical-align:top;">
                RM <span style="font-size:60px;line-height:45px;font-weight:bold;"><?= $sum ?></span>
            </p>
        </td>
    </tr>

    <tr>
        <td>
            <table style="border:0">
            <?php
            if (!empty($order_items)) {
                foreach ((array)$order_items as $_info) {
            ?>
                <tr>
                    <td>
                        <p>
                            <?= $_info->count; ?>x <?= Menu::findOne($_info->menu_id)->name; ?>
                        </p>
                        <!--
						<p>
                            <?= Menu::findOne($_info->menu_id)->description; ?>
                        </p>
						-->
                    </td>
                    <td style="vertical-align:top; width: 25%;">
                        <p>
                            RM <?= $_info->price; ?>
                        </p>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
                <tr>
                    <td>
                        <p>
                            Subtotal
                        </p>
                    </td>
                    <td style="vertical-align:top;">
                        <p>
                            RM <?= $sum ?>
                        </p>
                    </td>
                </tr>

                <?php if(!empty($tax)){ ?>
                    <tr>
                        <td>
                            <p>
                                Tax (<?= $tax ?>)
                            </p>
                        </td>
                        <td style="vertical-align:top;">
                            <p>
                                RM <?= $tax_price; ?>
                            </p>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td>
                        <p>
                            Total
                        </p>
                    </td>
                    <td style="vertical-align:top;">
                        <p>
                            RM <?= $sum+$tax_price ?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="text-align:center;border-top:1px dotted #000;">
            <?php if($restaurant_info->show_location){ ?>
                <p>
                    <?= $restaurant_info->address ?>

                    <?= $restaurant_info->city ?>

                    <?= $restaurant_info->postcode ?>
                </p>
            <?php } ?>

            <p>
                <?= $restaurant_info->name ?>
            </p>
            <p>
                <?= $restaurant_info->policy ?>
            </p>
            <p>
                This transaction was made<br />through Zoom dining
            </p>
        </td>
    </tr>
    <tr>
        <table style="border:0;border-top:1px dotted #000;width:100%;">
            <tr>
                <td>
                   <p>
                        Credit Card
                    </p>
                </td>
                <td style="text-align:right;">
                    <p>
                        <?= date("m/d/y h:i A", $order_info->date)?>
                    </p>
                </td>
            </tr>
			<tr>
				<td colspan="2" style="text-align:center;"><?= $restaurant_info->website ?></td>
			</tr>
        </table>
    </tr>
</table>
