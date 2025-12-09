<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { inject } from 'vue';


const swal = inject('$swal');

defineProps({
    sanphams: Array,
});
const loaisps = usePage().props.loaisps;
const thuonghieus = usePage().props.thuonghieus;


const dialogVisible = ref(false);
const isAddSP = ref(false);
const editMode = ref(false);

const id = ref('');
const tensp = ref('');
const id_loaisp = ref('');
const id_thuonghieu = ref('');
const chitietsp = ref('');
const trangthaihienthi = ref('');
const hdsd = ref('');
const thanhphansp = ref('');
const gia = ref(0);
const soluongtonkho = ref(0);
const image_url = ref();
const sku = ref('');
const giakhuyenmai = ref(0);

// Upload hình ảnh
const imageURL = ref([]);
const dialogImageUrl = ref('');
const handleFileChange = (file) => {
    console.log(file);
    imageURL.value.push(file);
}

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url || URL.createObjectURL(file.raw)
    dialogVisible.value = true
}

const handleRemove = (file) => {
    console.log(file);
}

const openAddModal = () => {
    isAddSP.value = true;
    dialogVisible.value = true;
    editMode.value = false;
}

// Them san pham
const themSP = async () => {
    const formData = new FormData();
    formData.append('tensp', tensp.value);
    formData.append('id_loaisp', id_loaisp.value);
    formData.append('id_thuonghieu', id_thuonghieu.value);
    formData.append('chitietsp', chitietsp.value);
    formData.append('trangthaihienthi', trangthaihienthi.value);
    formData.append('gia', gia.value);
    formData.append('soluongtonkho', soluongtonkho.value);
    formData.append('hdsd', hdsd.value);
    formData.append('thanhphansp', thanhphansp.value);

    for (const image of imageURL.value) {
        formData.append('image_url[]', image.raw);
    }

    try {
        await router.post('/admin/sanphams/store', formData, {
            onSuccess: page => {
                swal({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
                dialogVisible.value = false
                resetFormData()
            },
            onError: errors => console.log(errors)
        });

    } catch (error) {
        console.log(error);
    }
}

const resetFormData = () => {
    id.value = '';
    tensp.value = '';
    id_loaisp.value = '';
    id_thuonghieu.value = '';
    chitietsp.value = '';
    trangthaihienthi.value = '';
    hdsd.value = '';
    thanhphansp.value = '';
    image_url.value = '';
    soluongtonkho.value = '';
    gia.value = '';
    dialogImageUrl.value = '';
}

const openEditModal = (sanpham) => {
    editMode.value = true;
    isAddSP.value = false;
    dialogVisible.value = true;

    id.value = sanpham.id;
    tensp.value = sanpham.tensp;
    id_loaisp.value = sanpham.id_loaisp;
    id_thuonghieu.value = sanpham.id_thuonghieu;
    chitietsp.value = sanpham.chitietsp;
    trangthaihienthi.value = sanpham.trangthaihienthi;
    hdsd.value = sanpham.hdsd;
    thanhphansp.value = sanpham.thanhphansp;
    soluongtonkho.value = sanpham.soluongtonkho;
    gia.value = sanpham.gia;

    if (sanpham.image_url) {
        imageURL.value = [{
            name: sanpham.image_url,
            url: `/storage/${sanpham.image_url}`
        }];
    } else {
        imageURL.value = [];
    }
}

const updateSP = async () => {
    const formData = new FormData();
    formData.append('tensp', tensp.value);
    formData.append('id_loaisp', id_loaisp.value);
    formData.append('id_thuonghieu', id_thuonghieu.value);
    formData.append('chitietsp', chitietsp.value);
    formData.append('trangthaihienthi', trangthaihienthi.value);
    formData.append('gia', gia.value);
    formData.append('soluongtonkho', soluongtonkho.value);
    formData.append('hdsd', hdsd.value);
    formData.append('thanhphansp', thanhphansp.value);
    formData.append('giakhuyenmai', giakhuyenmai.value);
    if (sku.value) formData.append('sku', sku.value);
    formData.append('_method', 'PUT');

    // for (const image of imageURL.value) {
    //     formData.append('image_url[]', image.raw);
    // }
    if (imageURL.value.length > 0) {
        const file = imageURL.value[0];
        if (file.raw) {
            formData.append('image_url', file.raw);
        }
    }
    try {
        await router.post('/admin/sanphams/update/' + id.value, formData, {
            onSuccess: page => {
                dialogVisible.value = false
                resetFormData()
                swal({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
            },
        })

    } catch (error) {
        console.log(error);
    }
}

const deleteSP = (sanpham, index) => {
    swal({
        title: 'Bạn có chắc không?',
        text: `Hành động này không thể quay ngược lại.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            try {
                router.delete('/admin/sanphams/destroy/' + sanpham.id, {
                    onSuccess: page => {
                        this.delete(sanpham, index);
                        swal({
                            toast: true,
                            icon: 'success',
                            position: 'top-end',
                            showConfirmButton: false,
                            title: page.props.flash.success
                        })
                    }
                });
            } catch (error) {
                console.log(error);
            }

        }
    })
}
</script>

<template>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <!-- Bảng popup -->
        <el-dialog v-model="dialogVisible" :title="editMode ? 'Sửa sản phẩm' : 'Thêm sản phẩm'" width="30%"
            :before-close="handleClose">
            <!-- Form thêm sản phẩm -->
            <form class="max-w-md mx-auto" @submit.prevent="editMode ? updateSP() : themSP()">
                <div class="relative z-0 w-full mb-5 group">
                    <input v-model="tensp" type="text" name="floating_tensp" id="floating_tensp"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " required />
                    <label for="floating_tensp"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Tên
                        sản phẩm
                    </label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="floating_chitietsp" id="floating_chitietsp"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " required v-model="chitietsp" />
                    <label for="floating_chitietsp"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Chi
                        tiết sản phẩm</label>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="thanhphansp" id="thanhphansp"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " required v-model="thanhphansp" />
                    <label for="thanhphansp"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                        Thành phần sản phẩm</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="floating_hdsd" id="floating_hdsd"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " required v-model="hdsd" />
                    <label for="floating_hdsd"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                        HDSD</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="number" name="floating_gia" id="floating_gia"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " required v-model="gia" />
                    <label for="floating_hdsd"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                        Giá</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="number" name="floating_giakm" id="floating_giakm"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " required v-model="giakhuyenmai" />
                    <label for="floating_hdsd"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                        Giá khuyến mãi</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="number" name="floating_soluongtonkho" id="floating_soluongtonkho"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " required v-model="soluongtonkho" />
                    <label for="floating_hdsd"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                        Số lượng tồn kho</label>
                </div>

                <!-- Chọn loại sản phẩm -->
                <label for="loaisp" class="block mb-2.5 text-sm font-medium text-heading">Loại sản phẩm</label>
                <select id="loaisp" v-model="id_loaisp"
                    class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                    <option v-for="loaisp in loaisps" :key="loaisp.id" :value="loaisp.id">{{ loaisp.tenloai }}</option>
                </select>

                <!-- Chọn thương hiệu -->
                <label for="thuonghieu" class="block mb-2.5 text-sm font-medium text-heading">Thương hiệu</label>
                <select id="thuonghieu" v-model="id_thuonghieu"
                    class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                    <option v-for="thuonghieu in thuonghieus" :key="thuonghieu.id" :value="thuonghieu.id">{{
                        thuonghieu.tenthuonghieu }}</option>
                </select>

                <label for="trangthai" class="block mb-2.5 text-sm font-medium text-heading">Trạng thái hiển thị</label>
                <select id="trangthai" v-model="trangthaihienthi"
                    class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                    <option :key="1" value=1>Hiện</option>
                    <option :key="0" value=0>Không hiện</option>
                </select>

                <!-- Upload hình ảnh -->
                <div class="grid md:gap-6">
                    <div class="relative z-0 m-full mb-6 group">
                        <el-upload v-model:file-list="imageURL" list-type="picture-card"
                            :on-preview="handlePictureCardPreview" :on-remove="handleRemove"
                            :on-change="handleFileChange">
                            <el-icon>
                                <Plus />
                            </el-icon>
                        </el-upload>
                    </div>
                </div>

                <!-- Show ảnh trong bảng edit -->

                <button type="submit" style="margin-top: 5%;"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
            <!-- Form thêm sản phẩm -->
            <template #footer>
                <div class="dialog-footer">
                    <el-button @click="dialogVisible = false">Cancel</el-button>
                    <el-button type="primary" @click="dialogVisible = false">
                        Confirm
                    </el-button>
                </div>
            </template>
        </el-dialog>
        <!-- Bảng popup -->

        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search">
                            </div>
                        </form>
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button type="button" @click="openAddModal"
                            class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add product
                        </button>
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button">
                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                                Actions
                            </button>
                            <div id="actionsDropdown"
                                class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="actionsDropdownButton">
                                    <li>
                                        <a href="#"
                                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass
                                            Edit</a>
                                    </li>
                                </ul>
                                <div class="py-1">
                                    <a href="#"
                                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete
                                        all</a>
                                </div>
                            </div>
                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                    class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Filter
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <div id="filterDropdown"
                                class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose brand</h6>
                                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                    <li class="flex items-center">
                                        <input id="apple" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="apple"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Apple
                                            (56)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="fitbit" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="fitbit"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Microsoft
                                            (16)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="razor" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="razor"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Razor
                                            (49)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="nikon" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="nikon"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nikon
                                            (12)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="benq" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="benq"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">BenQ
                                            (74)</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Tên sản phẩm</th>
                                <th scope="col" class="px-4 py-3">Loại sản phẩm</th>
                                <th scope="col" class="px-4 py-3">Thương hiệu</th>
                                <th scope="col" class="px-4 py-3">Mô tả</th>
                                <th scope="col" class="px-4 py-3">Số lượng tồn kho</th>
                                <th scope="col" class="px-4 py-3">Giá</th>
                                <th scope="col" class="px-4 py-3">Giá khuyến mãi</th>
                                <th scope="col" class="px-4 py-3">Trạng thái hiển thị</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sanpham in sanphams" :key="sanpham.id" class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                        sanpham.tensp }}</th>
                                <td class="px-4 py-3">{{ sanpham.loaisp.tenloai }}</td>
                                <td class="px-4 py-3">{{ sanpham.thuonghieu.tenthuonghieu }}</td>
                                <td class="px-4 py-3">{{ sanpham.chitietsp }}</td>
                                <td class="px-4 py-3">{{ sanpham.soluongtonkho }}</td>
                                <td class="px-4 py-3">{{ sanpham.gia }}</td>
                                <td class="px-4 py-3">{{ sanpham.giakhuyenmai }}</td>
                                <td class="px-4 py-3">
                                    <button type="button" v-if="sanpham.trangthaihienthi == 1"
                                        class="text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-xs px-3 py-1.5 focus:outline-none">Hiển
                                        thị</button>
                                    <button type="button" v-else
                                        class="text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-xs px-3 py-1.5 focus:outline-none">Không
                                        hiển thị</button>
                                </td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button :id="'dropdown-button-' + sanpham.id"
                                        :data-dropdown-toggle="'dropdown-' + sanpham.id"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>

                                    <div :id="'dropdown-' + sanpham.id"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="'dropdown-button-' + sanpham.id">
                                            <li>
                                                <button @click="openEditModal(sanpham)"
                                                    class="block w-full text-left py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                    Edit
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" @click="deleteSP(sanpham, index)"
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page"
                                class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</template>