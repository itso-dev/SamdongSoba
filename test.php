<?php
$site_url = "http://".$_SERVER["HTTP_HOST"]."/db_Solution_New";

$message = '<html><body>
                        <div style="width: 570px; margin: 0 auto; border-radius: 4px; border: 2px solid #0CB2C9; background: #FFF; padding: 15px">
                            <img src="'.$site_url.'/img/email-banner.png" style="width: 100%; margin-bottom: 24px;">
                            <div style="display: flex; gap:8px; align-items: center; margin-bottom: 8px;">
                                <div style="width: 125px; padding: 3px 5px; background: #DFEBF0;color: #11488C;font-size: 18px;font-weight: 600;letter-spacing: -0.45px; text-align: center">
                                    접수일시
                                </div>
                                 <div style="width:calc(100% - 125px); padding: 3px 5px;">
                                    2025년 0월 00일
                                </div>
                            </div>
                             <div style="display: flex; gap:8px; align-items: center; margin-bottom: 24px;">
                                <div style="width: 125px; padding: 3px 5px; background: #DFEBF0;color: #11488C;font-size: 18px;font-weight: 600;letter-spacing: -0.45px; text-align: center">
                                    접수된 웹사이트
                                </div>
                                 <div style="width:calc(100% - 125px); padding: 3px 5px;">
                                    http://websiteaddress.com
                                </div>
                            </div>
                            <p style="color: #505050; font-size: 18px;letter-spacing: -0.45px;font-weight: 400; margin-bottom: 24px;">
                                안녕하세요. 홍길동 담당자님.<br>
                                새로운 문의가 접수되어 아래와 같이 전달드립니다.
                            </p>
                            <div style="display: flex; align-items: center">
                                <div style="width: 140px; padding: 8px 5px; background: #DFEBF0;color: #333;font-size: 18px;font-weight: 600;letter-spacing: -0.45px; text-align: center; background: #A8D0DF;">
                                    DB항목
                                </div>   
                                 <div style="width: calc(100% - 140px); padding: 8px 5px; background: #DFEBF0;color: #333;font-size: 18px;font-weight: 600;letter-spacing: -0.45px; text-align: center; background: #B4DCEA;">
                                    고객정보
                                </div>   
                            </div>
                            <div style="display: flex; align-items: center; border-bottom: 1px solid rgba(0, 0, 0, 0.10);">
                                <div style="width: 140px; padding: 8px 5px; background: #DFEBF0;color: #333;font-size: 18px;font-weight: 400;letter-spacing: -0.45px; text-align: center; background: #EDF0F2;">
                                    이름
                                </div>   
                                 <div style="width: calc(100% - 140px); padding: 8px 5px; background: #DFEBF0;color: #333;font-size: 18px;font-weight: 400;letter-spacing: -0.45px; text-align: center; background: #fff;">
                                    홍길동
                                </div>   
                            </div>
                            <div style="display: flex; align-items: center; border-bottom: 1px solid rgba(0, 0, 0, 0.10);">
                                <div style="width: 140px; padding: 8px 5px; background: #DFEBF0;color: #333;font-size: 18px;font-weight: 400;letter-spacing: -0.45px; text-align: center; background: #EDF0F2;">
                                    연락처
                                </div>   
                                 <div style="width: calc(100% - 140px); padding: 8px 5px; background: #DFEBF0;color: #333;font-size: 18px;font-weight: 400;letter-spacing: -0.45px; text-align: center; background: #fff;">
                                    010-1234-5678
                                </div>   
                            </div>
                            <div style="display: flex; align-items: center; border-bottom: 1px solid rgba(0, 0, 0, 0.10);">
                                <div style="width: 140px; padding: 8px 5px; background: #DFEBF0;color: #333;font-size: 18px;font-weight: 400;letter-spacing: -0.45px; text-align: center; background: #EDF0F2;">
                                    지역
                                </div>   
                                 <div style="width: calc(100% - 140px); padding: 8px 5px; background: #DFEBF0;color: #333;font-size: 18px;font-weight: 400;letter-spacing: -0.45px; text-align: center; background: #fff;">
                                    경기도 용인
                                </div>   
                            </div>
                         </div>
                         
                 </body></html>';



echo $message;


?>
