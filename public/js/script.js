
/* ============================================================
   MAIN SCRIPT
============================================================ */



function initGSAPAnimations() {
  // Check if the window width is greater than 1024px (standard laptop)
  if (window.innerWidth > 1024) {

    gsap.registerPlugin(ScrollTrigger);

    // ==========================================
    // HERO BANNER PRODUCT SLIDER & ANIMATIONS
    // ==========================================
    if (document.querySelector('.product-mini-slider')) {
      $('.product-mini-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: $('.product-slider-area .prev-btn'),
        nextArrow: $('.product-slider-area .next-btn'),
        autoplay: true,
        autoplaySpeed: 3000,
        fade: true,
        cssEase: 'linear'
      });
    }

    // Static Banner Animations (Entrance)
    const bannerContent = document.querySelector('.banner-content');
    const bannerMedia = document.querySelector('.banner-media');

    if (bannerContent) {
      gsap.from(bannerContent.children, {
        y: 30,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out'
      });
    }

    if (bannerMedia) {
      gsap.from(bannerMedia, {
        scale: 0.9,
        opacity: 0,
        duration: 1,
        ease: 'power2.out'
      });
    }

    // Floating Animations for Decorative Elements
    gsap.to(".floating-el", {
      y: "random(-20, 20)",
      x: "random(-10, 10)",
      rotation: "random(-5, 5)",
      duration: "random(2, 4)",
      repeat: -1,
      yoyo: true,
      ease: "sine.inOut",
      stagger: {
        each: 0.5,
        from: "random"
      }
    });

    // Mouse Parallax for Banner Background Element
    const bgElement = document.querySelector('.banner-bg-element');
    if (bgElement) {
      document.addEventListener('mousemove', (e) => {
        const xPos = (e.clientX / window.innerWidth - 0.5) * 30; // 30px max movement
        const yPos = (e.clientY / window.innerHeight - 0.5) * 30;

        gsap.to(bgElement, {
          x: xPos,
          y: yPos,
          duration: 1,
          ease: "power2.out"
        });
      });
    }

    // ==========================================
    // EXISTING ANIMATIONS (Restored)
    // ==========================================

    // GSAP Animation for Page Load - Fading in Sections
    if (document.querySelector(".banner-text-slider")) {
      gsap.from(".banner-text-slider", {
        opacity: 0,
        y: 100, // Slide from below
        duration: 1.5,
        stagger: 0.2, // Stagger each banner text item
        ease: "power4.out",
      });
    }

    // GSAP Animation for the Loader (Wave Animation)
    if (document.querySelector("#wave")) {
      gsap.from("#wave", {
        opacity: 0,
        y: 20,
        duration: 1.5,
        ease: "bounce.out", // Bounce effect
      });
    }

    // GSAP Animation for Scrolling Effect on "About Us" Section
    if (document.querySelector(".about-content")) {
      gsap.from(".about-content", {
        opacity: 0,
        x: -100,
        duration: 1,
        scrollTrigger: {
          trigger: ".about",
          start: "top 80%",
          end: "bottom top",
          // Smooth scrubbing on scroll
          // Optional for debugging
        }
      });
    }

    // GSAP Scroll Animation for "Our Work" Section
    if (document.querySelector(".our-work-item")) {
      gsap.from(".our-work-item", {
        opacity: 0,
        y: 50,
        duration: 1,
        stagger: 0.3,
        scrollTrigger: {
          trigger: ".our-work",
          start: "top 80%",
          end: "bottom top",
        }
      });
    }

    // GSAP Animation for Visionary Section
    if (document.querySelector(".visionary-content")) {
      gsap.from(".visionary-content", {
        opacity: 0,
        x: -200,
        duration: 1.5,
        ease: "power4.out",
        scrollTrigger: {
          trigger: ".visionary",
          start: "top 80%",
          end: "bottom top",
        }
      });
    }

    // GSAP Animation for Comparison Section (Slider Effect)
    if (document.querySelector(".comparison-wrapper")) {
      gsap.from(".comparison-wrapper", {
        opacity: 0,
        y: 50,
        duration: 1.5,
        ease: "power4.out",
        scrollTrigger: {
          trigger: ".comparison",
          start: "top 80%",
          end: "bottom top",
        }
      });
    }



    // Optional: GSAP Hover Effect for Images (parallax)
    gsap.to("img", {
      // scale: 1.05,
      duration: 1.5,
      ease: "power2.out",
      scrollTrigger: {
        trigger: "img",
        start: "top center",
        end: "bottom top",
        scrub: 1,
        markers: false
      }
    });

    // ==========================================
    // ABOUT US PAGE ANIMATIONS
    // ==========================================

    // 1. Hero Section: Text fade up, Image scale in
    if (document.querySelector('.about-hero')) {
      const tlHero = gsap.timeline();
      tlHero.from(".about-hero .text-content > *", {
        y: 50,
        opacity: 0,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      })
        .from(".about-hero .hero-image-wrapper img", {
          scale: 0.95,
          opacity: 0,
          duration: 1.2,
          ease: "power2.out"
        }, "-=0.5");
    }

    // 2. Creative & Visionary: Staggered Cards
    if (document.querySelector('.creative-visionary')) {
      gsap.from(".creative-visionary .feature-card", {
        scrollTrigger: {
          trigger: ".creative-visionary",
          start: "top 80%",
        },
        y: 60,
        opacity: 0,
        duration: 1,
        stagger: 0.2,
        ease: "back.out(1.7)" // Slight bounce
      });
    }

    // 3. Podcast vs Spotcast: Columns slide in
    if (document.querySelector('.podcast-spotcast')) {
      gsap.from(".podcast-spotcast .feature-list li", {
        scrollTrigger: {
          trigger: ".podcast-spotcast",
          start: "top 75%",
        },
        x: -30,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        ease: "power2.out"
      });
      gsap.from(".podcast-spotcast picture img", {
        scrollTrigger: {
          trigger: ".podcast-spotcast",
          start: "top 70%",
          scrub: 1
        },
        y: 100,
        // opacity: 0,
        duration: 1,
        ease: "power2.out"
      });
    }

    // 4. Trust Section: Image and Accordion
    if (document.querySelector('.trust')) {
      gsap.from(".trust .hero-image", {
        scrollTrigger: {
          trigger: ".trust",
          start: "top 80%",
        },
        x: -50,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
      });

      gsap.from(".trust .accordion-item", {
        scrollTrigger: {
          trigger: ".trust",
          start: "top 75%",
        },
        x: 50,
        opacity: 0,
        duration: 0.8,
        stagger: 0.2,
        ease: "power3.out"
      });
    }

    // 5. CTA Section: Fade Up
    if (document.querySelector('.cta-section')) {
      gsap.from(".cta-section .container-ctn > *", {
        scrollTrigger: {
          trigger: ".cta-section",
          start: "top 85%",
        },
        y: 40,
        opacity: 0,
        duration: 1,
        stagger: 0.2,
        ease: "power2.out"
      });
    }


    // ==========================================
    // HOME PAGE ANIMATIONS
    // ==========================================



    // 2. About Section (Home)
    if (document.querySelector('.about-inner')) {
      gsap.from(".about-inner h2 span", {
        scrollTrigger: {
          trigger: ".about-inner",
          start: "top 80%",
        },
        x: -50,
        opacity: 0,
        duration: 1,
        stagger: 0.1,
        ease: "power3.out"
      });
      gsap.from(".about-inner .description", {
        scrollTrigger: {
          trigger: ".about-inner",
          start: "top 80%",
        },
        x: 50,
        opacity: 0,
        duration: 1,
        ease: "power3.out",
        delay: 0.2
      });
    }

    // 3. Work Section Header (Home)
    if (document.querySelector('.work-section .head')) {
      gsap.from(".work-section .head > *", {
        scrollTrigger: {
          trigger: ".work-section",
          start: "top 80%",
        },
        y: 40,
        opacity: 0,
        duration: 1,
        stagger: 0.2,
        ease: "power2.out"
      });
    }

    // 4. We Offer Section (Home)
    if (document.querySelector('.we-offer')) {
      gsap.from(".we-offer-left", {
        scrollTrigger: {
          trigger: ".we-offer",
          start: "top 75%",
        },
        x: -50,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
      });
      gsap.from(".we-offer-right", {
        scrollTrigger: {
          trigger: ".we-offer",
          start: "top 75%",
        },
        x: 50,
        opacity: 0,
        duration: 1,
        ease: "power3.out",
        delay: 0.2
      });
    }

    // ==========================================
    // SERVICES PAGE ANIMATIONS
    // ==========================================

    // 1. Header (Services)
    if (document.querySelector('.services .head')) {
      gsap.from(".services .head > *", {
        scrollTrigger: {
          trigger: ".services",
          start: "top 80%",
        },
        y: 50,
        opacity: 0,
        duration: 1.2,
        stagger: 0.15,
        ease: "power4.out"
      });
    }

    // 2. Service Cards (Grid)
    if (document.querySelector('.services-grid')) {
      gsap.from(".services-grid .service-card", {
        scrollTrigger: {
          trigger: ".services-grid",
          start: "top 85%",
        },
        y: 60,
        opacity: 0,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });
    }

  }
}

// Call the function on page load
window.addEventListener('load', initGSAPAnimations);

// Also call the function on window resize to ensure it runs on resize
window.addEventListener('resize', function () {
  // If the width changes, re-run the animations check
  if (window.innerWidth > 1024) {
    initGSAPAnimations();
  }
});


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
  $(".photos-slider").slick({
    slidesToShow: 6,
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

  if (document.querySelector('.testimonialSwiper')) {
    new Swiper('.testimonialSwiper', {
      slidesPerView: 1,
      spaceBetween: 30,
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: '.swiper-button-next-custom',
        prevEl: '.swiper-button-prev-custom',
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        }
      }
    });

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

});
