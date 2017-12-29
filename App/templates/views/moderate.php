<html>
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../moderate/App/templates/css/bootstrap.css">
    <link rel="stylesheet" href="../moderate/App/templates/css/bootstrap-table.min.css">
    
    <link rel="stylesheet" href="../moderate/App/templates/css/bootstrap-modal-bs3patch.css">
    <link rel="stylesheet" href="../moderate/App/templates/css/bootstrap-modal.css">
    
    <link rel="stylesheet" href="../moderate/App/templates/css/bootstrap-select.min.css">
    
    
    <script src="../moderate/App/templates/js/jquery-3.2.1.min.js"></script>
    <script src="../moderate/App/templates/js/bootstrap.min.js"></script>
    <script src="../moderate/App/templates/js/bootstrap-table.min.js"></script>
    <script src="../moderate/App/templates/js/bootstrap-table-ru-RU.min.js"></script>
    <script src="../moderate/App/templates/js/bootstrap-modalmanager.js"></script>
    <script src="../moderate/App/templates/js/bootstrap-modal.js"></script>
    <script src="../moderate/App/templates/js/bootstrap-select.min.js"></script>
    <style>
    </style>
</head>
<body>

    <div class="container">
        <h1>Вопросы</h1>
        <p></p>
        <!--       
        <ul class="nav nav-pills" role="tablist">
            <li role="presentation" class="active"><a href="#">Не просмотренные <span class="badge">999</span></a></li>
            <li role="presentation" class="warning"><a href="#">Согласованные</a></li>
            <li role="presentation"><a href="#">Не согласованные<span class="badge">3</span></a></li>button_space
        </ul>
        -->
        <ul class="nav nav-pills" role="tablist">
            <li role="presentation" class="active"><label class="btn btn-info " id="btn_NewQ">Не просмотренные <span class="badge"><?php echo $countNewQ->c;?></span></label></li>
            <li role="presentation" class="active"><label class="btn btn-success" id="btn_AgreeQ">Согласованные <span class="badge"><?php echo $countAgreeQ->c;?></span></label></li>
            <li role="presentation" class="active"><label class="btn btn-danger" id="btn_DisAgreeQ">Не согласованные <span class="badge"><?php echo $countDisAgreeQ->c;?></span></label></li>
        </ul>
<!--        
        <br>
        <p>Отфильтровать по теме: </p>
        <select class="selectpicker show-tick">
            <option value="all">Все вопросы</option>
             <?php foreach ($themes as $theme) : ?>
                    <option value="<?php echo $theme->id;?>"><?php echo $theme->theme_name;?></option>
             <?php endforeach;?>
        </select>-->
        <!-- 
        <div class="btn-group" data-toggle="buttons">
	
	<label class="btn btn-danger button_space" id="btn_instrNotPassed"><input name="myRadio" value="4" type="radio">Не прошли инструктаж</label>
	<label class="btn btn-warning button_space" id="btn_instrInProgress"><input name="myRadio" value="1" type="radio">Открыли инструктаж</label>
	<label class="btn btn-info button_space" id="btn_instrNotOpend"><input name="myRadio" value="0" type="radio">Не открывали инструктаж</label>
        <label class="btn btn-success button_space" id="btn_instrPassed"><input name="myRadio" value="3" checked="" type="radio">Прошли инструктаж</label>
        </div>
 -->
        <table id="table" data-toggle="table"  data-height="700" data-row-style="rowStyle" data-pagination="true" data-search="true"  data-unique-id="id">
            <thead>
                <tr>
                    <th data-field="id" >ID</th>
                    <th data-field="name">Вопрос</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question) : ?>
                    <?php if ($question->approved == 2) {$class = 'bg-danger';}
                          if ($question->approved == 1) {$class = 'bg-success';}
                          if ($question->approved == 0) {$class = '';}?>
                <tr class="<?php echo $class;?>">
                    <td id="idQ<?php echo $question->id;?>"><?php echo $question->id;?></td>
                    <td><?php echo $question->question_text;?></td>
                </tr>   
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <div class="container"> 
        <div id="ajax-modal" class="modal fade" data-width="80%" tabindex="-1" style="display: none;"></div>
    </div>
    <div id="serverAnswer"></div>
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="copyright">
                   © 2017 УЦДОСС | <a href="/moderate/about">О проекте</a>
                </div>
            </div>
            <!--<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"></div>-->
        </div>
    </div>
</div>
<script>
    $('.selectpicker').selectpicker({
        style: '',
        size: 10
    });
    $('.selectpicker').on('hidden.bs.select', function (e) {
        //alert($(this).val());
        var pageUrl = document.location.href.split("/");
        var newURL = "/moderate/"+pageUrl[4]+'?themId='+$(this).val();
        //alert(newURL);
        location.href = newURL;
        
//        setTimeout(function(){
//            $.post("/moderate/"+pageUrl[4], ({ themId: $(this).val()}), function (data) {
//                var serverAnswer = $.parseJSON(data);
//                if (serverAnswer.status=="error"){
//                    //$modal.html('<div class="modal-header"><h4>Время сессии истекло, пройдите <a href="/moderate/login">авторизацию</a>  повторно</h4></div>');
//                }
//                else if(serverAnswer.status=="success"){
//                    console.log(serverAnswer.message);
////                    $("#agree").hide();
////                    $("#modalDisAgree").hide();
////                    $('#idQ'+$('#qId').val())
////                                .parent().removeClass('bg-info').addClass('bg-success');
////                    $modal.modal('loading').find('.modal-body')
////                        .prepend('<div class="alert alert-info fade in">' +
////                            'Согласовано!<button type="button" class="close" data-dismiss="alert">&times;</button>' +
////                            '</div>');
//                }
//            });
//            
//        }, 1000);
        //console.log(a.length);
        //console.log(a);
        //alert(a[4]);
    });
    var $table = $('#table');
    var $modal = $('#ajax-modal');
    var $modaldis = $('#disComment');
    $modal.on('click', '.agree', function(){
        $modal.modal('loading');
        setTimeout(function(){
            $.post("/moderate/ajaxAgree", ({ qId: $('#qId').val()}), function (data) {
                var serverAnswer = $.parseJSON(data);
                if (serverAnswer.status=="error"){
                    $modal.html('<div class="modal-header"><h4>Время сессии истекло, пройдите <a href="/moderate/login">авторизацию</a>  повторно</h4></div>');
                }
                else if(serverAnswer.status=="success"){
                    console.log(serverAnswer.message);
                    $("#agree").hide();
                    $("#modalDisAgree").hide();
                    $('#idQ'+$('#qId').val())
                                .parent().removeClass('bg-info').addClass('bg-success');
                    $modal.modal('loading').find('.modal-body')
                        .prepend('<div class="alert alert-info fade in">' +
                            'Согласовано!<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '</div>');
                }
            });
            
        }, 1000);
    });
    $('body').on('click','#btn_AgreeQ', function(){
        location.href = '/moderate/ajaxAgreeQ';
    });
    $('body').on('click','#btn_DisAgreeQ', function(){
        location.href = '/moderate/ajaxDisAgreeQ';
    });
    $('body').on('click','#btn_NewQ', function(){
        location.href = '/moderate/ajaxNewQ';
        //alert("New Q");
        //rows = serverNewQPost();
        //console.log(rows);
        //$table.bootstrapTable('load', serverNewQPost());
        
//        function serverNewQPost() {
//            var rows = [];
//            //alert("New Q");
//            //setTimeout(function(){
//                $.post("/moderate/ajaxNewQ", function (data) {
//                    var serverAnswer = $.parseJSON(data);
//                    $.each(serverAnswer, function(index, value) {
//                        //console.log(value.id);
//                        rows.push({
//                            id: value.id,
//                            name: value.question_text
//                        });
//                    }); 
//                    //console.log(data);
////                    if (serverAnswer.status=="error"){
////                        $("#serverAnswer").html(serverAnswer.message);
////                    }
////                    else if(serverAnswer.status=="success"){
////                        console.log(serverAnswer.message);
////                        $('.modal-body p').hide();
////                        $('#modalDisAgree').hide();
////                        $('#agree').hide();
////                        $('#textComment').hide();
////                        $("#disagree").hide();
////                        $('#idQ'+$('#qId').val())
////                                .parent().removeClass('bg-info').addClass('bg-danger');
////                        $('#disComment').modal('loading').find('.modal-body')
////                            .prepend('<div class="alert alert-info fade in">' +
////                                'Вопрос не согласован!<button type="button" class="close" data-dismiss="alert">&times;</button>' +
////                                '</div>');
////                    }
//                });
//            //}, 1000);
//            
//            
//            console.log(rows);
////            var startId = ~~(Math.random() * 100),
////                rows = [];
////            for (var i = 0; i < 10; i++) {
////                rows.push({
////                    id: startId + i,
////                    name: 'test' + (startId + i)
////                });
////            }
//            return rows;
//        }
    });
    $('body').on('click','.disagree', function(){
        console.log($('#textComment').val());
        if($('#textComment').val()){
            $('#disComment').modal('loading');
            setTimeout(function(){
                $.post("/moderate/ajaxDisAgree", ({ qId: $('#qId').val(), disComment:$('#textComment').val()}), function (data) {
                    var serverAnswer = $.parseJSON(data);
                    if (serverAnswer.status=="error"){
                        $('#disComment').html('<div class="modal-header"><h4>Время сессии истекло, пройдите <a href="/moderate/login">авторизацию</a>  повторно</h4></div>');
                        //$("#serverAnswer").html(serverAnswer.message);
                    }
                    else if(serverAnswer.status=="success"){
                        console.log(serverAnswer.message);
                        $('.modal-body p').hide();
                        $('#modalDisAgree').hide();
                        $('#agree').hide();
                        $('#textComment').hide();
                        $("#disagree").hide();
                        $('#idQ'+$('#qId').val())
                                .parent().removeClass('bg-info').addClass('bg-danger');
                        $('#disComment').modal('loading').find('.modal-body')
                            .prepend('<div class="alert alert-info fade in">' +
                                'Вопрос не согласован!<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '</div>');
                    }
                });
            }, 1000);
        }else{
            $('#disComment').modal('loading');
            setTimeout(function(){
              $('#disComment')
                .modal('loading')
                .find('.modal-body')
                  .prepend('<div class="alert alert-danger fade in">' +
                    'Заполните причину!<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                  '</div>');
            }, 100);
        }
    });
    
    $(function () {
 
        $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner = 
            '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
              '<div class="progress progress-striped active">' +
                '<div class="progress-bar" style="width: 100%;"></div>' +
              '</div>' +
            '</div>';
        $.fn.modalmanager.defaults.resize = true;
        
        $table.on('click-row.bs.table', function (e, row, $element) {
            $('body').modalmanager('loading');
            //alert(row.id);
            setTimeout(function(){
               $modal.load('/moderate/ajaxOpenQuestion', { qId: row.id}, function(){
                    $modal.modal();
                });
            }, 100);
        });
    });
</script>
</body>
</html>