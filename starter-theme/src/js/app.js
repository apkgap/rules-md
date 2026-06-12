import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// Initialize Swiper modules
Swiper.use([Navigation, Pagination, Autoplay]);
window.Swiper = Swiper;

Alpine.plugin(collapse);

window.Alpine = Alpine;

if (!window.Alpine_started) {
    window.Alpine_started = true;
    Alpine.start();
}

document.addEventListener('DOMContentLoaded', () => {
    const $ = window.jQuery;

    if (!$ || typeof $.fn.datepicker !== 'function') {
        return;
    }

    const dateInputs = document.querySelectorAll('[data-datepicker="true"]');

    dateInputs.forEach((input) => {
        const $input = $(input);

        if ($input.hasClass('hasDatepicker')) {
            return;
        }

        $input.datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showAnim: 'fadeIn',
        });
    });
});
