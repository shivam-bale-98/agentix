<?php defined("C5_EXECUTE") or die("Access Denied."); ?>















<div class="tp-portfolio-details-1-ptb pb-100 <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?>">
	<div class="container container-1430">
		<div class="row">
			<div class="col-lg-6">
				<div class="tp-portfolio-details-1-heading">
					<?php if (isset($subtitle) && trim($subtitle) != "") { ?>

						<span class="tp-portfolio-details-1-sub tp_fade_anim" data-delay=".3"><?php echo h($subtitle); ?></span>
					<?php } ?>

					<?php if (isset($title) && trim($title) != "") { ?>
						<h3 class="tp-portfolio-details-1-title tp_fade_anim" data-delay=".5">
							<?php echo h($title); ?>
						</h3>
					<?php } ?>

					<div class="tp-portfolio-details-1-btn tp_fade_anim" data-delay=".7">
						<?php
						if (trim($link_URL) != "") { ?>
							<?php
							$link_Attributes = [];
							$link_Attributes['href'] = $link_URL;
							if (in_array($link, ['url', 'relative_url'])) {
								$link_Attributes['target'] = '_blank';
							}
							$link_AttributesHtml = join(' ', array_map(function ($key) use ($link_Attributes) {
								return $key . '="' . $link_Attributes[$key] . '"';
							}, array_keys($link_Attributes)));
							echo sprintf('<a  class="tp-portfolio-details-btn" %s>%s
	                            <span>
									<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
										<path d="M1 9L9 1M9 1H1M9 1V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
									</svg>
								</span>
	                        </a>', $link_AttributesHtml, $link_Title); ?>
						<?php } ?>

					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="tp-portfolio-details-1-content">
					<?php if (isset($description_1) && trim($description_1) != "") { ?>
						<?php echo $description_1; ?>
					<?php } ?>
				
					<?php if (!empty($features_items)) { ?>
						<div class="tp-portfolio-details-1-list">
							<ul>
								<?php foreach ($features_items as $features_item_key => $features_item) { ?>
									<li>
										<?php if (isset($features_item["featureTitle"]) && trim($features_item["featureTitle"]) != "") { ?>

											<span><?php echo h($features_item["featureTitle"]); ?></span>
										<?php } ?>

										<?php if (isset($features_item["featureDescription"]) && trim($features_item["featureDescription"]) != "") { ?>
											<?php echo h($features_item["featureDescription"]); ?>
										<?php } ?>
									</li>
									
								<?php } ?>
							</ul>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>