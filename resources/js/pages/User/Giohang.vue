<script setup>
import { computed } from 'vue';
import UserLayouts from './Layouts/UserLayouts.vue';
import { router, usePage } from '@inertiajs/vue3';

const sanphams = computed(() => usePage().props.giohanghelper.data.sanphams);
const giohang = computed(() => usePage().props.giohanghelper.data.items);
const tongcong = computed(() => usePage().props.giohanghelper.data.tongcong);
const itemID = (id) => giohang.value.findIndex((item) => item.sanpham_id === id);

const update = (sanpham, soluong) =>
    router.patch(route('giohang.update', sanpham), { soluong, });

const remove = (sanpham) => router.delete(route('giohang.delete', sanpham));
</script>

<template>
    <UserLayouts>
        <section class="text-gray-600 body-font relative">
            <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap">
                <div class="lg:w-2/3 md:w-1/2 rounded-lg overflow-hidden sm:mr-10 p-10">
                    <!-- Danh sách sản phẩm trong giỏ hàng -->
                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                            <tr>
                                <th scope="col" class="px-16 py-3">
                                    <span class="sr-only">Image</span>
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Qty
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sanpham in sanphams" :key="sanpham.id"
                                class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                <td class="p-4">
                                    <img src="" class="w-16 md:w-24 max-w-full max-h-full" alt="">
                                </td>
                                <td class="px-6 py-4 font-semibold text-heading">
                                    {{ sanpham.tensp }}
                                </td>
                                <td class="px-6 py-4">
                                    <form class="max-w-xs mx-auto">
                                        <label for="counter-input-1" class="sr-only">Choose quantity:</label>
                                        <div class="relative flex items-center">
                                            <button type="button" id="decrement-button-1"
                                                @click.prevent="update(sanpham, giohang[itemID(sanpham.id)].soluong - 1)"
                                                data-input-counter-decrement="counter-input-1"
                                                :disabled="giohang[itemID(sanpham.id)].soluong <= 1"
                                                :class="[giohang[itemID(sanpham.id)].soluong > 1 ? 'cursor-pointer text-purple-600' : 'cursor-not-allowed text-gray-300 dark:text-gray-500', 'flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6']">
                                                <svg class="w-3 h-3 text-heading" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                                                </svg>
                                            </button>
                                            <input type="text" id="counter-input-1" data-input-counter
                                                v-model="giohang[itemID(sanpham.id)].soluong"
                                                class="shrink-0 text-heading border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                                placeholder="" value="" required />
                                            <button type="button" id="increment-button-1"
                                                @click.prevent="update(sanpham, giohang[itemID(sanpham.id)].soluong + 1)"
                                                data-input-counter-increment="counter-input-1"
                                                class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                                <svg class="w-3 h-3 text-heading" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td class="px-6 py-4 font-semibold text-heading">
                                    {{ sanpham.gia }} VND
                                </td>
                                <td class="px-6 py-4">
                                    <a @click="remove(sanpham)"
                                        class="font-medium text-fg-danger hover:underline">Remove</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Nội dung đơn hàng</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">Giá : {{ tongcong }}VND</p>
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Địa chỉ giao hàng</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">TP HCM</p>
                    <p class="leading-relaxed mb-5 text-gray-600">Thêm địa chỉ khác</p>
                    <div class="relative mb-4">
                        <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
                        <input type="text" id="name" name="name"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                        <textarea id="message" name="message"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                    </div>
                    <button
                        class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Thanh
                        toán</button>
                    <p class="text-xs text-gray-500 mt-3">Tiếp tục mua sắm.</p>
                </div>
            </div>
        </section>
    </UserLayouts>
</template>