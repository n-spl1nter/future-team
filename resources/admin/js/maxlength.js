global.$ = global.jQuery = window.jQuery = window.$ = require('jquery');

$('[data-maxlength]').each((index, el) => {
    console.log('---', el);
    const valueLength = el.value.length;
    const limit = el.dataset.maxlength;
    const $wrapper = $('<div class="limited" />');
    $(el).wrap($wrapper);
    $(el).after(`<span class="char-counter">${valueLength}/${limit}</span>`);
});

$('[data-maxlength]').on('input', function (ev) {
    const limit = parseInt(ev.target.dataset.maxlength);
    const valueLength = ev.target.value.length;
    const $charCounter = $(this).siblings('.char-counter');
    $charCounter.text(`${valueLength}/${limit}`);
    if (valueLength > limit) {
        $charCounter.addClass('bg-danger');
    } else {
        $charCounter.removeClass('bg-danger');
    }
});
