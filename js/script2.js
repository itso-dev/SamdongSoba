gsap.registerPlugin(ScrollTrigger);
ScrollTrigger.config({autoRefreshEvents: "visibilitychange,DOMContentLoaded,load"});
let mm = gsap.matchMedia();
let timeoutClear;

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