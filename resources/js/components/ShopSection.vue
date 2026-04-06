<template>
    <div class="w-full min-h-screen bg-[#FAF5F0] py-12" id="Shop" style="font-family: 'Poppins', sans-serif;">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
                <div class="flex flex-col md:flex-row gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Brand</label>
                        <select v-model="brand" class="rounded border-gray-300">
                            <option value="">All Brands</option>
                            <option v-for="b in brands" :key="b.id" :value="b.id">{{ b.brand_name }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Category</label>
                        <select v-model="category" class="rounded border-gray-300">
                            <option value="">All Categories</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.category_name }}</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Sort By</label>
                    <select v-model="sort" class="rounded border-gray-300">
                        <option value="created_at_desc">Newest</option>
                        <option value="created_at_asc">Oldest</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="sold_desc">Most Sold</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-2 md:gap-6">
                <a v-for="product in products.data" :key="product.id" :href="`/product/${product.id}`"  class="bg-white rounded-lg shadow p-4 flex flex-col items-start hover:shadow-xl transition cursor-pointer">
                    <img :src="product.product_thumbnail_url" :alt="product.product_name" class="w-32 h-44 self-center rounded mb-2">
                    <div class="font-semibold text-base text-left mb-1">{{ product.product_name }}</div>
                    <div class="text-sm text-gray-600 text-left mb-1">${{ Number(product.product_price).toFixed(2) }}</div>
                    <div class="text-xs text-gray-500 text-left mb-1">Sold: {{ product.product_soldCount }}</div>
                </a>
                <div v-if="products.data.length === 0" class="col-span-2 md:col-span-5 text-center text-gray-500 py-12">No products found.</div>
            </div>

            <div class="mt-8 flex items-center justify-center gap-8">
                <button @click="changePage(products.current_page - 1)" :disabled="products.current_page === 1" class="mx-1 px-4 py-2 rounded-lg shadow-lg bg-[#7a4025] text-white" > < Prev</button>
                <span class="mx-2">Page {{ products.current_page }} of {{ products.last_page }}</span>
                <button @click="changePage(products.current_page + 1)" :disabled="products.current_page === products.last_page" class="mx-1 px-4 py-2 rounded-lg shadow-lg bg-[#7a4025] text-white">Next ></button>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted, watch } from 'vue';

    const products = ref({ data: [], current_page: 1, last_page: 1 });
    const brands = ref([]);
    const categories = ref([]);
    const brand = ref('');
    const category = ref('');
    const sort = ref('created_at_desc');
    const perPage = 15;

    const fetchProducts = async (page = 1) => {
        let params = new URLSearchParams({
            brand: brand.value,
            category: category.value,
            sort: sort.value,
            page,
            perPage
        });
        const res = await fetch(`/api/products?${params.toString()}`);
        products.value = await res.json();
    };

    const fetchBrands = async () => {
        const res = await fetch('/api/brands');
        brands.value = await res.json();
    };
    const fetchCategories = async () => {
        const res = await fetch('/api/categories');
        categories.value = await res.json();
    };

    const changePage = (page) => {
        if (page < 1 || page > products.value.last_page) return;
        fetchProducts(page);
    };

    onMounted(() => {
        fetchBrands();
        fetchCategories();
        fetchProducts();
    });

    watch([brand, category, sort], () => {
        fetchProducts(1);
    });
</script>
