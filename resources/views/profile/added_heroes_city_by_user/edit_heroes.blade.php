<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изменения данных героя</title>

    <!-- ICON -->
    <link rel="icon" href="../../../favicon.ico" type="image/x-icon"> 

    <!-- SCSS (CSS) -->
    @vite('.../../resources/css/accounts/hero/add_hero.css')

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">



</head>

<body style="background-image: url('/image/bg/old-paper-bg.png')">
    
    <div class="d-flex flex-column justify-content-between min-vh-100">
        
        <!-- HEADER -->
        <header id="up">

            <form action="
                @if($hero && $hero->type == "ВОВ")
                    {{ route('added_heroes_page_vov') }}
                @else
                    {{ route('added_heroes_page_svo') }}
                @endif
          " method="post">

                @csrf     
                <button style="background: none; border: none;">
                    <img 
                        class="back_arrow" src="../../../image/back_black_arrow.png" 
                        alt="стрелка назад" width="130px"
                    />

                     <input type="hidden" name="type"
                                value="{{ $hero->type }}" />

                    <input type="hidden" name="city"
                            value="{{ $hero->city }}" />
                </button>
            </form>
        </header>


        <!-- MAIN -->
        <main class="flex-grow-1" >
           <center>
                <div class="wrapper">
                    <h1>ИЗМЕНЕНИЯ ИНФОРМАЦИИ О ГЕРОЯ ({{ $hero->type }})</h1>
                    
                    <div class="wrapper_input">
                        <form action="{{ route('edit_hero_user_in_bd') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <!-- notifications -->
                            <ul>
                       
                                @foreach ($errors->all() as $message)
                                    <div class="notice error">
                                        {{ $message }}
                                    </div>
                                @endforeach
                                 
                            </ul>
                            
                            <input type="hidden" name="id_hero"
                                value="{{ $hero->id }}" />


                            <label class="input-file">
                                <input type="file" name="image_hero" id="get_image_hero" accept="image/*" />
                                <span class="input-file-btn">Выбрать Картинку Героя</span>
                                <span class="input-file-text" id="name_image_hero">картинка выбрана, но вы можете её изменить (Максимум 10МБ)</span>
                                <input type="hidden" name="image_hero" id="img_hero_input" value="{{ $hero->image_hero }}" />
                            </label>

                            <label class="input-file">
                                <input type="file" name="image_hero_qr" id="get_image_hero_qr" accept="image/*" />
                                <span class="input-file-btn_2">Выбрать Картинку QR</span>
                                <span class="input-file-text_2" id="name_image_hero_qr">картинка выбрана, но вы можете её изменить (Максимум 10МБ)</span>
                                <input type="hidden" name="image_hero_qr" id="img_hero_qr_input" value="{{ $hero->image_qr }}" />
                            </label>

                            <input type="text" name="name_hero"
                                placeholder="Введите ФИО или Имя Героя" value="{{ $hero->name_hero }}" required/>

                            <input type="text" name="hero_link"
                                placeholder="Введите Ссылку На Источник" value="{{ $hero->hero_link }}" />

                            <textarea id="description" name="description" class="description_hero"
                                placeholder="Введите Описание Героя" required>{{ $hero->description_hero }}</textarea>
                                
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
    @vite('../../resources/js/add_heroes_city/add_heroes_and_mp')

    <!-- JS BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


</body>
</html>

<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg-->