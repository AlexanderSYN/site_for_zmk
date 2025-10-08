<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ВЫ ЗАБЛОКИРОВАНЫ</title>


    <!-- ICON -->
    <link rel="icon" href="favicon.ico" type="image/x-icon"> 

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


</head>
<body style="background: #272626ff;">
        <header></header>

        <!-- MAIN -->
        <main class="flex-grow-1" style="margin-top: 26rem;">
            <center>
                <div class="banned-container">
                    <h1 style="color: #e81b2fff">🚫 Аккаунт заблокирован 🚫</h1>
                    <h3 style="color: #e81b2fff">Ваш аккаунт был заблокирован администратором.</h3>
                    <h3 style="color: #e81b2fff; margin-bottom: 2rem;">Для получения дополнительной информации обратитесь в поддержку.</h3>
        
                    <a href="{{ route('logout') }}" style="
                        background: #dc3545;
                        color: white;
                        border: none;
                        padding: 10px 20px;
                        border-radius: 5px;
                        cursor: pointer;
                        text-decoration: none;">

                        Выйти из аккаунта

                    </a>
                </div>
            </center>
        </main>


    <!-- FOOTER -->
    <footer>

    </footer>


    <!-- JS BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>


<!-- AUTHORS (АВТОРЫ): Katin Alexander, Kostrin Artem, Skopin Oleg-->