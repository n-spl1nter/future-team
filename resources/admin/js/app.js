global.$ = global.jQuery = window.jQuery = window.$ = require('jquery');
require('bootstrap');
require('icheck');
require('select2');
require('admin-lte/plugins/chart.js/Chart.bundle.min');
require('admin-lte/plugins/inputmask/jquery.inputmask.bundle');
require('admin-lte');
import paths from './paths';
import './maxlength';
const toastr = require('admin-lte/plugins/toastr/toastr.min');

window.axios = require('axios');
window.axios.defaults.headers.common[ 'X-Requested-With' ] = 'XMLHttpRequest';
toastr.options = {
    'closeButton': false,
    'debug': false,
    'newestOnTop': false,
    'progressBar': false,
    'positionClass': 'toast-top-right',
    'preventDuplicates': false,
    'onclick': null,
    'showDuration': '300',
    'hideDuration': '1000',
    'timeOut': '5000',
    'extendedTimeOut': '1000',
    'showEasing': 'swing',
    'hideEasing': 'linear',
    'showMethod': 'fadeIn',
    'hideMethod': 'fadeOut'
};

const Loading = {
    start: () => {
        document.body.classList.add('loading-overlay');
    },
    end: () => {
        document.body.classList.remove('loading-overlay');
    },
};


$('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' /* optional */
});

$('.select2').select2({
    width: '100%',
});
$('.city-select').select2({
    width: '100%',
    minimumInputLength: 2,
    ajax: {
        url: paths.v1Cities,
        delay: 250,
        data: function ({ term }) {
            return {
                value: term,
                country_id: document.querySelector('[name="country_id"]').value,
            };
        },
        cache: true,
        processResults: function (data, params) {
            const results = data.items.map(item => ({
                text: item.title_en,
                id: item.city_id,
            }));
            return { results };
        }
    },
});

$('.datetime-mask').inputmask('datetime', {
    inputFormat: 'yyyy-mm-dd HH:MM:ss',
});

$('.new-photo').on('change', function ({ target }) {
    const { value } = target;
    const url = target.dataset.url;
    const deleteUrl = target.dataset.removeUrl;
    const entity_id = target.dataset.entity_id;
    if (!value || !url || !entity_id) {
        return;
    }

    const formData = new FormData;
    const $photoList = $(this).closest('.form-group').find('.list-group');
    formData.append('entity_id', entity_id);
    formData.append('new_photo', target.files[ 0 ]);

    Loading.start();

    axios.post(url, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        }
    }).then(res => {
        let markup = '';
        res.data.photos.forEach(photo => {
            markup += `<li class="list-group-item">
              <div class="d-flex justify-content-between align-items-center">
                  <img src="${photo.url[ 0 ]}" alt="" style="max-width: 200px;width: 100%; max-height: 200px">
                  <button type="button" class="btn btn-danger main-photo-remove" data-id="${photo.id}" data-url="${deleteUrl}">Remove</button>
              </div>
            </li>`;
        });
        target.value = null;
        $photoList.html(markup);
        Loading.end();
        toastr.success('Photo has been upload!', 'Success');
    }).catch(err => {
        toastr.error('Something went wrong!', 'Error');
        Loading.end();
    })
});

$('body').on('click', '.main-photo-remove', function ({ target }) {
    if(!confirm('Are you sure?')) {
        return;
    }

    Loading.start();
    const url = target.dataset.url;
    const id = target.dataset.id;

    axios.delete(url, { params: { photo_id: id }, })
        .then(res => {
            target.closest('.list-group-item').remove();
            Loading.end();
            toastr.success('Photo was deleted!', 'Success');
        }).catch(() => {

        toastr.error('Something went wrong!', 'Error');
        Loading.end();
        });
});

$('body').on('click', '.remove-array-item', function (ev) {
    ev.preventDefault();
    $(this).parent().remove();
});

$('.add-array-item').on('click', function (ev) {
    ev.preventDefault();
    const inputName = ev.target.dataset.name;
    const html = `
    <div class="d-flex mb-1">
        <input type="text" name="${inputName}" class="form-control">
        <button type="button" class="btn-sm btn-danger remove-array-item ml-1">
            <i class="fas fa-trash"></i>
        </button>
    </div>
    `;

    $(this).parent().before(html);
});
