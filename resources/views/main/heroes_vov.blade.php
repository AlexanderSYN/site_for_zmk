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
                        <a href="{{ route('main') }}" class="header_menu_link" style="color:#FFFFFF">
                            Главная
                        </a>
                        
                        <!-- Герои ВОВ -->
                        <a href="{{ route('heroes_vov_choice_city') }}" class="header_menu_link">
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


<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg, Vladimir Batalov -->
<!-- the video was taken from the website (видео взято у сайта): https://may9.ru/ -->
<!-- the icon of arrow was taken from the figma (иконки стрелок взяты у figma): https://figma.com -->
<!-- Иконка взята из карточки маркетплейса yandexmarket -->