//Third party packages
import '@fortawesome/fontawesome-free/js/all';
import feather from 'feather-icons';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import ResizeObserver from 'resize-observer-polyfill';
import 'simplebar';
import Swal from 'sweetalert2';

// Make Swal globally available for inline scripts
window.Swal = Swal;

//Core components
import accordion from './components/accordion';
import alert from './components/alert';
import carousel from './components/carousel';
import checkAll from './components/check-all';
import codeViewer from './components/code-viewer';
import datepicker from './components/datepicker';
import drawer from './components/drawer';
import dropdown from './components/dropdown';
import editor from './components/editor';
import modal from './components/modal';
import searchModal from './components/search-modal';
import select from './components/select';
import sidebar from './components/sidebar';
import tabs from './components/tabs';
import themeSwitcher from './components/theme-switcher';
import tooltip from './components/tooltip';
import uploader from './components/uploader';

// Initialize searchModal
searchModal.init();

// Initialize themeSwitcher
themeSwitcher.init();

// Initialize codeViewer
codeViewer.init();

// Initialize alert
alert.init();

// Initialize accordion
accordion.init();

// Initialize dropdown
dropdown.init();

// Initialize modal
modal.init();

// Initialize sidebar
sidebar.init();

// Initialize tabs
tabs.init();

// Initialize Tooltip
tooltip.init();

// Initialize carousel
carousel.init();

// Initialize editor
editor.init();

// Initialize select
select.init();

// Initialize uploader
uploader.init();

// Initialize datepicker
datepicker.init();

// Initialize drawer
drawer.init();

// Initialize checkAll
checkAll.init();

// Initialize feather-icons. Must be Initialize at the end.
feather.replace();

// Polyfill for ResizeObserver
window.ResizeObserver = ResizeObserver;

// Make Toastify globally available
window.Toastify = Toastify;

// Toast helper functions
window.showSuccessToast = function(message, duration = 3000) {
    return Toastify({
        text: message,
        duration: duration,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#10b981",
        stopOnFocus: true,
        className: "toast-success"
    }).showToast();
};

window.showErrorToast = function(message, duration = 3000) {
    return Toastify({
        text: message,
        duration: duration,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#dc2626",
        stopOnFocus: true,
        className: "toast-error"
    }).showToast();
};

window.showWarningToast = function(message, duration = 3000) {
    return Toastify({
        text: message,
        duration: duration,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#d97706",
        stopOnFocus: true,
        className: "toast-warning"
    }).showToast();
};

window.showInfoToast = function(message, duration = 3000) {
    return Toastify({
        text: message,
        duration: duration,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#0891b2",
        stopOnFocus: true,
        className: "toast-info"
    }).showToast();
};
