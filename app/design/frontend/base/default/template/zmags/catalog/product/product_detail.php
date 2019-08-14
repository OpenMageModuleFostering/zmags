<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    design
 * @package     base_default
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

/**
 * Product view template
 *
 * @see Mage_Catalog_Block_Product_View
 * @see Mage_Review_Block_Product_View
 */
?>

<style type="text/css">
    .fb-like {
        position: relative;
        top: 1px;
        width: 107px;
        z-index: 500;
    }

    .zmags-main {
     text-align: left;
    }

    .zmags-main #zmags_product{
        width: 100%;
        /*background: url("/js/tnma/zmags/images/bkg_product-view.gif") no-repeat scroll 100% 0 #FFFFFF; */
    }


    #zmags_product .product-img-box {
        float: left;
        width: 267px;
        padding: 1px;;
    }


    #zmags_product .product-view .product-img-box .product-image-zoom,  #zmags_product.product-view .product-img-box .product-image {
        height: 265px;
        overflow: hidden;
        position: relative;
        width: 265px;
        z-index: 9;
    }





    #zmags_product .product-view .product-img-box .product-image {
        margin: 0 0 13px;
    }

    #zmags_product .product-collateral{
        clear: both;
        padding: 25px;
        width: 100%;
        float: left;
    }

    #zmags_product.product-view .short-description{
        display: block;
    }


    .product-view .product-shop {float: right;width: 274px;text-align: left;}
    product-options-wrapper{clear: both;}
    .zmags-main{overflow: hidden;background: #fff;}
    product-options-wrapper{width: auto;}
    #product-options-wrapper dl{overflow: hidden;}
    .product-options dd select{width: 85%;}
    .product-collateral{clear: both;}
    .product-essential{overflow: hidden;height: auto;}
    .product-view .product-shop .add-to-links{clear: both;}
    .add-to-box,.add-to-cart,.product-shop{overflow: hidden;}
    .short-description{clear: both;}
    .product-shop .product-options-bottom .price-box{float: left;}
    .product-view .product-shop .add-to-links li .separator{display: none;}

    .product-view{border: none;}




    body { background:#fff; padding:20px; }




</style>
<?php $_helper = $this->helper('catalog/output'); ?>
<?php $_product = $this->getProduct(); ?>
<script type="text/javascript">
    var optionsPrice = new Product.OptionsPrice(<?php echo $this->getJsonConfig() ?>);
</script>

<!-- facebook -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<!--// facebook end -->

<div id="messages_product_view"><?php echo $this->getMessagesBlock()->getGroupedHtml() ?></div>
<div id="zmags_product" class="product-view">
<div class="product-essential">

<?php $isSecure = Mage::app()->getStore()->isCurrentlySecure(); ?>

<form action="<?php echo $this->getSubmitUrl($_product,array('_secure'=>$isSecure)) ?>" method="post" id="product_addtocart_form"<?php if($_product->getOptions()): ?> enctype="multipart/form-data"<?php endif; ?>>
    <div class="no-display">
        <input type="hidden" name="product" value="<?php echo $_product->getId() ?>" />
        <input type="hidden" name="related_product" id="related-products-field" value="" />
    </div>

    <div class="product-shop">
        <div class="product-name">
            <h1><?php echo $_helper->productAttribute($_product, $_product->getName(), 'name') ?></h1>
        </div>

        <?php if ($this->canEmailToFriend()): ?>
            <p class="email-friend"><a href="<?php echo $this->helper('catalog/product')->getEmailToFriendUrl($_product) ?>"><?php echo $this->__('Email to a Friend') ?></a></p>
        <?php endif; ?>

        <?php echo $this->getReviewsSummaryHtml($_product, false, true)?>
        <?php echo $this->getChildHtml('alert_urls') ?>
        <?php echo $this->getChildHtml('product_type_data') ?>
        <?php echo $this->getTierPriceHtml() ?>
        <?php echo $this->getChildHtml('extrahint') ?>

        <?php if (!$this->hasOptions()):?>
            <div class="add-to-box">
                <?php if($_product->isSaleable()): ?>
                    <?php echo $this->getChildHtml('addtocart') ?>
                    <?php if( $this->helper('wishlist')->isAllow() || $_compareUrl=$this->helper('catalog/product_compare')->getAddUrl($_product)): ?>
                        <span class="or"><?php echo $this->__('OR') ?></span>
                    <?php endif; ?>
                <?php endif; ?>
                <?php echo $this->getChildHtml('addto') ?>
            </div>
            <?php echo $this->getChildHtml('extra_buttons') ?>
        <?php elseif (!$_product->isSaleable()): ?>
            <div class="add-to-box">
                <?php echo $this->getChildHtml('addto') ?>
            </div>
        <?php endif; ?>

        <?php if ($_product->getShortDescription()):?>
            <div class="short-description">
                <!--twitter -->
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $_product->getProductUrl() ?>" data-dnt="true">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                <!--// twitter end -->

                <!-- facebook -->
                <div class="fb-like" data-href="<?php echo $_product->getProductUrl() ?>" data-send="false" data-layout="button_count" data-width="107" data-show-faces="false"></div>
                <!--// facebook end -->

                <!-- pinterest -->
                <a data-pin-config="beside" href="//pinterest.com/pin/create/button/?url=<?php echo ($_product->getProductUrl());?>%2Fphotos%2Fkentbrew%2F6851755809%2F&media=<?php echo urlencode( $this->helper('catalog/image')->init($_product, 'image') ); ?>&description=<?php echo urlencode($_helper->productAttribute($_product, $_product->getName(), 'name')) ?>" data-pin-do="buttonPin" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
                <!--// pinterest end -->

                <h2><?php echo $this->__('Quick Overview') ?></h2>
                <div class="std"><?php echo $_helper->productAttribute($_product, nl2br($_product->getShortDescription()), 'short_description') ?></div>

            </div>
        <?php endif;?>

        <?php echo $this->getChildHtml('other');?>

        <?php if ($_product->isSaleable() && $this->hasOptions()):?>
            <?php echo $this->getChildChildHtml('container1', '', true, true) ?>
        <?php endif;?>

    </div>

    <div class="product-img-box">
        <?php echo $this->getChildHtml('media') ?>
    </div>

    <div class="clearer"></div>
    <?php if ($_product->isSaleable() && $this->hasOptions()):?>
        <?php echo $this->getChildChildHtml('container2', '', true, true) ?>
    <?php endif;?>
</form>
<script type="text/javascript">
    //<![CDATA[
    var productAddToCartForm = new VarienForm('product_addtocart_form');
    productAddToCartForm.submit = function(button, url) {
        if (this.validator.validate()) {
            var form = this.form;
            var oldUrl = form.action;

            if (button && button != 'undefined') {
                button.disabled = true;
            }

            if (url) {
                form.action = url;
            }
            var e = null;
            //Start of our new ajax code
            if(!url){
                url = jQuery('#product_addtocart_form').attr('action');
            }
            var data = jQuery('#product_addtocart_form').serialize();
            data += '&isAjax=1';
            var qty = jQuery('#qty').val();


            jQuery('#ajax_loader').show();



            try {
                //zmags analytics
                top.____win.addToCart(
                    {
                        product_id: '<?php echo $_product->getId();?>',
                        name: "<?php echo $_helper->productAttribute($_product, $_product->getName(), 'name') ?>",
                        price: "<?php echo sprintf("%0.2f",$_product->getFinalPrice());?>"

                    },
                    qty

                );

                jQuery.ajax({
                    url: url,
                    dataType: 'json',
                    type : 'post',
                    data: data,
                    success: function(data){

                        jQuery('#ajax_loader').hide();
                        //alert(data.status + ": " + data.message);

                        jQuery('#modal_body').html('<div class="alert alert-success">'+data.message+'</div>');

                        //show modal conformation that product has been added to cart
                        jQuery('#myModal').modal('show');


                        jQuery('#myModal').on('hide', function () {

                            top.____win.close();
                            //close zmags lightbox
                            top.zmagsLightbox.$.colorbox.close();

                        });

                        if (button && button != 'undefined') {
                            button.disabled = false;
                        }


                    }
                });
            } catch (e) {
                alert('We are unable to process your request at this moment.');
                jQuery('#ajax_loader').hide();

            }
            //End of our new ajax code

            /*try {
             this.form.submit();
             } catch (e) {
             } */

            this.form.action = oldUrl;
            if (e) {
                throw e;
            }


        }
    }.bind(productAddToCartForm);

    productAddToCartForm.submitLight = function(button, url){
        if(this.validator) {
            var nv = Validation.methods;
            delete Validation.methods['required-entry'];
            delete Validation.methods['validate-one-required'];
            delete Validation.methods['validate-one-required-by-name'];
            // Remove custom datetime validators
            for (var methodName in Validation.methods) {
                if (methodName.match(/^validate-datetime-.*/i)) {
                    delete Validation.methods[methodName];
                }
            }

            if (this.validator.validate()) {
                if (url) {
                    this.form.action = url;
                }
                this.form.submit();
            }
            Object.extend(Validation.methods, nv);
        }
    }.bind(productAddToCartForm);


    jQuery('#show-cart').click(function(e){
        e.preventDefault();
        top.location.href= this.href;
    });

    jQuery(document).ready(function(){

        //zmags analytics
        top.____win.open({
            product_id: '<?php echo $_product->getId();?>',
            name: "<?php echo $_helper->productAttribute($_product, $_product->getName(), 'name') ?>",
            price: "<?php echo sprintf("%0.2f",$_product->getFinalPrice());?>"
        });





    });



    jQuery(".rating-links a").click(function(e) {
        e.preventDefault();
        top.location.href= this.href;
    });

    jQuery(".no-rating a").click(function(e) {
        e.preventDefault();
        top.location.href= this.href;
    });


    jQuery(".email-friend a").click(function(e) {
        e.preventDefault();
        top.location.href= this.href;
    });






    //]]>
</script>
</div>


<div class="product-collateral">
    <?php foreach ($this->getChildGroup('detailed_info', 'getChildHtml') as $alias => $html):?>
        <div class="box-collateral <?php echo "box-{$alias}"?>">
            <?php if ($title = $this->getChildData($alias, 'title')):?>
                <h2><?php echo $this->escapeHtml($title); ?></h2>
            <?php endif;?>
            <?php echo $html; ?>
        </div>
    <?php endforeach;?>
    <?php echo $this->getChildHtml('upsell_products') ?>
    <?php echo $this->getChildHtml('product_additional_data') ?>
</div>


</div>


<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">

        <h3 id="myModalLabel">Add To Cart</h3>
    </div>
    <div id="modal_body" class="modal-body">

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

        <a id="show-cart" target="_parent" style="text-decoration: none;" href="<?php echo $this->getUrl('checkout/cart')?>" class="btn">View Cart</a>
    </div>
</div>

<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
