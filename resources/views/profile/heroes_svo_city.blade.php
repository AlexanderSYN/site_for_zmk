<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выбор Города</title>


    <!-- ICON -->
    <link rel="icon" href="../favicon.ico" type="image/x-icon"> 

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
                        src="../image/up_arrow.png"
                        alt="показать меню"
                        loading="lazy"
                    />
                </button>


                <!-- close button -->
                <button class="btn_close_menu" id="btn_close_menu">
                    <img 
                        class="header_btn_close_menu"
                        src="../image/down_arrow.png"
                        alt="скрыть меню"
                        loading="lazy"
                    />
                </button>
            </div>


            <!-- logo -->
            <a href="/" class="header_logo" id="header_logo">
                <img
                    class="header_logo_image"
                    src="../image/main-zmc.png"
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
                        <a href="{{ route('heroes_vov_profile_city')}}" class="header_menu_link">
                            Герои ВОВ
                        </a>

                        <!-- Герои СВО -->
                        <a href="{{ route('heroes_svo_profile_city') }}" style="color: #413939" class="header_menu_link">
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
                <!-- btn add_city -->
                <form action="{{ route('add_city') }}" method="post">                    
                    @csrf
                    <input type="hidden" name="name_hero" value="СВО" />

                    <button type="submit" class="btn_add_city_head">
                          ДОБАВИТЬ ГОРОД
                    </button>
                </form>


                <!-- btn logout -->
                <a href="{{ route('logout') }}" class="btn_logout_head" id="header_actions">
                    ВЫЙТИ
                </a>
            </div>
            
        </header>



        <!-- MAIN -->
        <main class="flex-grow-1">
            <center>
                <h1>Герои СВО (Выберите Город)</h1>

            @if($heroesSvo->count() > 0)
                @foreach ($heroesSvo as $heroSvo)
                    <div class="card_body">
                            <h5 class="card_title">Город: {{ $heroSvo->city }} ({{ $heroSvo->type }})</h5>
                            <p class="card_text">
                                <!-- we get the user's name through the link -->
                        
                                {{ $heroSvo->user->first_name == $user->first_name ? "Добавили: Вы" : 'Добавил(-а): ' . $heroSvo->user->first_name}} 
                                {{ $heroSvo->user->last_name == $user->last_name ? ' ' : $heroSvo->user->last_name }}
                                <br>
                                <small class="text-muted">
                                    Создано: {{ $heroSvo->created_at->format('d.m.Y H:i') }}
                                </small>
                            </p>
                            <form action="/" method="post">
                            
                                <input type="hidden" name="city" 
                                value="{{ $heroSvo->city }}" />

                                <button type="button" class="btn_go">
                                    Перейти
                                </button>
                            </form>
                        </div>
                @endforeach
            @else
                <div class="alert alert-info">
                    Нет данных для отображения
                </div>
            @endif
            </center>
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