<?php if($tasks) { ?>
<div class="task">
    <div class="task__panel">
        <ul class="row justify-content-between">
            <li>
                <span style="margin-right: 20px;">Сортировка по:</span>
                <form style="display: inline-block;" action="index" method="get" name="sort">
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
    </div>
    <table class="task__content table table-bordered"">
    <thead>
    <tr>
        <th>Имя</th>
        <th>E-mail</th>
        <th>Текст</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($tasks as $task) { ?>
        <tr>
            <td class="name"><?=$task['name'];?></td>
            <td class="email"><?=$task['email'];?></td>
            <td class="text"><?=$task['text'];?></td>
            <td class="status">
                <p class="is_ready">
                    <?php if(!$task['status']): ?>
                        Не выполнено
                    <?php else: ?>
                        Выполнено
                    <?php endif; ?>
                </p>
                <p class="is_edit">
                <?php if($task['edit']): ?>
                    (Изменено администратором)
                <?php endif; ?>
                </p>
            </td>
            <td class="action">
                <button style="margin-bottom: 10px;" data-id="<?=$task['id'];?>" class="btn btn-primary edit">Редактировать</button>
                <button data-id="<?=$task['id'];?>" style="border: 1px solid #ccc;" <?php if($task['status']) {echo 'disabled';} ?> class="btn <?php if($task['status']) {echo 'btn-success disabled';} else {echo 'btn-light';} ?> btn-ready">Выполнено</button>
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
                        <a href="index?<?php if($sort_active) echo 'sort='.$sort_active.'&'; ?>page=<?=$active_page-1?>" class="page-link">&laquo;</a>
                    <?php else: ?>
                        <span class="prev page-link">&laquo;</span>
                    <?php endif; ?>
                </li>
                <?php for($i = 1; $i <= $count_pages; $i++) { ?>
                    <li class="page-item <?php if($i == $active_page): ?>active<?php endif; ?>">
                        <?php if($i == $active_page): ?>
                            <span class="page-link"><?=$i?></span>
                        <?php else: ?>
                            <a class="page-link" href="index?<?php if($sort_active) echo 'sort='.$sort_active.'&'; ?>page=<?=$i?>"><?=$i?></a>
                        <?php endif; ?>
                    </li>
                <?php } ?>
                <li class="page-item">
                    <?php if($active_page == $count_pages): ?>
                        <span class="page-link">&raquo;</span>
                    <?php else: ?>
                        <a href="index?<?php if($sort_active) echo 'sort='.$sort_active.'&'; ?>page=<?=$active_page+1?>" class="page-link">&raquo;</a>
                    <?php endif; ?>
                </li>
            </ul>
        <?php } ?>
    </div>
</div>
<?php } else { ?>
    <div style="text-align: center;">
        <h4 style="margin-bottom: 30px;">Не добавлено ни одной задачи!</h4>
    </div>
<?php } ?>
