
/* ============================================================
   MAIN SCRIPT
============================================================ */




// ==========What we offer========================
document.addEventListener('DOMContentLoaded', function () {

  const letterEls = document.querySelectorAll('.tabLetter');
  const buttons = document.querySelectorAll('#offerTabs button');

  function updateLetter(btn) {
    if (!btn || !letterEls.length) return;

    const letter = btn.textContent.trim().charAt(0);
    letterEls.forEach(el => {
      el.textContent = letter;
    });
  }

  // init on load
  updateLetter(document.querySelector('#offerTabs button.active'));

  // update on click
  buttons.forEach(btn => {
    btn.addEventListener('click', function () {
      updateLetter(this);
    });
  });

  const counterEls = document.querySelectorAll('[data-counter-target]');

  if (counterEls.length) {
    const animateCounter = (el) => {
      const target = parseInt(el.dataset.counterTarget || el.textContent, 10);
      if (Number.isNaN(target)) return;

      const duration = 1200;
      const startTime = performance.now();

      const step = (now) => {
        const progress = Math.min((now - startTime) / duration, 1);
        el.textContent = Math.floor(progress * target);

        if (progress < 1) {
          requestAnimationFrame(step);
        } else {
          el.textContent = target;
        }
      };

      requestAnimationFrame(step);
    };

    const counterObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.4 });

    counterEls.forEach((el) => {
      el.textContent = '0';
      counterObserver.observe(el);
    });
  }

});


document.addEventListener("DOMContentLoaded", () => {

  /* ------------------------------
    0. Banner
  ------------------------------ */
  if (document.querySelector('.heroSwiper')) {
    const swiper = new Swiper('.heroSwiper', {
      slidesPerView: 1,
      loop: true,
      on: {
        slideChangeTransitionStart() {
          resetAll();
        },
        slideChangeTransitionEnd() {
          playActiveVideo();
          setActiveFooter();
        }
      }
    });

    const footerItems = document.querySelectorAll('.hero-item');

    function resetAll() {
      swiper.el.querySelectorAll('video').forEach(v => {
        v.pause();
        v.currentTime = 0;
      });

      document.querySelectorAll('.progress-bar span').forEach(p => {
        p.style.width = '0%';
      });

      footerItems.forEach(i => i.classList.remove('active'));
    }

    function setActiveFooter() {
      const realIndex = swiper.realIndex;
      if (footerItems[realIndex]) {
        footerItems[realIndex].classList.add('active'); // Added check to prevent undefined error
      }
    }

    function playActiveVideo() {
      const slide = swiper.slides[swiper.activeIndex];
      const video = slide.querySelector('video');
      // Added check for footerItems to avoid errors
      const footerItem = footerItems[swiper.realIndex];
      const progress = footerItem ? footerItem.querySelector('.progress-bar span') : null;

      if (!video) return;

      video.play();

      video.ontimeupdate = () => {
        if (progress) {
          progress.style.width = (video.currentTime / video.duration) * 100 + '%';
        }
      };

      video.addEventListener('playing', () => {
        setTimeout(() => updateMenuColor(video), 200);
      }, {
        once: true
      });


      video.onended = () => {
        swiper.slideNext();
      };
    }

    // initial
    setActiveFooter();
    playActiveVideo();

    footerItems.forEach(item => {
      item.addEventListener('click', () => {
        const index = parseInt(item.dataset.index, 10);
        swiper.slideToLoop(index);
      });
    });



    function getBrightness(pixels) {
      let total = 0;

      for (let i = 0; i < pixels.length; i += 4) {
        total +=
          0.299 * pixels[i] +
          0.587 * pixels[i + 1] +
          0.114 * pixels[i + 2];
      }

      return total / (pixels.length / 4);
    }

    function updateMenuColor(video) {
      const canvas = document.createElement('canvas');
      const ctx = canvas.getContext('2d');

      canvas.width = 80;
      canvas.height = 40;

      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

      const pixels = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
      const brightness = getBrightness(pixels);

      const header = document.querySelector('header');

      // realistic cinematic threshold
      if (brightness < 150) {
        header.classList.add('light');
        header.classList.remove('dark');
      } else {
        header.classList.add('dark');
        header.classList.remove('light');
      }
    }
  }


  // ===================video work============


  const workSection = document.querySelector('.work-section');

  if (workSection) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          // Logic starts when section is visible
          startVideoLogic();
        }
      });
    }, {
      threshold: 0.1
    }); // Trigger when 10% of the section is visible

    observer.observe(workSection);
  }

  function startVideoLogic() {
    document.querySelectorAll('.hero-video').forEach(video => {
      // Ensure muted is set (required for JS play)
      video.muted = true;

      // 1. Force play immediately
      video.play().catch(e => console.log("Play blocked until user interaction"));

      // 2. Prevent pausing
      video.addEventListener('pause', () => {
        video.play();
      });

      // 3. Prevent stuck state
      video.addEventListener('waiting', () => {
        video.play();
      });

      // 4. Handle visibility changes
      document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
          video.play();
        }
      });
    });
  }


  /* ------------------------------
     1. Sticky Header & Bottom Menu
  ------------------------------ */
  const header = document.getElementById("header");
  const bottomMenu = document.querySelector(".bottomFixedMenu");

  if (header || bottomMenu) {
    window.addEventListener("scroll", () => {
      const scrolled = window.scrollY >= 220;

      if (header) {
        header.classList.toggle("scrolled", scrolled);
      }

      if (bottomMenu) {
        bottomMenu.classList.toggle("visible", scrolled);
      }
    });
  }


  /* ============================================================
     2. Slick Sliders
  ============================================================ */

  // Helper: generic progress slider initializer
  $(document).ready(function () {

    const slider = $('.what-we-offer-slider');

    if (slider.length) {
      slider.slick({
        dots: false,
        arrows: false,
        infinite: true,
        autoplay: true,
        slidesToShow: 1,
      });

      // Get number of slick slides
      const totalSlides = slider.slick("getSlick").slideCount;

      // Build steps dynamically
      const stepsContainer = document.querySelector('.steps-list');
      if (stepsContainer) {
        for (let i = 1; i <= totalSlides; i++) {
          const li = document.createElement("li");
          li.innerHTML = `<span>${i}</span>`;
          if (i === 1) li.classList.add("active");
          stepsContainer.appendChild(li);
        }
      }

      document.querySelectorAll(".what-we-offer-item").forEach((slide, index) => {
        const slideNum = slide.querySelector(".slide-number");
        if (slideNum) slideNum.textContent = String(index).padStart(2, '0');
      });

      const lineFill = document.querySelector(".line-fill");

      if (lineFill) {
        // ========================
        // FIX: INITIAL PROGRESS
        // ========================
        lineFill.style.width = (0 / (totalSlides - 1)) * 100 + "%";


        // Update on slide change
        slider.on('afterChange', function (event, slick, current) {

          document.querySelectorAll(".steps-list li").forEach((li, index) => {
            li.classList.toggle("active", index === current);
          });

          const percentage = (current / (totalSlides - 1)) * 100;
          lineFill.style.width = percentage + "%";
        });
      }
    }

    // initialize banner product slick
    const bannerSlider = $('.banner-product-slider');
    if (bannerSlider.length) {
      bannerSlider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 2500,
        cssEase: 'linear',

      });
    }

    const bannerMediaSlider = $('.banner-media-slider');
    if (bannerMediaSlider.length) {
      let isPlaying = true;
      const ensureVideoPlay = function (videoEl) {
        if (!videoEl) return;
        videoEl.muted = true;
        videoEl.playsInline = true;

        const tryPlay = () => {
          videoEl.play().catch(() => { });
        };

        if (videoEl.readyState >= 2) {
          tryPlay();
        } else {
          videoEl.addEventListener('loadeddata', tryPlay, { once: true });
          videoEl.addEventListener('canplay', tryPlay, { once: true });
          videoEl.load();
        }
      };

      const syncBannerMediaVideo = function () {
        const executeSync = function () {
          try {
            if (!bannerMediaSlider || !bannerMediaSlider.length) return;

            const allVideos = bannerMediaSlider.find('video');
            allVideos.each(function () {
              this.pause();
              this.onended = null;
            });

            if (!isPlaying) return;

            const activeVideo = bannerMediaSlider.find('.slick-current video').get(0);
            if (activeVideo) {
              if (bannerMediaSlider.data('slick')) {
                try {
                  bannerMediaSlider.slick('slickPause');
                } catch (e) {
                  console.warn('Slick pause failed:', e);
                }
              }

              activeVideo.currentTime = 0;
              activeVideo.onended = function () {
                if (isPlaying && bannerMediaSlider.data('slick')) {
                  try {
                    bannerMediaSlider.slick('slickNext');
                  } catch (e) { }
                }
              };
              ensureVideoPlay(activeVideo);
            } else {
              if (bannerMediaSlider.data('slick')) {
                try {
                  bannerMediaSlider.slick('slickPlay');
                } catch (e) { }
              }
            }
          } catch (error) {
            console.error('Error in syncBannerMediaVideo:', error);
          }
        };

        // Small delay to ensure Slick has finished its internal event cycle
        setTimeout(executeSync, 100);
      };

      bannerMediaSlider.on('init afterChange', syncBannerMediaVideo);

      bannerMediaSlider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        appendDots: $('.banner-media-dots'),
        arrows: true,
        prevArrow: $('.banner-product-wrapper .prev'),
        nextArrow: $('.banner-product-wrapper .next'),
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3000,
        speed: 700,
        fade: true,
        customPaging: function (slider, i) {
          return `<span class="banner-dot"></span>`;
        },
        cssEase: 'linear'
      });

      try {
        if ($('.client-slider').length) {
          $('.client-slider').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
            dots: false,
            infinite: true,
            pauseOnHover: false,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 4
                }
              },
              {
                breakpoint: 768,
                settings: {
                  slidesToShow: 3
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 2
                }
              }
            ]
          });
        }
      } catch (err) {
        console.error('Client slider init failed:', err);
      }

      const bannerMediaPlayBtn = document.querySelector('.banner-media-play');
      if (bannerMediaPlayBtn) {
        bannerMediaPlayBtn.addEventListener('click', function () {
          const activeVideo = bannerMediaSlider.find('.slick-current video').get(0);

          if (isPlaying) {
            isPlaying = false;
            bannerMediaSlider.slick('slickPause');
            if (activeVideo) activeVideo.pause();
            this.classList.add('is-paused');
            this.setAttribute('aria-label', 'Play slider');
            this.setAttribute('title', 'Play slider');
          } else {
            isPlaying = true;
            syncBannerMediaVideo();
            if (activeVideo) ensureVideoPlay(activeVideo);
            this.classList.remove('is-paused');
            this.setAttribute('aria-label', 'Pause slider');
            this.setAttribute('title', 'Pause slider');
          }
        });
      }
    }

  });












  /* ============================================================
     5. Lazy Loading for Images
  ============================================================ */

  const lazyImages = document.querySelectorAll("img[data-src][loading='lazy']");
  if (lazyImages.length) {
    const lazyObserver = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        const img = entry.target;
        img.src = img.dataset.src;
        if (img.dataset.alt) img.alt = img.dataset.alt;
        img.removeAttribute("data-src");
        img.removeAttribute("loading");
        obs.unobserve(img);
      });
    });

    lazyImages.forEach((img) => lazyObserver.observe(img));
  }






});

/* ============================================================
  6. Other Works
============================================================ */
document.addEventListener("DOMContentLoaded", () => {
  $(".episodes-slider").slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    dots: true,
    arrows: false,
    speed: 1000,
    autoplay: true,
    cssEase: "linear",
    infinite: true,
    pauseOnHover: true,
    pauseOnFocus: false,
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
        },
      },

      {
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  })
  $(".brand-slider").slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    speed: 1000,
    autoplay: true,
    cssEase: "linear",
    infinite: true,
    pauseOnHover: true,
    pauseOnFocus: false,
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
        },
      },

      {
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  })

  if (document.querySelector('.testimonialSwiper')) {


    // Initialize Star Rating
    $(".my-rating-readonly, .jq-stars").each(function () {
      var rating = $(this).data('rating');
      $(this).starRating({
        initialRating: rating,
        readOnly: true,
        starSize: 15,
        useGradient: false,
        activeColor: '#FEB109',
        strokeWidth: 0,
      });
    });

    // Banner Video Play Logic
    document.addEventListener('click', (e) => {
      const playBtn = e.target.closest('.banner .play-btn');
      if (playBtn) {
        const slide = playBtn.closest('.swiper-slide');
        const bannerVideo = slide.querySelector('video');

        if (bannerVideo) {
          if (bannerVideo.paused) {
            bannerVideo.play();
            playBtn.style.opacity = '0';
          } else {
            bannerVideo.pause();
            playBtn.style.opacity = '1';
          }
        }
      }
    });

    // Handle video end to reveal play button
    document.querySelectorAll('.banner video').forEach(video => {
      video.addEventListener('pause', () => {
        const playBtn = video.closest('.video-container').querySelector('.play-btn');
        if (playBtn) playBtn.style.opacity = '1';
      });
      video.addEventListener('play', () => {
        const playBtn = video.closest('.video-container').querySelector('.play-btn');
        if (playBtn) playBtn.style.opacity = '0';
      });
    });
  }

  if (document.querySelector('.products-slider')) {
    $('.products-slider .slider-wrapper').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: true,
      dots: true,
      arrows: false,
      variableWidth: true,
      responsive: [

      ]

    });
  }

});


/* ============================================================
   4. Equal Height Utility
============================================================ */

const setEqualHeightFor = (selector) => {
  const items = document.querySelectorAll(selector);
  if (!items.length) return;

  let max = 0;
  items.forEach((el) => {
    el.style.height = "auto";
    if (el.offsetHeight > max) max = el.offsetHeight;
  });
  items.forEach((el) => {
    el.style.height = `${max}px`;
  });
};

const equalHeightTargets = [
  ".products-slider .card-content .text",
  // ".review-card",
];

window.addEventListener("load", () => {
  setTimeout(() => {
    equalHeightTargets.forEach(setEqualHeightFor);
  }, 300);
});

window.addEventListener("resize", () => {
  equalHeightTargets.forEach(setEqualHeightFor);
});

