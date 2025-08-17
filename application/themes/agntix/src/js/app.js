import Header from './components/Header';
import Maps from './components/Maps';
import BlockMain from "./Blocks/BlockMain";
import DynamicImports from './components/DynamicImports';

import { inVP } from "./utils";

export default new (class App {
  constructor() {
    this.setDomMap();
    this.previousScroll = 0;

    // dom ready shorthand
    $(() => {
      this.domReady();
    });
  }

  domReady = () => {
    this.initComponents();
    this.captchaLoad();
    this.handleUserAgent();
    this.windowResize();
    this.bindEvents();
    this.handleSplashScreen();
  };

  initComponents = () => {
    new Header({
      header: this.header,
      htmlBody: this.htmlBody,
    });

    if (this.mapContainer.length) {
      new Maps({
        mapContainer: this.mapContainer,
      });
    }

    new BlockMain();

    new DynamicImports();
  };

  captchaLoad = () => {
    $(window).on("scroll load", () => {
      if (inVP(this.formidable) && !this.formidable.hasClass("formInview")) {
        this.formidable.addClass('formInview');
      }
    });
  };

  setDomMap = () => {
    this.window = $(window);
    this.htmlNbody = $('body, html');
    this.html = $('html');
    this.htmlBody = $('body');
    this.siteLoader = $('.site-loader');
    this.header = $('header.header');
    this.siteBody = $('.site-body');
    this.footer = $('footer');
    this.gotoTop = $('#gotoTop');
    this.gRecaptcha = $('.g-recaptcha');
    this.wrapper = $('.wrapper');
    this.pushDiv = this.wrapper.find('.push');
    this.mapContainer = $('#map_canvas');
    this.formidable = $('.formidable');
    this.inputs = $('input, textarea').not('[type="checkbox"], [type="radio"]');
  };

  bindEvents = () => {
    // Window Events
    this.window.resize(this.windowResize).scroll(this.windowScroll);

    // General Events
    const $container = this.wrapper;

    $container.on('click', '.disabled', () => false);

    // Specific Events
    this.gotoTop.on('click', () => {
      this.htmlNbody.animate({
        scrollTop: 0,
      });
    });

    this.inputs
      .on({
        focus: e => {
          const self = $(e.currentTarget);
          self.closest('.element').addClass('active');
        },
        blur: e => {
          const self = $(e.currentTarget);
          if (self.val() !== '') {
            self.closest('.form-group').addClass('active');
          } else {
            self.closest('.form-group').removeClass('active');
          }
        },
      })
      .trigger('blur');
  };

  windowResize = () => {
    this.screenWidth = this.window.width();
    this.screenHeight = this.window.height();

    // calculate footer height and assign it to wrapper and push/footer div
    if (this.pushDiv.length){
      this.footerHeight = this.footer.outerHeight();
      this.wrapper.css('margin-bottom', -this.footerHeight);
      this.pushDiv.height(this.footerHeight);
    }
  };

  windowScroll = () => {
    const topOffset = this.window.scrollTop();

		this.header.toggleClass("top", topOffset > 80);
		this.header.toggleClass("sticky-header", topOffset > 300);
		if (topOffset > this.previousScroll || topOffset < 400) {
			this.header.removeClass("sticky-header");
		} else if (topOffset < this.previousScroll) {
			this.header.addClass("sticky-header");
			// Additional checking so the header will not flicker
			if (topOffset > 250) {
				this.header.addClass("sticky-header");
			} else {
				this.header.removeClass("sticky-header");
			}
		}

    this.previousScroll = topOffset;
    this.gotoTop.toggleClass(
      'active',
      this.window.scrollTop() > this.screenHeight / 2,
    );
  };

  handleSplashScreen() {
    this.htmlBody.find('.logo-middle').fadeIn(500);
    this.siteLoader.delay(1500).fadeOut(500);
  }

  handleUserAgent = () => {
    // detect mobile platform
    if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
      this.htmlBody.addClass('ios-device');
    }
    if (navigator.userAgent.match(/Android/i)) {
      this.htmlBody.addClass('android-device');
    }

    // detect desktop platform
    if (navigator.appVersion.indexOf('Win') !== -1) {
      this.htmlBody.addClass('win-os');
    }
    if (navigator.appVersion.indexOf('Mac') !== -1) {
      this.htmlBody.addClass('mac-os');
    }

    // detect IE 10 and 11P
    if (
      navigator.userAgent.indexOf('MSIE') !== -1 ||
      navigator.appVersion.indexOf('Trident/') > 0
    ) {
      this.html.addClass('ie10');
    }

    // detect IE Edge
    if (/Edge\/\d./i.test(navigator.userAgent)) {
      this.html.addClass('ieEdge');
    }

    // Specifically for IE8 (for replacing svg with png images)
    if (this.html.hasClass('ie8')) {
      const imgPath = '/themes/theedge/images/';
      $('header .logo a img,.loading-screen img').attr(
        'src',
        `${imgPath}logo.png`,
      );
    }

    // show ie overlay popup for incompatible browser
    if (this.html.hasClass('ie9')) {
      const message = $(
        '<div class="no-support"> You are using outdated browser. Please <a href="https://browsehappy.com/" target="_blank">update</a> your browser or <a href="https://browsehappy.com/" target="_blank">install</a> modern browser like Google Chrome or Firefox.<div>',
      );
      this.htmlBody.prepend(message);
    }
  };
})();
