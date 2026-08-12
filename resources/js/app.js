import './bootstrap';
import { initMobileNav, initDropdowns } from './nav';
import { initToolSearch } from './search';

document.addEventListener('DOMContentLoaded', () => {
    initMobileNav();
    initDropdowns();
    initToolSearch();
});
