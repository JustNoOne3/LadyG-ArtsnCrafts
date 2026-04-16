import './bootstrap';
import { createApp } from 'vue';

import BrandSection from './components/BrandSection.vue';
import ShopSection from './components/ShopSection.vue';

const shopSectionEl = document.getElementById('shop-section-vue');
if (shopSectionEl) {
    createApp(ShopSection).mount(shopSectionEl);
}
const brandSectionEl = document.getElementById('brand-section-app');
if (brandSectionEl) {
    const brandId = brandSectionEl.getAttribute('data-brand-id');
    createApp(BrandSection, { brandId }).mount(brandSectionEl);
}
