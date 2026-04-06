import './bootstrap';
import { createApp } from 'vue';
import ShopSection from './components/ShopSection.vue';

const shopSectionEl = document.getElementById('shop-section-vue');
if (shopSectionEl) {
    createApp(ShopSection).mount(shopSectionEl);
}
