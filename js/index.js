$(document).ready(function () {

    $('input, textarea, select').focus(function () {
        $(this).parent().find('.error').empty();
    });

    const hash = window.location.hash;
    if(hash === '#auth') $("#openModalAuth").click();

    const checkForm = {
        validate(form_name) {
            const form = $(`form[name="${form_name}"]`);
            const form_data = form.serializeArray();
            let error = null;
            form_data.forEach((item) => {
                if(!item.value && !error) error = item.name;
                if(item.name == 'email') {
                    if(!/.+@.+\..+/i.test(item.value) && !error) error = 'email_nocorrect';
                }
            });
            if(error) {
                if(error == 'email_nocorrect') $(`#error-alert-email`).text('Некорректный email');
                else $(`#error-alert-${error}`).text('Заполните поле');
                return false;
            }
            form.submit();
        }
    }

    window.checkForm = checkForm;

    $("#sort_task").change(function () {
        const sort_val = $(this).val();
        $("form[name='sort']").submit();
    });

    $(".btn-ready").click(function () {
        const id = $(this).attr('data-id');
        const th = this;
        $.ajax({
            url: 'checktask',
            method: 'post',
            dataType: 'json',
            data: {id: id},
            success: function (res) {
                if(res === 'success') {
                    $(th).removeClass('btn-light');
                    $(th).addClass('btn-success disabled');
                    $(th).attr('disabled', true);
                    $(th).parent().parent().find('.status .is_ready').text('Выполнено');
                }
            },
            error: function () {alert('Произошла ошибка!');}
        });
    });

    var current_text;

    $("button.edit").click(function () {
        const id = $(this).attr('data-id');
        const td_text = $(this).parent().parent().find('.text');
        current_text = td_text.text();
        $(this).addClass('disabled');
        $(this).attr('disabled', true);
        td_text.empty();
        td_text.append(`<textarea>${current_text}</textarea><br><button data-id="${id}" style="margin-right: 10px;" class="save_text btn btn-success">Сохранить</button><button class="cancel_text btn btn-danger">Отмена</button>`);
    });

    $('body').on('click', '.cancel_text', function () {
        $(this).parent().parent().find('.action .edit').attr('disabled', false);
        $(this).parent().parent().find('.action .edit').removeClass('disabled');

        const td_text = $(this).parent().parent().find('.text');
        td_text.empty();
        td_text.text(current_text);
    });

    $('body').on('click', '.save_text', function () {
        const val = $(this).parent().find('textarea').val();
        const id = $(this).attr('data-id');
        if(!val) {
            alert('Заполните поле!');
            return false;
        }
        const c_text = current_text;
        if(val === current_text) {
            $('.cancel_text').click();
            return false
        }
        current_text = val;
        const th = this;
        $.ajax({
            url: 'savetext',
            method: 'post',
            dataType: 'json',
            data: {id: id, text: val},
            success: function () {
                $(th).parent().parent().find('.status .is_edit').text('(Изменено администратором)');
                $('.cancel_text').click();
            },
            error: function () {
                alert('Во время сохранения произошла ошибка!');
                current_text = c_text;
            }
        });
    });

});