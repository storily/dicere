const $ = require('jquery')

$(() => {
    $('.meta-edit').click(function () {
        const $item = $(this).parent('.meta-item')
        const key = $('.meta-key', $item).text().replace(/:\s*$/, '')
        const value = $('.meta-value', $item).text()

        const $form = $('#meta-form')
        $form.append(
            $('<input type="hidden" name="remove_metadata">').val(key)
        )

        $('input[name$=key]', $form).val(key)
        $('input[name$=value]', $form).val(value).focus()
        $('button[type=submit]', $form).text('Save')
    })
})
