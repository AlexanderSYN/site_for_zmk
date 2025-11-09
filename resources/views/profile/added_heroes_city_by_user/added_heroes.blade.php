<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавленные Герои</title>


    <!-- ICON -->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon"> 

    <!-- SCSS (CSS) -->
    @vite('resources/css/accounts/heroes.css')

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
                        src="../../image/up_arrow.png"
                        alt="показать меню"
                        loading="lazy"
                    />
                </button>


                <!-- close button -->
                <button class="btn_close_menu" id="btn_close_menu">
                    <img 
                        class="header_btn_close_menu"
                        src="../../image/down_arrow.png"
                        alt="скрыть меню"
                        loading="lazy"
                    />
                </button>
            </div>


            <!-- logo -->
            <a href="/" class="header_logo" id="header_logo">
                <img
                    class="header_logo_image"
                    src="../../image/main-zmc.png"
                    alt="лого ЗМК"
                    loading="lazy"
                />
            </a>


            <nav class="header_menu show" id="header_menu">
                <ul class="header_menu_list">
                    <li class="header_menu_item">

                        <a href="{{ route('main') }}" class="header_menu_link">
                            Главная
                        </a>

                        <a href="{{ route('profile') }}" class="header_menu_link">
                            Профиль
                        </a>
                        
                        <!-- Герои ВОВ -->
                        <a href="{{ route('heroes_vov_profile_city')}}" 
                        style="{{ $type == "ВОВ" ? "color: #413939" : "" }}" class="header_menu_link">
                            Герои ВОВ
                        </a>

                        <!-- Герои СВО -->
                        <a href="{{ route('heroes_svo_profile_city') }}" 
                        style="{{ $type == "СВО" ? "color: #413939" : "" }}" class="header_menu_link">
                            Герои СВО
                        </a>

                        <!-- Памятные Места -->
                        <a href="{{ route('mp_profile_city') }}" class="header_menu_link">
                            Памятные Места
                        </a>    
                    
                    </li>
                </ul>
            </nav>

            <div class="header_actions" id="header_actions">
                @if ($role == "user" || $role == "admin")
                    <!-- btn add_city -->
                    <form action="{{ route('add_heroes_page_svo') }}" method="post">                    
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}" />
                        <input type="hidden" name="city" value="{{ $city_id }}" />
                    
                        <button type="submit" class="btn_add_city_head">
                              ДОБАВИТЬ ГЕРОЯ
                        </button>
                    </form>
                @endif

                <!-- btn logout -->
                <a href="{{ route('logout') }}" class="btn_logout_head" id="header_actions">
                    ВЫЙТИ
                </a>
            </div>
            
        </header>

        <!-- MAIN -->
        <main class="flex-grow-1">
            @include('profile.added_heroes_city_by_user.for_added_heroes.main_added_heroes')
        </main>


        <!-- FOOTER -->
        <footer>

        </footer>


    <!-- JS -->
    @vite('resources/js/for_adaptive/adaptive_menu.js')

    <!-- JS BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>


<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg-->