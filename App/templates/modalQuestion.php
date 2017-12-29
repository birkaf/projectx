<input type="hidden" id="qId" value="<?php echo $question->id;?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4><?php echo trim($question->question_text);?></h4>
    </div>
    <div class="modal-body">
        <div>
            <div id='theme' class=""><em>Тема: <?php echo trim($question->themes->theme_name); ?></em></div>
            <?php if (!empty($question->image)): ?>
                <div id='image'>
                    <p><em>Прикрепленное изображение:</em></p>
                    <img src="../testirovanie/questions_img/<?php echo $question->image;?>" width="300">
                </div>
            <?php endif; ?>
            <div class="" id="answer">
                <p><em>Варианты ответа:</em></p>
                <ul>	
                <?php foreach ($answers as $answer) : ?>
                    <li><?php if(1 == $answer->correct) echo '<strong>'; ?>
                        <?php echo $answer->answer_text;?>
                        <?php if(1 == $answer->correct) echo '</strong>'; ?>
                    </li>
                <?php endforeach; ?>
                </ul>	
            </div>	
	</div>
        <?php if ($question->approved == 1):?>
        <div id="approvement">
            <em>Вопрос согласовал: <?php echo $user->lastName . ' ' . $user->firstName . ' ' . $user->otchestvo;?></em>
        </div>
        <?php endif;?>
        <?php if ($question->approved == 2):?>
        <div id="approvement">
            <em>Вопрос не согласовал: <?php echo $user->lastName . ' ' . $user->firstName . ' ' . $user->otchestvo;?></em></br>
            <em>Причина: <?php echo $approve->comment;?></em>
        </div>
        <?php endif;?>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn">Закрыть окно</button>
        <?php //if (NULL == $approve->user_approved): //Для множественного согласования?>
        <?php if ($question->approved == 0):?>
            <button class="btn btn-primary agree" id="agree">Согласовать</button>	
            <button class="btn btn-danger" data-toggle="modal" href="#disComment" id="modalDisAgree">Не согласовать</button>
        <?php endif;?>
    </div>
    <!--Комментарий к не согласованию-->    
    <div id="disComment" class="modal fade" tabindex="-1" data-width="70%" style="display: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Оставьте комментарий</h4>
        </div>
        <div class="modal-body">
            <p>Опишите причину не согласования</p>
            <textarea class="form-control" id="textComment" style="min-width: 100%; resize: none;" rows="5" ></textarea>  
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default">Закрыть</button>
            <button class="btn btn-danger disagree" id="disagree">Не согласовать</button>
        </div>
    </div>