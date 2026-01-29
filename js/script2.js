gsap.registerPlugin(ScrollTrigger);
ScrollTrigger.config({autoRefreshEvents: "visibilitychange,DOMContentLoaded,load"});
let mm = gsap.matchMedia();
let timeoutClear;

$("#interior-tab1").addClass("contain-active");

  let Itabs = $(".interior-tab");

  Itabs.click(function () {
    Itabs.removeClass("active");
    $(".interior-wrap").removeClass("contain-active");

    let tab_id = $(this).attr("data-tab");
    $(this).addClass("active");
    $("#" + tab_id).addClass("contain-active");
  });

var support = new Swiper(".support-swiper-container", {
  slidesPerView: 3,
  spaceBetween: 0,
  loop: true,
  direction: "vertical",
  autoplay: {
    delay: 1800,
    disableOnInteraction: false,
  },
  breakpoints: {
    1024: {
      slidesPerView: 3,
      spaceBetween: 0
    },
    650: {
      slidesPerView: 3,
      spaceBetween: 12
    },
  },
});

const cost = gsap.timeline({
  scrollTrigger: {
    trigger: ".cost-total",
    start: "top 90%",
    toggleActions: "play none none reset",
  }
});

cost.fromTo(".cost-total1", 
  { scale: 2, opacity: 0, filter: "blur(16px)", },
  { scale: 1, opacity: 1, filter: "blur(0px)", duration: 0.2, ease: "power2.in",},
  "+=0.2"
);

cost.fromTo(".cost-total2", 
  { scale: 2, opacity: 0, filter: "blur(16px)", },
  { scale: 1, opacity: 1, filter: "blur(0px)", duration: 0.2, ease: "power2.in",},
);

const wave01Scale = window.innerWidth <= 480 ? 0.55 : 0.5;
const wave02Scale = 0.75;
const wave03Scale = 1.05;
gsap.utils.toArray('.wave01').forEach((el, i) => {
  gsap.fromTo(el, {opacity: 0, scale: 0.3}, {opacity: 0.15, scale: wave01Scale, duration: 1.2, repeat: -1});
});
gsap.utils.toArray('.wave02').forEach((el, i) => {
  gsap.fromTo(el, {opacity: 0, scale: 0.4}, {opacity: 0.3, scale: wave02Scale, duration: 1.2, repeat: -1});
});
gsap.utils.toArray('.wave03').forEach((el, i) => {
  gsap.fromTo(el, {opacity: 0, scale: 0.7}, {opacity: 0.6, scale: wave03Scale, duration: 1.2, repeat: -1});
});

const processTl = gsap.timeline({
  scrollTrigger: {
    trigger: ".process-container",
    start: "top 70%",
    toggleActions: "play none none reset",
  }
});

const boxes = gsap.utils.toArray(".process-container .process-box");
const lines = gsap.utils.toArray(".process-container>img");

boxes.forEach((box, i) => {

  processTl.fromTo(
    box,
    {
      opacity: 0,
      rotateY: -100,
      x: -40,
      transformOrigin: "0% 50%",
      perspective: 2500
      },
      {
      opacity: 1,
      rotateY: 0,
      x: 0,
      duration: 0.2,
      ease: "power2.out",
    }
);

  if (lines[i]) {
    processTl.fromTo(
      lines[i],
      {
        opacity: 0,
        x: -30,
      },
      {
        opacity: 1,
        x: 0,
        duration: 0.1,
        ease: "power2.out"
      },
      "-=0.02"
    );
  }

});

const c = gsap.timeline({
  scrollTrigger: {
    trigger: "#contact",
    start: "top 80%",
    toggleActions: "play none none reset",
  }
});

c.fromTo(".contact-form", 
  { opacity: 0, y: 50},
  { opacity: 1, y: 0, duration: 0.3, ease: "power2.out"},
  "+=0.4"
);


c.fromTo(".contact-img", 
  { opacity: 0, xPercent: -50},
  { opacity: 1, xPercent: 0, duration: 0.8, ease: "power2.out"},
  "+=0.2"
);

gsap.fromTo(".contact-form .c-btn", 
  { scale: 2, opacity: 0, filter: "blur(16px)", },
  { scale: 1, opacity: 1, filter: "blur(0px)", duration: 0.2, ease: "power2.in",
    scrollTrigger: {
      trigger: ".contact-form .c-btn",
      start: "top 75%",    
      toggleActions: "play none none reset",
    }
  },
    "together"
);