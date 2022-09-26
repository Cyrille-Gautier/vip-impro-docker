var body = jQuery('body');
var st = 0;
var lastSt = 0;
var navText = ['<i class="mdi mdi-chevron-left"></i>', '<i class="mdi mdi-chevron-right"></i>'];

window.lazySizesConfig = window.lazySizesConfig || {};
window.lazySizesConfig.loadHidden = false;

jQuery(function() {
  'use strict';

  retinaLogo();
  fitVids();
  carousel();
  slider();
  megaMenu();
  hero();
  categoryBoxes();
  picks();
  offCanvas();
  gallery();
  photoSwipe();
  search();
  masonry();
  pagination();
  like();
  bookmark();
  share();
});

jQuery(window).scroll(function() {
  'use strict';

  if (body.hasClass('navbar-sticky') || body.hasClass('navbar-sticky_transparent')) {
    window.requestAnimationFrame(navbar);
  }
});

document.addEventListener('lazyloaded', function (e) {
  var options = {
    disableParallax: /iPad|iPhone|iPod|Android/,
    disableVideo: /iPad|iPhone|iPod|Android/,
    speed: 0.1,
  };

  if (
    jQuery(e.target).parents('.hero').length ||
    jQuery(e.target).hasClass('hero')
  ) {
    jQuery(e.target).jarallax(options);
  }

  if (
    (jQuery(e.target).parent().hasClass('module') && jQuery(e.target).parent().hasClass('parallax')) ||
    jQuery(e.target).parent().hasClass('entry-navigation')
  ) {
    jQuery(e.target).parent().jarallax(options);
  }
});

function navbar() {
  'use strict';

  st = jQuery(window).scrollTop();
  var adHeight = jQuery('.ads.before_header').outerHeight();
  var navbarHeight = jQuery('.site-header').height();
  var stickyTransparent = jQuery('.navbar-sticky_transparent.with-hero');
  var adsBeforeHeader = jQuery('.navbar-sticky.ads-before-header, .navbar-sticky_transparent.ads-before-header');
  var stickyStickyTransparent = jQuery('.navbar-sticky.navbar-slide, .navbar-sticky_transparent.navbar-slide');

  if (st > (navbarHeight + adHeight)) {
    stickyTransparent.addClass('navbar-sticky');
  } else {
    stickyTransparent.removeClass('navbar-sticky');
  }

  if (st > adHeight) {
    adsBeforeHeader.addClass('stick-now');
  } else {
    adsBeforeHeader.removeClass('stick-now');
  }

  if (st > lastSt && st > (navbarHeight + adHeight + 100)) {
    stickyStickyTransparent.addClass('slide-now');
  } else {
    if (st + jQuery(window).height() < jQuery(document).height()) {
      stickyStickyTransparent.removeClass('slide-now');
    }
  }

  lastSt = st;
}

function retinaLogo() {
  'use strict';

  var logoRegular = jQuery('.logo.regular');
  var logoContrary = jQuery('.logo.contrary');
  var mediaQuery = '(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-resolution: 1.5dppx)';

  if (magsyParams.logo_regular != '' && (window.devicePixelRatio > 1 || (window.matchMedia && window.matchMedia(mediaQuery).matches))) {
    logoRegular.each(function(i, v) {
      jQuery(v).prop('width', jQuery(v).width());
      jQuery(v).prop('height', jQuery(v).height());
      jQuery(v).attr('src', magsyParams.logo_regular);
    });
  }

  if (magsyParams.logo_contrary != '' && (window.devicePixelRatio > 1 || (window.matchMedia && window.matchMedia(mediaQuery).matches))) {
    logoContrary.prop('width', logoContrary.width());
    logoContrary.prop('height', logoContrary.height());
    logoContrary.attr('src', magsyParams.logo_contrary);
  }
}

function fitVids() {
  'use strict';

  body.fitVids();
}

function carousel() {
  'use strict';

  jQuery('.carousel.module').owlCarousel({
    autoHeight: true,
    dots: false,
    margin: 30,
    nav: true,
    navSpeed: 500,
    navText: navText,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      992: {
        items: 4,
      },
    },
  });
}

function slider() {
  'use strict';

  var autoplayOptions = {
    autoplay: true,
    autoplaySpeed: 800,
    loop: true,
  };

  var bigSlider = jQuery('.slider.big.module');
  var bigSliderOptions = {
    animateOut: 'fadeOut',
    dots: false,
    items: 1,
    nav: true,
    navText: navText,
  };
  bigSlider.each(function(i, v) {
    if (jQuery(v).hasClass('autoplay')) {
      var bigSliderAuto = Object.assign(autoplayOptions, bigSliderOptions);
      jQuery(v).owlCarousel(bigSliderAuto);
    } else {
      jQuery(v).owlCarousel(bigSliderOptions);
    }
  });

  var centerSlider = jQuery('.slider.center.module');
  var centerSliderOptions = {
    center: true,
    dotsSpeed: 800,
    loop: true,
    margin: 20,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 2,
      },
    },
  };
  centerSlider.each(function(i, v) {
    if (jQuery(v).hasClass('autoplay')) {
      var centerSliderAuto = Object.assign(autoplayOptions, centerSliderOptions);
      jQuery(v).owlCarousel(centerSliderAuto);
    } else {
      jQuery(v).owlCarousel(centerSliderOptions);
    }
  });

  var thumbnailSlider = jQuery('.slider.thumbnail.module');
  var thumbnailSliderOptions = {
    dotsData: true,
    dotsSpeed: 800,
    items: 1,
  };
  thumbnailSlider.each(function(i, v) {
    if (jQuery(v).hasClass('autoplay')) {
      var thumbnailSliderAuto = Object.assign(autoplayOptions, thumbnailSliderOptions);
      jQuery(v).owlCarousel(thumbnailSliderAuto);
    } else {
      jQuery(v).owlCarousel(thumbnailSliderOptions);
    }
  });
}

function megaMenu() {
  'use strict';

  var options = {
    items: 5,
    margin: 15,
  };

  jQuery('.menu-posts').not('.owl-loaded').owlCarousel(options);
}

function hero() {
  'use strict';

  if (body.hasClass('with-hero')) {
    jQuery('.hero-full .hero').height(jQuery(window).height() - jQuery('.header-gap').height() - jQuery('#wpadminbar').height());

    if (jQuery('.hero-gallery .hero').length) {
      var galleryHero = jQuery('.hero-gallery .hero');
      galleryHero.imagesLoaded({ background: '.slider-item' }, function() {
        jQuery('.hero-slider').owlCarousel({
          animateOut: 'fadeOut',
          dots: false,
          items: 1,
          mouseDrag: false,
          nav: true,
          navText: navText,
          onInitialized: function(e) {
            jQuery('.hero-slider').find('.owl-item:first-child').addClass('finished');
          },
          onTranslated: function(e) {
            jQuery('.hero-slider').find('.owl-item').removeClass('finished');
            jQuery('.hero-slider').find('.owl-item:nth-child(' + (e.item.index + 1) + ')').addClass('finished');
          },
          touchDrag: false,
        });
      });
    }
  }
}

function categoryBoxes() {
  'use strict';

  jQuery('.category-boxes').owlCarousel({
    dots: false,
    margin: 30,
    nav: true,
    navSpeed: 500,
    navText: navText,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 2,
      },
      992: {
        items: 3,
      },
      1230: {
        items: 4,
      },
    },
  });
}

function picks() {
  'use strict';

  jQuery('.picked-posts').not('.owl-loaded').owlCarousel({
    autoHeight: true,
    autoplay: true,
    autoplayHoverPause: true,
    autoplaySpeed: 500,
    autoplayTimeout: 3000,
    items: 1,
    loop: true,
  });
}

function offCanvas() {
  'use strict';

  var burger = jQuery('.burger');
  var canvasClose = jQuery('.canvas-close');

  jQuery('.main-menu .nav-list').slicknav({
    label: '',
    prependTo: '.mobile-menu',
  });

  burger.on('click', function() {
    body.toggleClass('canvas-opened');
    body.addClass('canvas-visible');
    dimmer('open', 'medium');
  });

  canvasClose.on('click', function() {
    if (body.hasClass('canvas-opened')) {
      body.removeClass('canvas-opened');
      dimmer('close', 'medium');
    }
  });

  jQuery('.dimmer').on('click', function() {
    if (body.hasClass('canvas-opened')) {
      body.removeClass('canvas-opened');
      dimmer('close', 'medium');
    }
  });

  jQuery(document).keyup(function(e) {
    if (e.keyCode == 27 && body.hasClass('canvas-opened')) {
      body.removeClass('canvas-opened');
      dimmer('close', 'medium');
    }
  });
}

function gallery() {
  'use strict';

  jQuery('.entry-gallery.slider').not('.owl-loaded').owlCarousel({
    animateOut: 'fadeOut',
    dots: false,
    items: 1,
    nav: true,
    navSpeed: 500,
    navText: navText,
  });

  jQuery('.entry-gallery.justified-gallery').justifiedGallery({
    border: 0,
    margins: 6,
    rowHeight: 200,
  });
}

function photoSwipe() {
  'use strict';

  var pswpElement = jQuery('.pswp')[0];
  var items = [];
  var index, clickedElement, options, gallery;

  jQuery('.entry-gallery.justified-gallery').on('click', '.gallery-item > a', function(e) {
    e.preventDefault();
    items = [];
    clickedElement = jQuery(this);

    index = clickedElement.parent().index();

    jQuery.each(clickedElement.parent().siblings().andSelf(), function(i, v) {
      items.push({
        h: parseInt(jQuery(v).find('a').attr('data-height')),
        src: jQuery(v).find('a').attr('href'),
        title: jQuery(v).find('.caption').text(),
        w: parseInt(jQuery(v).find('a').attr('data-width')),
      });
    });

    options = {
      closeOnScroll: false,
      history: false,
      index: index,
      showAnimationDuration: 0,
      showHideOpacity: true,
      timeToIdle: 2000,
    };

    gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
  });
}

function search() {
  'use strict';

  var searchContainer = jQuery('.main-search');
  var searchField = searchContainer.find('.search-field');

  jQuery('.search-open').on('click', function() {
    body.addClass('search-open');
    searchField.focus();
  });

  jQuery(document).keyup(function(e) {
    if (e.keyCode == 27 && body.hasClass('search-open')) {
      body.removeClass('search-open');
    }
  });

  jQuery('.search-close').on('click', function() {
    if (body.hasClass('search-open')) {
      body.removeClass('search-open');
    }
  });

  jQuery(document).mouseup(function(e) {
    if (!searchContainer.is(e.target) && searchContainer.has(e.target).length === 0 && body.hasClass('search-open')) {
      body.removeClass('search-open');
    }
  });
}

function masonry() {
  'use strict';

  jQuery('.module.masonry > .row').masonry({
    columnWidth: '.grid-sizer',
    itemSelector: '.grid-item',
    percentPosition: true,
  });
}

function pagination() {
  'use strict';

  var wrapper = jQuery('.posts-wrapper');
  var button = jQuery('.infinite-scroll-button');
  var options = {
    append: wrapper.selector + ' > *',
    debug: false,
    hideNav: '.posts-navigation',
    history: false,
    path: '.posts-navigation .nav-previous a',
    prefill: true,
    status: '.infinite-scroll-status',
  };

  if (body.hasClass('pagination-infinite_button')) {
    options.button = button.selector;
    options.prefill = false;
    options.scrollThreshold = false;

    wrapper.on('request.infiniteScroll', function (event, path) {
      button.text(magsyParams.infinite_loading);
    });

    wrapper.on('load.infiniteScroll', function (event, response, path) {
      button.text(magsyParams.infinite_load);
    });
  }

  if ((body.hasClass('pagination-infinite_button') || body.hasClass('pagination-infinite_scroll')) && body.hasClass('paged-next')) {
    wrapper.infiniteScroll(options);
  }
}

function like() {
  return;
  'use strict';

  var postID, clickedElement;
  var element = jQuery('.like');

  jQuery.each(element, function(index, value) {
    if (Cookies.get('magsy-like-' + jQuery(value).attr('data-id')) == '1') {
      jQuery(this).addClass('liked');
      jQuery(this).attr('title', magsyParams.unlike_title);
    }
  });

  jQuery('.site-main').on('click', element.selector, function(e) {
    e.preventDefault();
    postID = jQuery(this).attr('data-id');
    clickedElement = jQuery(this);

    clickedElement.addClass('liking');

    if (Cookies.get('magsy-like-' + postID) == '1') {
      jQuery.ajax({
        type: 'POST',
        url: magsyParams.admin_url,
        data: {
          action: 'magsy_unlike',
          post_id: postID,
          nonce: magsyParams.unlike_nonce
        },
        success: function(result) {
          Cookies.remove('magsy-like-' + postID, { path: '/' });
          clickedElement.find('.count').text(result);
          clickedElement.removeClass('liking liked');
          clickedElement.attr('title', magsyParams.like_title);
        }
      });
    } else {
      jQuery.ajax({
        type: 'POST',
        url: magsyParams.admin_url,
        data: {
          action: 'magsy_like',
          post_id: postID,
          nonce: magsyParams.like_nonce
        },
        success: function(result) {
          Cookies.set('magsy-like-' + postID, '1', { expires: 365, path: '/' });
          clickedElement.find('.count').text(result);
          clickedElement.removeClass('liking').addClass('liked');
          clickedElement.attr('title', magsyParams.unlike_title);
        }
      });
    }
  });
}

function bookmark() {
  'use strict';

  jQuery('.site-content').on('click', '.bookmark', function(e) {
    e.preventDefault();
    popup(jQuery(this).attr('data-url'));
  });
}

function share() {
  'use strict';

  var modal = jQuery('.modal');
  var modalThumbnail = modal.find('.modal-thumbnail').find('img');
  var modalTitle = modal.find('.modal-title');
  var modalFacebook = modal.find('.facebook');
  var modalTwitter = modal.find('.twitter');
  var modalPinterest = modal.find('.pinterest');
  var modalEmail = modal.find('.email');
  var modalWhatsApp = modal.find('.whatsapp');
  var modalPermalink = modal.find('.modal-permalink');
  var modalButton = modal.find('button');
  var modalIcon = modalButton.find('.mdi');
  var clickedElement;

  jQuery('.site-content').on('click', '.share', function(e) {
    e.preventDefault();
    clickedElement = jQuery(this);
    modalThumbnail.removeClass('lazyloaded').addClass('lazyload').attr('data-src', clickedElement.attr('data-thumbnail'));
    modalTitle.text(clickedElement.attr('data-title'));
    modalFacebook.attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(clickedElement.attr('data-url')));
    modalTwitter.attr('href', 'https://twitter.com/intent/tweet?text=' + escape(clickedElement.attr('data-title')) + '&url=' + encodeURIComponent(clickedElement.attr('data-url')));
    modalPinterest.attr('href', 'https://pinterest.com/pin/create/button/?url=' + encodeURIComponent(clickedElement.attr('data-url')) + '&media=' + encodeURIComponent(clickedElement.attr('data-image')) + '&description=' + escape(clickedElement.attr('data-title')));
    modalEmail.attr('href', 'mailto:?subject=' + escape(clickedElement.attr('data-title')) + '&body=' + encodeURIComponent(clickedElement.attr('data-url')));
    modalWhatsApp.attr('href', 'whatsapp://send?text=' + encodeURIComponent(clickedElement.attr('data-url')));
    modalPermalink.val(clickedElement.attr('data-url'));
    modalButton.attr('data-clipboard-text', clickedElement.attr('data-url'));
    modalIcon.removeClass('mdi-check').addClass('mdi-content-copy');
    modal.fadeIn('fast');
    dimmer('open', 'fast');
    body.addClass('modal-opened');
  });

  modalButton.on('click', function(e) {
    e.preventDefault();
    new ClipboardJS(modalButton.selector);
    modalIcon.removeClass('mdi-content-copy').addClass('mdi-check');
  });

  jQuery('.dimmer').on('click', function() {
    if (body.hasClass('modal-opened')) {
      modal.fadeOut(0);
      dimmer('close', 0);
      body.removeClass('modal-opened');
    }
  });

  jQuery(document).keyup(function(e) {
    if (e.keyCode == 27 && body.hasClass('modal-opened')) {
      modal.fadeOut(0);
      dimmer('close', 0);
      body.removeClass('modal-opened');
    }
  });
}

function dimmer(action, speed) {
  'use strict';

  var dimmer = jQuery('.dimmer');

  switch (action) {
    case 'open':
      dimmer.fadeIn(speed);
      break;
    case 'close':
      dimmer.fadeOut(speed);
      break;
  }
}

function popup(url, title, w, h) {
  'use strict';

  title = title || '';
  w = w || 500;
  h = h || 300;

  var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
  var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

  var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
  var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

  var left = ((width / 2) - (w / 2)) + dualScreenLeft;
  var top = ((height / 2) - (h / 2)) + dualScreenTop;
  var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

  if (window.focus) {
    newWindow.focus();
  }
}