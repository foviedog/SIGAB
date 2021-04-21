require("./bootstrap");

import $ from "jquery";
window.$ = window.jQuery = $;

import "jquery-ui/ui/widgets/datepicker.js";

import 'jquery-ui/ui/widgets/dialog.js';

import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

import fixutf8 from 'fix-utf8';
window.fixUtf8 = fixutf8;