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
require('admin-lte');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


$('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' /* optional */
});

$('.select2').select2();
