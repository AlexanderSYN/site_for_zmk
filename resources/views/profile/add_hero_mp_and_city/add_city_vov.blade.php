<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавления Города</title>

    <!-- ICON -->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon"> 

    <!-- SCSS (CSS) -->
    @vite('../../resources/css/accounts/accounts.css')

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<!-- style="background:#EFEFEF" -->
<body style=" background-image: url('/image/bg/old-paper-bg.png')">
    
    <div class="d-flex flex-column justify-content-between min-vh-100">
        
        <!-- HEADER -->
        <header id="up">

            <a href="{{ route('heroes_vov_profile_city') }}">
               <img 
                    class="back_arrow" src="../../image/back_black_arrow.png" 
                    alt="стрелка назад" width="130px"
                />
            </a>
        </header>


        <!-- MAIN -->
        <main class="flex-grow-1" >
           <center>
                <div class="wrapper_register">
                    <h1>ДОБАВЛЕНИЯ ГОРОДА</h1>
                    
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

                            <input type="hidden" name="content"
                                value="ВОВ" />

                            <input type="text" name="city"
                                placeholder="Введите город" required/>

                            <textarea name="description" id="description" class="description_city"
                            placeholder="Введите Описание Города" required></textarea>
                            <p class="max_symbols" id="max_symbols">символов 0 / 500</p>

                            <button class="btn_entry" id="btn_add">
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
    @vite('../../resources/js/helpers/helper_symbols.js')

    <!-- JS BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


</body>
</html>

<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg -->
