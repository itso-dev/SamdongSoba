// page1
document.addEventListener("DOMContentLoaded", () => {
    const wrap = document.querySelector(".swap-txt-wrap");
    const texts = wrap.querySelectorAll(".txt");
    let current = 0;

    if (!texts.length) return;

    // ⭐ 첫 텍스트 기준으로 높이 고정
    requestAnimationFrame(() => {
        wrap.style.height = texts[0].offsetHeight + "px";
    });

    texts[current].classList.add("is-active");

    setInterval(() => {
        texts[current].classList.remove("is-active");
        current = (current + 1) % texts.length;
        texts[current].classList.add("is-active");
    }, 3000);
});

window.addEventListener("load", () => {
    if (!window.gsap || !window.ScrollTrigger) return;

    gsap.registerPlugin(ScrollTrigger);

    document.querySelectorAll(".mask").forEach((wrap) => {
        const targets = wrap.querySelectorAll(".line-animation");
        if (!targets.length) return;

        targets.forEach((el, i) => {
            gsap.set(el, { "--fill": 0 });

            gsap.to(el, {
                "--fill": 1,
                duration: 0.6,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: wrap,              // 섹션 진입 기준
                    start: "top 80%",
                    toggleActions: "play none none reverse",
                },
                delay: i * 0.15               // 첫번째 -> 두번째 순서(원하면 0으로)
            });
        });
    });
    //page4 제목
    document.querySelectorAll(".page4 .sales-container .tit-wrap").forEach((el) => {
        // 초기값(혹시 CSS가 늦게 먹는 환경 대비)
        gsap.set(el, {
            clipPath: "inset(0 50% 0 50%)",
            opacity: 0,
            y: 10
        });

        gsap.timeline({
            scrollTrigger: {
                trigger: el,
                start: "top 80%",
                toggleActions: "play none none reverse",
                // markers: true
            }
        })
            .to(el, {
                opacity: 1,
                y: 0,
                duration: 0.45,
                ease: "power2.out"
            }, 0)
            .to(el, {
                clipPath: "inset(0 0% 0 0%)", // 가운데 → 양옆
                duration: 0.7,
                ease: "power2.out"
            }, 0);
    });
    //page4 도장
    let tl2 = gsap.timeline({
        scrollTrigger: {
            trigger: ".page4 .flex-wrap",
            start: "top 40%",
            toggleActions: "play none none reset",
            // markers: true,
        }
    });
    tl2.fromTo(".page4 .mark",
        {
            scale: 3,
            opacity: 0,
            filter: "blur(16px)",
        },
        {
            scale: 1,
            opacity: 1,
            filter: "blur(0px)",
            duration: 0.2,
            ease: "power2.in"
        }
    ).to(".page4 .mark", {
        duration: 0.3,
        ease: "power2.out"
    }, "+=0.4");



    // 이미지/폰트 로딩 후 위치 변동 대비
    ScrollTrigger.refresh();
});


