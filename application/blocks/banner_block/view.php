<?php defined("C5_EXECUTE") or die("Access Denied."); ?>










<div class="tp-hero-2-wrapper">
	<div class="tp-about-us-area include-bg pt-180 pb-150" data-background="<?php echo $this->getThemePath() . '/assets/img/home-02/hero/hero-bg.jpg'; ?>">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="tp-hero-2-content text-center mb-25">
						<?php if (isset($subTitle) && trim($subTitle) != "") { ?>
							<?php echo $subTitle; ?>
					
						<?php } ?>
						<?php if (isset($title) && trim($title) != "") { ?>
							<h1 class="tp-hero-2-title about-us tp_fade_anim text-scale-anim" data-delay=".5"><?php echo h($title); ?></h1>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="tp-hero-2-btn-box text-center  tp_fade_anim" data-delay=".7">
						<?php
						if (trim($link_URL) != "") { ?>
							<?php
							$link_Attributes = [];
							$link_Attributes['href'] = $link_URL;
							if (in_array($link, ['relative_url'])) {
								$link_Attributes['target'] = '_blank';
							}
							$link_AttributesHtml = join(' ', array_map(function ($key) use ($link_Attributes) {
								return $key . '="' . $link_Attributes[$key] . '"';
							}, array_keys($link_Attributes)));
							echo sprintf('<a class="tp-btn-border" %s>
							%s
							<span>
								<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 9.99999H15.2222M8.11121 1.11108L17.0001 9.99997L8.11121 18.8889" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</span>
							</a>', $link_AttributesHtml, $link_Title); ?>
						<?php } ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>