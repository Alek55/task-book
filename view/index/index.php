<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Создать задачу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/addtask" method="post" name="addtask">
                    <div class="form-group">
                        <label for="task_name">Имя</label>
                        <input type="text" class="form-control" name="name" id="task_name">
                        <p class="error" id="error-alert-name"></p>
                    </div>
                    <div class="form-group">
                        <label for="task_email">E-mail</label>
                        <input type="email" class="form-control" name="email" id="task_email">
                        <p class="error" id="error-alert-email"></p>
                    </div>
                    <div class="form-group">
                        <label for="task_text">Текст задачи</label>
                        <textarea class="form-control" id="task_text" name="text" rows="3"></textarea>
                        <p class="error" id="error-alert-text"></p>
                    </div>
                    <button type="submit" class="btn btn-success mb-2" onclick="event.preventDefault(); checkForm.validate('addtask');">Создать</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if($tasks) { ?>
    <div class="task">
        <ul class="task__panel row justify-content-between">
            <li><button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTask">Создать задачу</button></li>
            <li>
                <span style="margin-right: 20px;">Сортировка по:</span>
                <form style="display: inline-block" action="/index" method="get" name="sort">
                    <div class="form-row">
                        <div class="form-group">
                            <select id="sort_task" class="form-control" name="sort">
                                <option value="name_up" <?php if($sort_active === 'name_up'){ ?>selected<?php } ?>>Имени(возр.)</option>
                                <option value="name_down" <?php if($sort_active === 'name_down'){ ?>selected<?php } ?>>Имени(убыв.)</option>
                                <option value="email_up" <?php if($sort_active === 'email_up'){ ?>selected<?php } ?>>E-mail(возр.)</option>
                                <option value="email_down" <?php if($sort_active === 'email_down'){ ?>selected<?php } ?>>E-mail(убыв..)</option>
                                <option value="status_down" <?php if($sort_active === 'status_down'){ ?>selected<?php } ?>>Статусу(вып.)</option>
                                <option value="status_up" <?php if($sort_active === 'status_up'){ ?>selected<?php } ?>>Статусу(не вып.)</option>
                            </select>
                            <?php if($active_page != 1) { ?>
                                <input type="hidden" name="page" value="<?=$active_page;?>">
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
        <?php if(isset($_SESSION['add_success'])) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php
                echo $_SESSION['add_success'];
                unset($_SESSION['add_success']);
                ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
        <table class="task__content table table-bordered"">
        <thead>
        <tr>
            <th>Имя</th>
            <th>E-mail</th>
            <th>Текст</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($tasks as $task) { ?>
            <tr>
                <td class="name"><p><?=$task['name'];?></p></td>
                <td class="email"><p><?=$task['email'];?></p></td>
                <td class="text"><p><?=$task['text'];?></p></td>
                <td class="status">
                    <?php if(!$task['status']): ?>
                        <p>Не выполнено</p>
                    <?php else: ?>
                        <p>Выполнено</p>
                    <?php endif; ?>
                    <?php if($task['edit']): ?>
                        <p>(Изменено администратором)</p>
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
        </table>
        <div class="task__pagination" aria-label="Page navigation example">
            <?php if($count_pages > 0) { ?>
                <ul class="row justify-content-center pagination">
                    <li class="page-item">
                        <?php if($active_page != 1): ?>
                            <a href="/index?<?php if($sort_active) echo 'sort='.$sort_active.'&'; ?>page=<?=$active_page-1?>" class="page-link">&laquo;</a>
                        <?php else: ?>
                            <span class="prev page-link">&laquo;</span>
                        <?php endif; ?>
                    </li>
                    <?php for($i = 1; $i <= $count_pages; $i++) { ?>
                        <li class="page-item <?php if($i == $active_page): ?>active<?php endif; ?>">
                            <?php if($i == $active_page): ?>
                                <span class="page-link"><?=$i?></span>
                            <?php else: ?>
                                <a class="page-link" href="/index?<?php if($sort_active) echo 'sort='.$sort_active.'&'; ?>page=<?=$i?>"><?=$i?></a>
                            <?php endif; ?>
                        </li>
                    <?php } ?>
                    <li class="page-item">
                        <?php if($active_page == $count_pages): ?>
                            <span class="page-link">&raquo;</span>
                        <?php else: ?>
                            <a href="/index?<?php if($sort_active) echo 'sort='.$sort_active.'&'; ?>page=<?=$active_page+1?>" class="page-link">&raquo;</a>
                        <?php endif; ?>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <div style="text-align: center;">
        <h4 style="margin-bottom: 30px;">Не добавлено ни одной задачи!</h4>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTask">Создать задачу</button>
    </div>
<?php } ?>
