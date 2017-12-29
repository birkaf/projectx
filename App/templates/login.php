<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $title; ?></title>

    <!-- Bootstrap -->
    <link href="../moderate/App/templates/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
            <?php if (isset($errors)): ?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Ошибка!</strong><br>
                    <?php foreach ($errors as $error): ?>
                        <div class="alert alert-danger">
                            <?php echo $error->getMessage(); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Пожалуйста авторизируйтесь</h3>
                    </div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" action="auth" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="userLogin" placeholder="Логин">
                                    <input class="form-control" type="password" name="userPass" placeholder="Пароль">
                                </div>
                                <input class="btn btn-raised btn-primary btn-block" type="submit" name="submit" value="Войти">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4"></div>        
        </div>
    </div>       
<script src="../moderate/App/templates/js/jquery-3.2.1.min.js"></script>
<script src="../moderate/App/templates/js/bootstrap.min.js"></script>
</body>
</html>