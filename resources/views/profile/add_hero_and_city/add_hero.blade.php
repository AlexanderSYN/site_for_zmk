<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавления Города</title>

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

            <a href="{{ $type == "ВОВ" ? route('heroes_vov_profile_city')
                                        : route('heroes_svo_profile_city') }}">
               <img 
                    class="back_arrow" src="../../../image/back_black_arrow.png" 
                    alt="стрелка назад" width="130px"
                />
            </a>
        </header>


        <!-- MAIN -->
        <main class="flex-grow-1" >
           <center>
                <div class="wrapper">
                    <h1>ДОБАВЛЕНИЯ ГЕРОЯ ({{ $type }})</h1>
                    
                    <div class="wrapper_input">
                        <form action="{{ route('add_city_in_BD') }}" method="post">
                            @csrf

                            <!-- notifications -->
                            <ul>
                                @foreach ($errors->all() as $message)

                                    <div class="notice error">
                                        {{ $message }}
                                    </div>
                                @endforeach
                                 
                            </ul>

                            <input type="hidden" name="type"
                                value="{{ $type }}" />

                            <input type="hidden" name="city"
                                value="{{ $city }}" />

                            <label class="input-file">
                                <input type="file" name="image_hero" required />
                                <span class="input-file-btn">Выбрать Картинку Героя</span>
                                <span class="input-file-text">Максимум 10мб</span>
                            </label>

                            <label class="input-file">
                                <input type="file" name="image_hero_qr" required />
                                <span class="input-file-btn_2">Выбрать Картинку QR</span>
                                <span class="input-file-text">Максимум 10мб</span>
                            </label>

                            <input type="text" name="name_hero"
                                placeholder="Введите ФИО или Имя Героя" required/>

                            <input type="text" name="hero_link"
                                placeholder="Введите Ссылку На Источник" />

                            <textarea name="description" class="description_hero"
                                placeholder="Введите Описание Героя" required></textarea>


                            <button class="btn_add">
                                ДОБАВИТЬ
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
    @vite('../../resources/js/for_register/show_hide_password.js')

    <!-- JS BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


</body>
</html>

<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg -->
