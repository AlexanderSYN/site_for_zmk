<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавленные Памятные Места</title>


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
                        <a href="{{ route('heroes_vov_profile_city')}}" class="header_menu_link">
                            Герои ВОВ
                        </a>

                        <!-- Герои СВО -->
                        <a href="{{ route('heroes_svo_profile_city') }}" class="header_menu_link">
                            Герои СВО
                        </a>

                        <!-- Памятные Места -->
                        <a href="{{ route('mp_profile_city') }}" style="color: #413939" class="header_menu_link">
                            Памятные Места
                        </a>    
                    
                    </li>
                </ul>
            </nav>


            <div class="header_actions" id="header_actions">
                @if ($role != 'moder')
                    <!-- btn add_city -->
                    <form action="{{ route('add_mp_page') }}" method="post">                    
                        @csrf
                        <input type="hidden" name="city_id" value="{{ $city_id }}" />

                        <button type="submit" class="btn_add_city_head">
                              ДОБАВИТЬ ПМ
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
            <center>
                @if ($city == null)
                    <div class="alert alert-danger">
                        <h4>
                        ❌ERROR: Тип памятного места или город не найден, пожалуйста нажмите 
                        "профиль" и перейдите обратно на эту страницу (используя навигационные ссылки) 
                        или перезайдите на сайт❌
                        </h4>
                    </div>
                @endif
                 @foreach ($errors->all() as $message)
                    <div class="notice error">
                        {{ $message }}
                    </div>
                @endforeach
                @if (session()->has('success'))
                    <div class="notice success">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <h1> Памятные Места
                    ({{ $city != null ? $city : old('city') }}) (Ваши Добавленные Памятные Места)</h1> 

                <div style="background-color: rgba(255, 252, 252, 0.5); 
                    margin-bottom: 0.5rem;
                    font-size: 1.5rem;
                    font-family: inherit;
                    color: #aea6a6;">
                        ВСЕГО {{ $memorable_places->total() }} ПАМЯТНЫХ МЕСТ    
                </div>

                @if ($memorable_places->count() > 0) 
                    @foreach ($memorable_places as $mp)
                        <div class="wrapper_for_hero">
                            @if ($mp->isCheck == 0 )
                                <div class="alert alert-warning">
                                    ⏳Памятное место на проверке⏳
                                </div>
                            @else
                                <div class="alert alert-success">
                                    ✅Памятное место проверено и выложено✅
                                </div>
                            @endif

                            @if ($role == "admin" || $role == "moder")
                                <h3>
                                    Отправил : {{ $mp->user->first_name }} {{ $mp->user->last_name }}
                                    | id: {{ $mp->user->id }}
                                </h3>
                            @endif

                            <h2>{{ $mp->name }}</h2>
                            <h4>{{ $mp->description}}</h4>
            
                            <img class="img_hero" src="{{ asset('storage/' . $mp->image_mp) }}" alt="{{ $mp->name_mp }} (картинка не найден) | " />
            
                            <img class="img_qr" src="{{ asset('storage/' . $mp->image_qr) }}" alt="QR код {{ $mp->name_mp }} (картинка не найден)" />

                            <form action="{{ route('edit_mp_user_page') }}" method="post" >
                                @csrf
                                <input type="hidden" name="id_mp"
                                    value="{{ $mp->id }}" />

                                <button type="submit" class="edit_hero">
                                    ИЗМЕНИТЬ
                                </button>
                            </form>
                            
                           <form action="{{ route('delete_mp') }}" method="post" 
                            onsubmit="return confirm('Вы уверены, что хотите удалить это Памятное Место?')">
                                 @csrf
                                <input type="hidden" name="id_mp"
                                    value="{{ $mp->id }}" />

                                <button type="submit" id="btn_delete" class="delete_hero">
                                    УДАЛИТЬ
                                </button>
                            </form>

                            
                        </div>
                    @endforeach

                    <!-- pagination -->
                   
                    <div>
                        <div style="
                            background-color: rgba(255, 252, 252, 0.5); 
                            margin-bottom: 0.5rem;
                            font-size: 1.5rem;
                            font-family: inherit;
                            color: #aea6a6;">
                                ВСЕГО {{ $memorable_places->total() }} ПАМЯТНЫХ МЕСТ    
                        </div>

                        <div style="display: grid;justify-content: center;">
                            {!! $memorable_places->links('vendor.pagination.bootstrap-4') !!}
                        </div>
                    </div>
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