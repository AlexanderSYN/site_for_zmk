<?php 
    require '../helpers/helpers.php';
    
    $msg = new messages();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>РЕГИСТРАЦИЯ</title>

    <!-- ICON -->
    <link rel="icon" href="../../image/icon/favicon.ico" type="image/x-icon"> 

    <!-- SCSS (CSS) -->
    <link href="../../css/accounts/accounts.css" rel="stylesheet" type="text/css" />

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body style="background:#EFEFEF">
    
    <div class="d-flex flex-column justify-content-between min-vh-100">
        
        <!-- HEADER -->
        <header id="up">

            <a href="login">
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
                    <h1>РЕГИСТРАЦИЯ</h1>
                    
                    <div class="wrapper_input">
                        <form method="post" action="/">

                            <!-- notifications -->
                            <?php if ($msg->hasMessage('error')) : ?>
                                <div class="notice error">
                                    <?php echo $msg->getMessage('error'); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($msg->hasMessage('success')) : ?>
                                <div class="notice success">
                                    <?php echo $msg->getMessage('success'); ?>
                                </div>
                                <?php endif; ?>


                            <input type="text" name="name" 
                                class="name_wrapper" 
                                placeholder="Имя" 
                                required
                            />

                            <input type="email" name="email" 
                                class="email_wrapper" 
                                placeholder="Почта" 
                                required
                            />


                            <input type="text" name="login" 
                                class="login_wrapper" 
                                placeholder="Логин" 
                                required
                            />

                            <input type="password" name="password" 
                                class="password_wrapper" 
                                placeholder="Пароль" 
                                required
                            />

                            <button class="btn_entry">
                                ЗАРЕГЕСТРИРОВАТЬСЯ
                            </button>
                        </form>

                        <a href="login.php" class="btn_register">
                            ВОЙТИ
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
