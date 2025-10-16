<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Защитники Отечества на карте Татарстана</title>


    <!-- ICON -->
    <link rel="icon" href="favicon.ico" type="image/x-icon"> 

    <!-- SCSS (CSS) -->
    @vite('resources/css/style.css')

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


</head>
<body>
    
    <div class="d-flex flex-column justify-content-between min-vh-100">
        
        <!-- HEADER -->
        <header id="up">
            <!-- arrow up and down -->
            <div class="arrows" id="arrows">
                <!-- show menu -->
                <button class="btn_show_menu" id="btn_show_menu">
                    <img 
                        class="header_btn_show_menu"
                        src="image/up_arrow.png"
                        alt="показать меню"
                        loading="lazy"
                    />
                </button>


                <!-- close button -->
                <button class="btn_close_menu" id="btn_close_menu">
                    <img 
                        class="header_btn_close_menu"
                        src="image/down_arrow.png"
                        alt="скрыть меню"
                        loading="lazy"
                    />
                </button>
            </div>


            <!-- logo -->
            <a href="/" class="header_logo" id="header_logo">
                <img
                    class="header_logo_image"
                    src="image/main-zmc.png"
                    alt="лого ЗМК"
                    loading="lazy"
                />
            </a>


            <nav class="header_menu show" id="header_menu">
                <ul class="header_menu_list">
                    <li class="header_menu_item">
                        <a href="/" class="header_menu_link" style="color:#FFFFFF">
                            Главная
                        </a>
                        
                        <!-- Герои ВОВ -->
                        <a href="/" class="header_menu_link">
                            Герои ВОВ
                        </a>

                        <!-- Герои СВО -->
                        <a href="/" class="header_menu_link">
                            Герои СВО
                        </a>

                        <!-- Памятные Места -->
                        <a href="/" class="header_menu_link">
                            Памятные Места
                        </a>              
                    </li>
                </ul>
            </nav>


            <div class="header_actions" id="header_actions">
                <a href="{{ route('profile') }}" class="btn_entry_head" id="header_actions">ВОЙТИ</a>
            </div>
            
        </header>



        <!-- MAIN -->
        <main class="flex-grow-1">
            <!-- Video -->
            <div class="video__bg">
                <video id="myVideo" src="video/video_bg_main.mp4" data-dsrc="../video/video_bg_main.mp4" 
                playsinline="" webkit-playsinline="" preload="metadata" muted="" loop="" 
                autoplay=""></video>
            </div>


            <!-- cards -->
             <div class="main_cards">
                <!-- main part -->
                <h1 class="h1_main">Главные События</h1>
                
                <!-- cards one -->
                <div class="cards_vov">
                    <h1>ВЕЛИКАЯ ОТЕЧЕСТВЕННАЯ ВОЙНА</h1>


                    <h3>«Победа! Это величайшее счастье для солдата — сознание того, 
                        что ты помог своему народу победить врага, отстоять свободу 
                        Родины, вернуть ей мир» (К. К. Рокоссовский)
                    </h3>


                    <img src="image/img_index/image_vov.png" alt="картинка ВОВ" />
                </div>


                <!-- cards two -->
                <div class="cards_svo">
                    <h1>СПЕЦИАЛЬНАЯ ВОЕННАЯ ОПЕРАЦИЯ (СВО)</h1>


                    <h3>Кто бы ни пытался помешать нам, а тем более создать угрозы для
                        нашей страны, должны знать, что ответ России будет незамедлителен.
                        И приведет вас к таким последствиям, с которыми вы в своей истории
                        еще никогда не сталкивались. (Владимир Владимирович Путин)
                    </h3>


                    <img src="image/img_index/image_svo.png" alt="картинка СВО" />
                </div>


                <!-- cards three -->
                <div class="cards_mp">
                    <h1>ПАМЯТНЫЕ МЕСТА</h1>


                    <h3>«Никто не забыт и ничто не забыто» — цитата из стихотворения
                        Ольги Берггольц, написанного в <time>1959</time> году для мемориальной стелы
                        на Пискарёвском кладбище в Ленинграде, где похоронены многие жертвы
                        Ленинградской блокады.
                    </h3>


                    <img src="image/img_index/image_mp.png" alt="картинка Памятные Места" />
                </div>
             </div>
            
            <!-- UP -->
            <a href="#up" class="text_up">
                НАВЕРХ
            </a>
        </main>


        <!-- FOOTER -->
        <footer>
            <div class="container">
                <!-- logo ZMC -->
                <div class="logo">
                    <a href="#up" class="header_logo">
                        <img
                            class="header_logo_image"
                            src="image/main-zmc.png"
                            alt="лого ЗМК"
        
                            loading="lazy"
                        />
                    </a>
                </div>


                <!-- text -->
                <div class="text_footer">
                    <nav class="footer_menu">
                        <ul class="footer_menu_list">
                            <li class="footer_menu_item">

                                <a href="#up" class="footer_menu_link">
                                    Главная
                                </a>

                                <!-- Герои ВОВ -->
                                <a href="/" class="footer_menu_link">
                                    Герои ВОВ
                                </a>

                                <!-- Герои СВО -->
                                <a href="/" class="footer_menu_link">
                                    Герои СВО
                                </a>

                                <!-- Памятные Места -->
                                <a href="/" class="footer_menu_link">
                                    Памятные Места
                                </a>    
                            
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </footer>


        
    </div>


    <!-- JS -->
   @vite('resources/js/for_adaptive/adaptive_menu.js')


    <!-- JS BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>


<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg-->
<!-- the video was taken from the website (видео взято у сайта): https://may9.ru/ -->
<!-- the icon of arrow was taken from the figma (иконки стрелок взяты у figma): https://figma.com -->
<!-- Иконка взята из карточки маркетплейса yandexmarket -->