global.$ = global.jQuery = require('jquery');
require('bootstrap');
require('icheck');
require('select2');
// require('admin-lte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker');
// require('admin-lte/plugins/bootstrap-slider/bootstrap-slider');
// require('admin-lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox');
// require('admin-lte/plugins/chart.js/Chart');
// require('admin-lte/plugins/datatables/dataTables.bootstrap4');
// require('admin-lte/plugins/daterangepicker/daterangepicker');
// require('admin-lte/plugins/fastclick/fastclick');
require('admin-lte/plugins/chart.js/Chart.bundle.min');
require('admin-lte/plugins/inputmask/jquery.inputmask.bundle');
require('admin-lte');
import paths from './paths';
const toastr = require('admin-lte/plugins/toastr/toastr.min');

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
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
    const entity_id = target.dataset.entity_id;
    if (!value || !url || !entity_id) {
        return;
    }

    const formData = new FormData;
    const $photoList = $(this).closest('.form-group').find('.list-group');
    formData.append('entity_id', entity_id);
    formData.append('new_photo', target.files[0]);

    Loading.start();

    axios.post(url, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        }
    }).then(res => {
        let markup = '';
        res.data.photos.forEach(photo => {
            markup += `<li class="list-group-item">
              <img src="${photo[0]}" alt="" style="max-width: 200px;width: 100%; max-height: 200px">
            </li>`;
        });
        target.value = null;
        $photoList.html(markup);
        Loading.end();
        toastr.success("Photo has been upload!", "Success");
    }).catch(err => {
        toastr.error("Something went wrong!", "Error")
        Loading.end();
    })
});
