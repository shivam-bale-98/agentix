<?php defined("C5_EXECUTE") or die("Access Denied.");
$ih = new \Application\Concrete\Helpers\ImageHelper();
$thumbnail = "";
?>












<?php if (!empty($list_items)) { ?>
    <section class="our-team-section des-team-area pb-200 <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?>">
        <div class="container container-1750">
            <div class="row">
                <div class="col-xl-12">
                    <div class="des-team-wrap">
                        <?php foreach ($list_items as $list_item_key => $list_item) { ?>
                            <div class="des-team-item-box active hover-reveal-item p-relative">
                                <a href="" class="pointer-events-none cursor-default">
                                    <div class="des-team-item d-flex align-items-center justify-content-between">
                                        <?php if (isset($list_item["date"]) && trim($list_item["date"]) != "") { ?>

                                            <span><?php echo h($list_item["date"]); ?></span>
                                        <?php } ?>
                                        <?php if (isset($list_item["name"]) && trim($list_item["name"]) != "") { ?>

                                            <h4 class="des-team-title"><?php echo h($list_item["name"]); ?></h4>
                                        <?php } ?>
                                        <?php if (isset($list_item["designation"]) && trim($list_item["designation"]) != "") { ?>

                                            <span><?php echo h($list_item["designation"]); ?></span>
                                        <?php } ?>

                                    </div>
                                </a>
                                <?php if ($list_item["image"]) { 
                                  $thumbnail = $ih->getThumbnail($list_item["image"], 600, 800);    
                                ?>
                                    <div class="des-team-reveal-img bg-cover bg-center" data-background="<?php echo $thumbnail ?>"></div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>