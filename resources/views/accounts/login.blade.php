<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ВХОД</title>

    <!-- ICON -->
    <link rel="icon" href="favicon.ico" type="image/x-icon"> 

    <!-- SCSS (CSS) -->
    @vite('resources/css/accounts/accounts.css')

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body style="background:#EFEFEF">
    
    <div class="d-flex flex-column justify-content-between min-vh-100">
        
        <!-- HEADER -->
        <header id="up">

            <a href="/">
               <img 
                    class="back_arrow" src="../../image/back_black_arrow.png" 
                    alt="стрелка назад" width="130px"
                />
            </a>
        </header>


        <!-- MAIN -->
        <main class="flex-grow-1" >
           <center>
                <div class="wrapper">
                    <h1>ВХОД</h1>
                    
                    <div class="wrapper_input">
                        <form method="post" action="/">
                            
                            <input type="text" name="login" 
                                class="login_wrapper" 
                                placeholder="Логин" 
                            />

                            <input type="password" name="password" 
                                class="pass_wrapper" 
                                placeholder="Пароль" 
                            />

                            <button class="btn_entry">
                                ВОЙТИ
                            </button>
                        </form>

                        <a href="{{ route('register') }}" class="btn_register">
                            ЗАРЕГЕСТРИРОВАТЬСЯ
                        </a>
                    </div>
                </div>
           </center>
        </main>

        <!-- FOOTER -->
        <footer>
            
        </footer>

        
    </div>

   
    <!-- JS BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg -->
