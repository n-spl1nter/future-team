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
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


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
