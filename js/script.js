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
});


