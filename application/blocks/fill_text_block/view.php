<?php defined("C5_EXECUTE") or die("Access Denied."); ?>



<!-- about moving area start -->
<section class="des-about-area pb-200 <?php if (isset($hideBlock) && trim($hideBlock) == 1) { ?>hide-block<?php } ?>">
	<div class="container container-1230">
		<div class="row justify-content-center">
			<div class="col-xl-12">
				<div class="des-about-text text-center 5">
					<?php if (isset($content) && trim($content) != "") { ?>
					
						<p class="tp_text_invert_3 mb-45">
							<?php echo $content; ?>
                            </p>
					<?php } ?>
					<?php
					if (trim($link_URL) != "") { ?>
						<?php
						$link_Attributes = [];
						$link_Attributes['href'] = $link_URL;
						if (in_array($link, ['file', 'image', 'relative_url'])) {
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
</section>
<!-- about moving area end -->






