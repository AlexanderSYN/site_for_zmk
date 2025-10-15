<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>


    <!-- ICON -->
    <link rel="icon" href="favicon.ico" type="image/x-icon"> 

    <!-- SCSS (CSS) -->
    @vite('resources/css/accounts/profile.css')

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

                        <a href="{{ route('profile') }}" style="color: #413939" class="header_menu_link">
                            Профиль
                        </a>
                        
                        <!-- Герои ВОВ -->
                        <a href="{{ route('heroes_vov_profile_city')}}" class="header_menu_link">
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
                <!-- btn logout -->
                <a href="{{ route('logout') }}" class="btn_logout_head" id="header_actions">
                    ВЫЙТИ
                </a>
            </div>
            
        </header>



        <!-- MAIN -->
        <main class="flex-grow-1">
            <center>
                <div class="wrapper_for_profile_info">
                    <form action="{{ route('change_data') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h1>ВАШ ПРОФИЛЬ</h1>
                
                        <label class="profile_name">ИМЯ: </label>
                        <input type="text" class="profile_name_input"
                            name="first_name"
                            id="profile_name" 
                            value="{{ $user->first_name }}"
                            disabled /> 
 
                        <label class="profile_last_name">ФАМИЛИЯ: </label>
                        <input type="text" class="profile_last_name_input"
                            name="last_name"
                            id="profile_last_name" 
                            value="{{ $user->last_name }}"
                            disabled /> 
                    
                        <label class="profile_patronymic">ОТЧЕСТВО: </label>
                        <input type="text" class="profile_patronymic_input" 
                            id="profile_patronymic" 
                            name="patronymic"
                            value="{{ $user->patronymic }}"
                            disabled /> 
 
                        <label class="profile_login">ЛОГИН: </label>
                        <input type="text" class="profile_login_input" 
                            id="profile_login" 
                            name="login"
                            value="{{ $user->login }}"
                            disabled /> 
                    
                        <label class="profile_email">ПОЧТА: </label>
                        <input type="text" class="profile_email_input" 
                            id="profile_email"
                            name="email"
                            value="{{ $user->email }}"
                            disabled /> 
                    
                        <a class="btn_edit" 
                            id="btn_edit">
                                ИЗМЕНИТЬ
                        </a> 

                        <button class="btn_done"
                            id="btn_done"
                            type="submit" disabled>
                                ГОТОВО
                        </button>  
                    </form>
                </div>
            </center>
        </main>


        <!-- FOOTER -->
        <footer>

        </footer>


    <!-- JS -->
    @vite('resources/js/for_adaptive/adaptive_menu.js')
    @vite('resources/js/for_change_data_profile/helper_change_data_profile.js');

    <!-- JS BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>


<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg-->