<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изменения информации о городе</title>

    <!-- ICON -->
    <link rel="icon" href="../../../favicon.ico" type="image/x-icon"> 

    <!-- SCSS (CSS) -->
    @vite('../../resources/css/accounts/hero/add_hero.css')

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">



</head>
<!-- style="background:#EFEFEF" -->
<body style="background-image: url('/image/bg/old-paper-bg.png')">
    
    <div class="d-flex flex-column justify-content-between min-vh-100">
        
        <!-- HEADER -->
        <header id="up">
            <a href=" 
                    @if ($city->type == "ВОВ")   
                        {{ route('heroes_vov_profile_city') }}
                    @elseif ($city->type == "СВО")
                        {{ route('heroes_svo_profile_city') }}
                    @else
                        {{ route('mp_profile_city') }}
                    @endif
                    ">
                <button style="background: none; border: none;">
                    <img 
                        class="back_arrow" src="../../../image/back_black_arrow.png" 
                        alt="стрелка назад" width="130px"
                    />
                </button>
            </a>
        </header>


        <!-- MAIN -->
        <main class="flex-grow-1" >
           <center>
                <div class="wrapper">
                    <h1>ИЗМЕНЕНИЯ ИНФОРМАЦИИ О ГОРОДЕ ({{ $city->city }})({{ $city->type }})</h1>
                    
                    <div class="wrapper_input">
                        <form action="{{ route('edit_city_data_in_bd') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id_city" 
                                value="{{ $city->id }}" />

                            <!-- notifications -->
                            <ul>
          
                                @foreach ($errors->all() as $message)
                                    <div class="notice error">
                                        {{ $message }}
                                    </div>
                                @endforeach
                                 
                            </ul>
                            
                            @if ($role == "user" || $role == "moder")
                                <input type="text" 
                                    placeholder="Введите Название Города" value="{{ $city->city }}" required disabled />

                            @else
                                <input type="text" name="name_city"
                                    placeholder="Введите Название Города" value="{{ $city->city }}" required />        
                            @endif

                            <textarea id="description" name="description_city" class="description_mp"
                                placeholder="Введите Описание Города" value="{{ $city->description }}" required>{{ $city->description }}</textarea>
                            <p class="max_symbols" id="max_symbols">символов 0 / 500</p>


                            <button class="edit_hero" id="btn_add">
                                ИЗМЕНИТЬ
                            </button>
                        </form>
                    </div>
                </div>
           </center>
        </main>

        <!-- FOOTER -->
        <footer>
            
        </footer>

        
    </div>

    <!-- JS -->
    @vite('../../resources/js/helpers/helper_symbols.js')

    <!-- JS BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


</body>
</html>

<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg-->