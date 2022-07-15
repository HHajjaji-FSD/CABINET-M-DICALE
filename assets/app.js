const $ = require('jquery');
import 'select2'


//Import Css
import "./styles/app.scss";

import "./bootstrap";

import 'admin-lte/dist/js/adminlte.min'
import './styles/bootstrap.bundle.min'
import 'bootstrap/dist/js/bootstrap'
import 'chart.js/dist/chart.min'
/*
import 'fullcalendar/dist/fullcalendar.css'
import 'fullcalendar/dist/fullcalendar'
*/

$(document).ready(function() {
    $('.select2').select2({
        theme: "classic"
    });
});









