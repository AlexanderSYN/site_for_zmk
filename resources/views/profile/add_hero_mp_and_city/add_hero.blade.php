<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавления Героя</title>

    <!-- ICON -->
    <link rel="icon" href="../../../favicon.ico" type="image/x-icon"> 

    <!-- SCSS (CSS) -->
    @vite('.../../resources/css/accounts/hero/add_hero.css')

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">



</head>
<!-- style="background:#EFEFEF" -->
<body style=" background-image: url('/image/bg/old-paper-bg.png')">
    
    <div class="d-flex flex-column justify-content-between min-vh-100">
        
        <!-- HEADER -->
        <header id="up">

            <form action="{{ $type == "ВОВ" ? route('added_heroes_page_vov')
                                        : route('added_heroes_page_svo') }}" method="post">

                @csrf     
                <button style="background: none; border: none;">
                    <img 
                        class="back_arrow" src="../../../image/back_black_arrow.png" 
                        alt="стрелка назад" width="130px"
                    />

                     <input type="hidden" name="type"
                                value="{{ $type == null ? session()->get('type') : $type  }}" />

                    <input type="hidden" name="city"
                            value="{{ $city_id == null ? session()->get('city_id') : $city_id  }}" />
                </button>
            </form>
        </header>


        <!-- MAIN -->
        <main class="flex-grow-1" >
           <center>
                <div class="wrapper">
                    @if ($city_id == null || $type == null)
                        <div class="alert alert-danger">
                            <h4>
                            ❌ERROR: Тип героя или город не найден, пожалуйста 
                            перезайдите на сайт, или перейдите на вкладку профиля
                            , или просто нажмите на кнопку назад!❌
                            </h4>
                        </div>
                    @endif
                    <h1>ДОБАВЛЕНИЯ ГЕРОЯ ({{ $type == null ? session()->get('type') : $type }})</h1>
                    
                    <div class="wrapper_input">
                        <form action="{{ route('add_heroes_in_BD') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <!-- notifications -->
                            <ul>
                                @foreach ($errors->all() as $message)
                                    <div class="notice error">
                                        {{ $message == "validation.required" ? "Вы что-то забыли указать!" :
                                            $message }}
                                    </div>
                                @endforeach

                                @if (session()->has('success'))
                                   <div class="notice success">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif
                                 
                            </ul>

                            <input type="hidden" name="type"
                                value="{{ $type == null ? session()->get('city') : $type }}" />

                            <input type="hidden" name="city"
                                value="{{ $city_id == null ? session()->get('city_id') : $city_id  }}" />

                            <label class="input-file">
                                <input type="file" name="image_hero" id="get_image_hero" accept="image/*" required />
                                <span class="input-file-btn">Выбрать Картинку Героя</span>
                                <span class="input-file-text" id="name_image_hero">Максимум 10МБ</span>
                                <input type="hidden" name="image_hero" id="img_hero_input" value="" />
                            </label>

                            <label class="input-file">
                                <input type="file" name="image_hero_qr" id="get_image_hero_qr" accept="image/*" required />
                                <span class="input-file-btn_2">Выбрать Картинку QR</span>
                                <span class="input-file-text_2" id="name_image_hero_qr">Максимум 10МБ</span>
                                <input type="hidden" name="image_hero_qr" id="img_hero_qr_input" value="" />
                            </label>

                            <input type="text" name="name_hero"
                                placeholder="Введите ФИО или Имя Героя" value="{{ old('name_hero') }}" required/>

                            <input type="text" name="hero_link"
                                placeholder="Введите Ссылку На Источник (который в qr коде)" value="{{ old('hero_link') }}" />

                            <textarea id="description" name="description" class="description_hero"
                                placeholder="Введите Описание Героя" value="{{ old('description') }}" required></textarea>
                            <p class="max_symbols" id="max_symbols">символов 0 / 500</p>


                            @if ($city_id == null || $type == null)
                                <button class="btn_add_off" id="btn_add" disabled>
                                    ДОБАВИТЬ
                                </button>
                            @else
                                <button class="btn_add" id="btn_add">
                                    ДОБАВИТЬ
                                </button>
                            @endif
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
    @vite('../../resources/js/add_heroes_city/add_heroes_and_mp')

    <!-- JS BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


</body>
</html>

<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg -->
