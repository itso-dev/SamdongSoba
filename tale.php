</div>
        </div>

    <div id="floating-container">
        <div class="floating-form floating-pc">
            <div class="floating-num">
                <p><span>빠른 창업 문의</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                <path d="M11 6.5L0 0V12L11 6.5Z" fill="#5B373B"/>
                </svg>
                </p>
            </div>
            <form class="floating-contact" name="contact_form" id="contact_form2" method="post" action="contact_write.php">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-2">
                <input type="hidden" name="writer_ip" value="<?= get_client_ip() ?>" />
                <input type="hidden" name="adCode" value="<?= $adCode ?>" />
                <input type="hidden" name="flow" value="<?= $flow ?>" />
                <input type="hidden" name="client_key" value="<?= $client_key ?>" />
                <input type="hidden" name="stay_time" id="stay_time2" value="0" />

                <div class="input-wrap">
                    <input type="text" name="name" placeholder="성함" required>
                    <input type="text" name="phone" placeholder="연락처" id="phone-input2" required maxlength="11" inputmode="numeric">
                    <input type="text" name="location" placeholder="창업희망지역" required>
                </div>
                <div class="floating-form-wrap">
                    <div class="floating-agree-wrap">
                        <label class="checkbox-label">
                            <input class="round-checkbox" type="checkbox" id="fixed-agree" name="fixed-agree" required>
                        </label>
                        <label for="fixed-agree" class="agree"><span class="agree-open">개인정보처리방침</span>에 동의</label>
                    </div>
                    <input type="submit" value="창업문의" class="f-btn">
                </div>
            </form>
        </div>


        <div class="floating-form floating-mo">

            <form class="floating-contact" name="contact_form" id="contact_form3" method="post" action="contact_write.php">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-2">
                <input type="hidden" name="writer_ip" value="<?= get_client_ip() ?>" />
                <input type="hidden" name="adCode" value="<?= $adCode ?>" />
                <input type="hidden" name="flow" value="<?= $flow ?>" />
                <input type="hidden" name="client_key" value="<?= $client_key ?>" />
                <input type="hidden" name="stay_time" id="stay_time2" value="0" />


                <div class="floating-num">
                    <p><span>빠른 창업 문의</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                            <path d="M11 6.5L0 0V12L11 6.5Z" fill="#5B373B"/>
                        </svg>
                    </p>
                    <div class="floating-agree-wrap">
                        <label class="checkbox-label">
                            <input class="round-checkbox" type="checkbox" id="fixed-agree" name="fixed-agree" required>
                        </label>
                        <label for="fixed-agree" class="agree"><span class="agree-open">개인정보처리방침</span>에 동의</label>
                    </div>
                </div>

                <div class="input-wrap">
                    <input type="text" name="name" placeholder="성함" required>
                    <input type="text" name="phone" placeholder="연락처" id="phone-input2" required maxlength="11" inputmode="numeric">
                    <input type="text" name="location" placeholder="창업희망지역" required>
                    <input type="submit" value="창업문의" class="f-btn">

                </div>
            </form>
        </div>
    </div>

    <!-- <div id="go-contact">
        문의하기
    </div> -->

    <div class="modal-bg"></div>

</body>

<footer>
    <div class="footer-big-container">
        <div class="footer-container">
            <div class="footer-wrapper">
                <img src="img/head-logo.png" class="footer-logo" alt="삼동소바">
                <div class="footer-inner">
                    <p class="tit">회사정보</p>
                    <div class="footer-div">
                        (주)삼동에프앤비
                    </div>
                    <div class="footer-div">
                        대표 : 표재수
                    </div>
                    <div class="footer-div">
                        사업자등록번호 : 580-88-02142
                    </div>
                    <div class="footer-div">
                        주소 : 경기도 용인시 수지구 동천동 716-4
                    </div>
                </div>
            </div>
            <div class="footer-inner">
                <div class="footer-contact">
                    <div>
                        소셜미디어
                    </div>
                    <a href="https://www.instagram.com/samdongsoba_official/" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                            <path d="M17.717 21.8691L7.30036 21.879C5.00869 21.8811 3.13213 20.0082 3.12953 17.7165L3.11963 7.29987C3.11755 5.0082 4.99046 3.13164 7.28213 3.12904L17.6988 3.11914C19.9905 3.11706 21.867 4.98998 21.8696 7.28164L21.8795 17.6983C21.8821 19.9905 20.0087 21.8671 17.717 21.8691Z" fill="url(#paint0_radial_119_746)"/>
                            <path d="M17.717 21.8691L7.30036 21.879C5.00869 21.8811 3.13213 20.0082 3.12953 17.7165L3.11963 7.29987C3.11755 5.0082 4.99046 3.13164 7.28213 3.12904L17.6988 3.11914C19.9905 3.11706 21.867 4.98998 21.8696 7.28164L21.8795 17.6983C21.8821 19.9905 20.0087 21.8671 17.717 21.8691Z" fill="url(#paint1_radial_119_746)"/>
                            <path d="M12.4998 16.1452C10.4899 16.1452 8.854 14.5098 8.854 12.4993C8.854 10.4889 10.4899 8.85352 12.4998 8.85352C14.5097 8.85352 16.1457 10.4889 16.1457 12.4993C16.1457 14.5098 14.5097 16.1452 12.4998 16.1452ZM12.4998 9.89518C11.0639 9.89518 9.89567 11.0634 9.89567 12.4993C9.89567 13.9353 11.0639 15.1035 12.4998 15.1035C13.9358 15.1035 15.104 13.9353 15.104 12.4993C15.104 11.0634 13.9358 9.89518 12.4998 9.89518Z" fill="white"/>
                            <path d="M16.4062 9.375C16.8377 9.375 17.1875 9.02522 17.1875 8.59375C17.1875 8.16228 16.8377 7.8125 16.4062 7.8125C15.9748 7.8125 15.625 8.16228 15.625 8.59375C15.625 9.02522 15.9748 9.375 16.4062 9.375Z" fill="white"/>
                            <path d="M15.6248 19.2702H9.37484C7.36494 19.2702 5.729 17.6348 5.729 15.6243V9.37435C5.729 7.36393 7.36494 5.72852 9.37484 5.72852H15.6248C17.6347 5.72852 19.2707 7.36393 19.2707 9.37435V15.6243C19.2707 17.6348 17.6347 19.2702 15.6248 19.2702ZM9.37484 6.77018C7.9389 6.77018 6.77067 7.93841 6.77067 9.37435V15.6243C6.77067 17.0603 7.9389 18.2285 9.37484 18.2285H15.6248C17.0608 18.2285 18.229 17.0603 18.229 15.6243V9.37435C18.229 7.93841 17.0608 6.77018 15.6248 6.77018H9.37484Z" fill="white"/>
                            <defs>
                                <radialGradient id="paint0_radial_119_746" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(10.0936 21.8926) scale(23.3849)">
                                    <stop stop-color="#FFDD55"/>
                                    <stop offset="0.328" stop-color="#FF543F"/>
                                    <stop offset="0.348" stop-color="#FC5245"/>
                                    <stop offset="0.504" stop-color="#E64771"/>
                                    <stop offset="0.643" stop-color="#D53E91"/>
                                    <stop offset="0.761" stop-color="#CC39A4"/>
                                    <stop offset="0.841" stop-color="#C837AB"/>
                                </radialGradient>
                                <radialGradient id="paint1_radial_119_746" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(6.13838 2.88492) scale(15.5276 10.346)">
                                    <stop stop-color="#4168C9"/>
                                    <stop offset="0.999" stop-color="#4168C9" stop-opacity="0"/>
                                </radialGradient>
                            </defs>
                        </svg>
                        인스타그램
                    </a>
                </div>
            </div>
            <div class="footer-inner">
                <div class="footer-contact">
                    <div>
                        고객센터
                    </div>
                    <p>대표번호 :  1800-8148</p>
                </div>
            </div>
        </div>
        <p class="copyright">  Copyright ⓒ(주)삼동에프앤비. ALL RIGHTS RESERVED.</p>
    </div>

    <div class="up-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
        <path d="M20 6.125L19.425 6.675L10.725 15.4C10.4875 15.5938 10.3781 15.9031 10.4469 16.2031C10.5156 16.5 10.75 16.7344 11.0469 16.8031C11.3469 16.8719 11.6562 16.7625 11.85 16.525L19.2 9.175V32.8C19.1969 33.0875 19.3469 33.3563 19.5969 33.5031C19.8469 33.6469 20.1531 33.6469 20.4031 33.5031C20.6531 33.3563 20.8031 33.0875 20.8 32.8V9.175L28.15 16.525C28.3437 16.7625 28.6531 16.8719 28.9531 16.8031C29.25 16.7344 29.4843 16.5 29.5531 16.2031C29.6218 15.9031 29.5125 15.5938 29.275 15.4L20.575 6.675L20 6.125Z" fill="#BB3F4F"/>
        </svg>
    </div>
</footer>

<div class="agree-modal">
    <div class="agree-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 37 37" fill="none">
            <path d="M30.6 6.3999L6.59998 30.3999" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M30.6 30.3999L6.59998 6.3999" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </div>
    <div class="title">
        <img src="img/head-logo2.png" class="agree-logo">
        <b class="p40">개인정보처리방침</b>
    </div>
    <div class="content-div">
        <div class="content p16 sub">
            삼동소바(이하 “회사”)는 「개인정보보호법」, 「정보통신망 이용촉진 및 정보보호 등에 관한 법률」(이하 “정보통신망법”) , 「위치정보의 보호 및 이용 등에 관한 법률」(이하 “위치정보법”) 등 관련 법령상의 개인정보 보호규정을 준수하며, 개인정보보호법에 의거한 개인정보처리방침을 정하여 이용자 권익 보호에 최선을 다하고 있습니다. 본 개인정보처리방침은 회사가 제공하는 웹서비스에 적용되며 다음과 같은 내용을 포함하고 있습니다.<br>
            <br>
            1. 개인정보 수집 및 이용 현황 가. 회사는 서비스 제공을 위한 최소한의 범위 내에서 이용자의 동의 하에 개인정보를 수집하며, 수집한 모든 개인정보는 고지한 목적 범위 내에서만 사용됩니다. 또한, 제공하는 서비스(채용 정보제공 등) 특성상 「근로기준법」에 따라 만15세 미만인 경우 회원가입을 허용하지 않습니다. 회사에서 제공하는 서비스 유형에 따라 다음과 같이 개인정보를 수집, 이용, 보유 및 파기하고 있습니다. <서비스 이용에 따른 자동 수집 및 생성 정보><br>
                2. 개인정보 제3자 제공 회사는「1. 개인정보 수집 및 이용 현황」에서 고지한 범위 내에서만 개인정보를 이용하며, 원칙적으로 이용자의 개인정보를 제3자에게 제공하지 않습니다. 다만, 아래의 경우에는 예외로 합니다. 가. 이용자가 서비스 이용중 제3자 제공에 동의(수락)한 경우 나. 법령의 규정에 의거하거나, 수사 목적으로 법령에 정해진 절차와 방법에 따라 수사기관의 요구가 있는 경우 귀하께서는 개인정보의 제3자 제공에 대해, 동의하지 않을 수 있고 언제든지 제3자 제공 동의를 철회할 수 있습니다. 다만, 제3자 제공에 기반한 관련된 일부 서비스의 이용이 제한될 수 있습니다.(회원가입 서비스는 이용하실 수 있습니다.)<br>
                3. 개인정보 처리위탁 회사는 개인정보의 처리와 관련하여 아래와 같이 업무를 위탁하고 있으며, 관계법령에 따라 위탁 처리되는 개인정보가 안전하게 관리될 수 있도록 필요한 조치를 취하고 있습니다. 또한 위탁 처리하는 정보는 서비스 제공에 필요한 최소한의 범위에 국한됩니다. 회사에서 위탁처리 되고 있는 업무는 다음과 같고, 위탁사항이 변경되는 경우 해당 사실을 알려드리겠습니다.<br>
                4. 개인정보 보유 및 이용기간 회사는 이용자의 개인정보를 고지 및 동의 받은 사항에 따라 수집∙이용 목적이 달성되기 전 또는 이용자의 탈퇴 요청이 있기 전까지 해당 정보를 보유합니다. 다만, 아래의 사유로 인하여 보관이 필요한 경우 외부와 차단된 별도 DB 또는 테이블에 분리 보관 됩니다. 가. 관련 법령에 의한 개인정보 보유 1) 통신비밀보호법 · 서비스 이용기록, 접속로그, 접속IP정보 : 3개월 2) 전자상거래 등에서의 소비자보호에 관한 법률 · 표시∙광고에 관한 기록 : 6개월 · 계약 또는 청약철회 등에 관한 기록 : 5년 · 대금결제 및 재화등의 공급에 관한 기록 : 5년 · 소비자의 불만 또는 분쟁처리에 관한 기록 : 3년 3) 부가가치세법 · 세금계산서, 영수증 등 거래내역 관련 정보 : 5년<br>
                5. 개인정보 파기절차 및 방법 이용자의 개인정보는 원칙적으로 개인정보 수집 및 이용목적이 달성되면 지체없이 파기 합니다. 다만, 다른 법령에 의해 보관해야 하는 정보는 법령이 정한 기간 동안 별도 분리보관 후 파기합니다. 가. 파기절차 및 기한 · 수집·이용목적이 달성된 개인정보는 지체없이 파기되며, 관련 법령에 따라 보관되어야 할 경우 별도의 DB에 옮겨져 내부 규정 및 관련 법령을 준수하여 일정기간동안 안전하게 보관된 후 지체없이 파기됩니다. 이때, DB로 옮겨진 개인정보는 법률에 의한 경우를 제외하고 다른 목적으로 이용하지 않습니다. 나. 파기방법 · 전자적 파일 형태의 정보는 복구 및 재생할 수 없는 기술적 방법을 사용하여 완전하게 삭제합니다. · 종이에 출력된 개인정보는 분쇄기로 분쇄하거나 소각을 통하여 파기합니다.<br>
                6. 이용자 권리 및 행사방법 이용자는 정보주체로서 홈페이지를 통해 언제든지 아래의 권리를 행사할 수 있으며, 회사는 관련된 상담 및 문의 처리를 위해 별도의 고객센터를 운영하고 있습니다.<br>
                7. 자동 수집되는 개인정보 및 거부에 관한 사항 회사는 이용자 맞춤서비스를 제공하기 위하여 쿠키(cookie)를 설치 및 운영합니다. 쿠키의 사용 목적과 거부에 관한 사항은 아래와 같습니다. 가. 쿠키란? 쿠키는 웹사이트를 운영하는데 이용되는 서버가 이용자의 브라우저에 보내는 아주 작은 텍스트 파일로서 이용자의 컴퓨터에 저장되어 운영됩니다. 나. 쿠키의 사용 목적 이용자들의 접속관리, 이용자별 사용 환경 제공, 이용자 활동정보 파악, 이벤트 및 프로모션 통계를 파악하여 최적화된 맞춤형 서비스를 제공하기 위해 사용합니다. 다. 쿠키의 설치·운영 및 거부 서비스를 이용함에 있어 이용자는 쿠키 설치에 대한 선택권을 가지고 있습니다. 이용자는 웹브라우저에서 옵션을 설정함으로써 모든 쿠키를 허용 또는 거부 하거나, 쿠키가 저장될 때마다 확인을 거치도록 할 수 있습니다. 쿠키 설치 허용 여부를 지정하는 방법은 다음과 같습니다. · Internet Explorer : 웹 브라우저 상단 도구 메뉴 > 인터넷 옵션 > 개인정보 > 개인정보처리 수준 설정 · Chrome : 웹 브라우저 우측 설정 메뉴 > 도구 > 인터넷 사용기록 삭제<br>
                8. 개인정보의 보호조치에 관한 사항 회사는 이용자의 개인정보가 분실, 도난, 유출, 위∙변조 또는 훼손되지 않도록 안전성 확보를 위하여 정보통신망법, 개인정보보호법 등 정보통신서비스 제공자가 준수하여야 할 관련 법령에 따라 기술적∙관리적 보호조치를 적정하게 취하고 있습니다. 가. 기술적 대책 · 고객의 개인정보는 비밀번호에 의해 보호되며 파일 및 전송데이터를 암호화하거나 파일 잠금기능(Lock)을 사용하여 중요한 데이터는 별도의 보안기능을 통해 보호되고 있습니다. · 회사는 백신프로그램을 이용하여 컴퓨터바이러스에 의한 피해를 방지하기 위한 조치를 취하고 있습니다. 백신프로그램은 주기적으로 업데이트되며 갑작스런 바이러스가 출현할 경우 백신이 나오는 즉시 이를 제공함으로써 개인정보가 침해되는 것을 방지하고 있습니다. · 회사는 네트워크 상의 개인정보를 안전하게 전송할 수 있는 전송구간 암호화(SSL)를 통해 전송하고 있습니다. · 해킹 등 외부침입에 대비하여 침입차단시스템 등을 이용하여 보안에 만전을 기하고 있습니다. 나. 관리적 대책 · 회사는 개인정보 취급자를 최소한의 인원으로 제한하며, 개인정보를 처리하는 직원을 대상으로 새로운 보안 기술 습득 및 개인정보 보호 의무 등에 관해 정기적인 교육을 실시하고 있습니다. · 입사 시 전 직원의 보안서약서를 통하여 사람에 의한 정보유출을 사전에 방지하고 개인정보처리방침에 대한 이행사항 및 직원의 준수여부를 감시하기 위한 내부절차를 마련하고 있습니다. · 개인정보취급자의 업무 인수인계는 보안이 유지된 상태에서 철저하게 이뤄지고 있으며 입사 및 퇴사 후 개인정보 사고에 대한 책임을 명확히 하고 있습니다. · 전산실 및 자료 보관실 등을 특별 보호구역으로 설정하여 출입을 통제하고 있습니다. · 그 외 내부 관리자의 실수나 기술관리 상의 사고로 인해 개인정보의 분실, 도난, 유출, 위∙변조 또는 훼손될 경우 회사는 즉각 이용자에게 사실을 알리고 적절한 대책과 보상을 강구할 것입니다.<br>
                9. 개인정보 보호책임자 연락처 및 이용자 고충 처리 회사의 서비스를 이용하시면서 발생한 모든 개인정보보호 관련 민원, 불만처리 등에 관한 사항을 개인정보 보호책임자 및 고객센터로 문의하실 수 있고, 회사는 이용자의 문의에 신속하고 성실하게 답변하겠습니다.
        </div>
    </div>
</div>

<div class="modal-bg"></div>

<script>
    $(".up-btn").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

    $(".recruit-btn").click(function (){
        $('html, body').animate({
            scrollTop: $('#contact').offset().top
        }, 500);
    });

    $(".agree-open").click(function (){
        event.preventDefault();
        $(".modal-bg").show();
        $(".agree-modal").fadeIn(500);
        $("html").css("overflow", "hidden");
    });

    $(".agree-close").click(function (){
        $(".modal-bg").fadeOut(500);
        $(".agree-modal").fadeOut(500);
        $("html").css("overflow", "auto");
    });

    window.addEventListener('scroll', function() {
        let scroll = window.scrollY;

        const fixedContact = document.querySelector('#floating-container');
        const contactSection = document.querySelector('#contact');
        const sectionTop = contactSection.offsetTop;
        const sectionBottom = sectionTop + contactSection.offsetHeight;
        const scrollPosition = window.scrollY + window.innerHeight / 1;

        if (scrollPosition >= sectionTop && scrollPosition <= sectionBottom) {
            fixedContact.style.display = 'none';
        } else {
            fixedContact.style.display = 'flex';
        }

    });

    const phoneInput2 = document.getElementById('phone-input2');

    phoneInput2.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // 페이지 진입 시간 저장
    const pageEnterTime2 = Date.now();

    document.querySelector("#contact_form2").addEventListener("submit", function(e) {
        e.preventDefault(); // 기본 제출 방지

        const phone = phoneInput2.value.trim();

        if (!/^\d{11}$/.test(phone)) {
            alert('휴대폰 번호는 숫자 11자리로 입력해주세요.');
            e.preventDefault();
            phoneInput2.focus();
            return false;
        }

        const now = Date.now();
        const staySeconds = Math.floor((now - pageEnterTime2) / 1000);

        document.getElementById('stay_time2').value = staySeconds;

        // grecaptcha.ready(function () {
        //     grecaptcha.execute('', {action: 'contact_form2'}).then(function(token) {
        //         document.getElementById('g-recaptcha-response-2').value = token;
        //         e.target.submit();
        //     });
        // });

        e.target.submit();

    });

</script>

