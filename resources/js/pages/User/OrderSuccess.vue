<script setup>
import UserLayouts from './Layouts/UserLayouts.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    resultCode: String
})
</script>

<template>
    <UserLayouts>
        <section class="text-gray-600 body-font relative bg-white">
            <div class="container px-5 py-24 mx-auto text-center">
                <div v-if="resultCode === '0'">
                    <h1 class="text-3xl font-medium title-font text-gray-900 mb-12">Thanh toán thành công!</h1>
                    <p class="leading-relaxed mb-5">Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đang được xử lý.</p>
                </div>
                <div v-else>
                    <h1 class="text-3xl font-medium title-font text-red-500 mb-12">Thanh toán thất bại</h1>
                    <p class="leading-relaxed mb-5">Đã có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại.</p>
                </div>
                <Link :href="route('home')" class="text-indigo-500">Quay lại trang chủ</Link>
            </div>
        </section>
    </UserLayouts>
</template>
