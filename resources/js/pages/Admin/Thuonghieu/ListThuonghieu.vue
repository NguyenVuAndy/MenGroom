<script setup>
import { router } from '@inertiajs/vue3';
import { ref, inject } from 'vue';

const swal = inject('$swal');

defineProps({
    thuonghieus: Array,
});

const dialogVisible = ref(false);
const editMode = ref(false);

const id = ref('');
const tenthuonghieu = ref('');
const mota_thuonghieu = ref('');
const logo_url = ref(null);
const imagePreview = ref(null);

const openAddModal = () => {
    resetFormData();
    editMode.value = false;
    dialogVisible.value = true;
}

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        logo_url.value = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const themThuonghieu = async () => {
    const formData = new FormData();
    formData.append('tenthuonghieu', tenthuonghieu.value);
    formData.append('mota_thuonghieu', mota_thuonghieu.value);
    if (logo_url.value) {
        formData.append('logo_url', logo_url.value);
    }

    try {
        await router.post('/admin/thuonghieus/store', formData, {
            onSuccess: page => {
                swal({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                });
                dialogVisible.value = false;
                resetFormData();
            },
            onError: errors => console.log(errors)
        });
    } catch (error) {
        console.log(error);
    }
}

const resetFormData = () => {
    id.value = '';
    tenthuonghieu.value = '';
    mota_thuonghieu.value = '';
    logo_url.value = null;
    imagePreview.value = null;
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.value = '';
    }
}

const openEditModal = (thuonghieu) => {
    resetFormData();
    editMode.value = true;
    dialogVisible.value = true;

    id.value = thuonghieu.id;
    tenthuonghieu.value = thuonghieu.tenthuonghieu;
    mota_thuonghieu.value = thuonghieu.mota_thuonghieu;
    if (thuonghieu.logo_url) {
        imagePreview.value = `/storage/${thuonghieu.logo_url}`;
    }
};

const updateThuonghieu = async () => {
    const formData = new FormData();
    formData.append('tenthuonghieu', tenthuonghieu.value);
    formData.append('mota_thuonghieu', mota_thuonghieu.value);
    if (logo_url.value) {
        formData.append('logo_url', logo_url.value);
    }
    formData.append('_method', 'PUT');

    try {
        await router.post('/admin/thuonghieus/update/' + id.value, formData, {
            onSuccess: page => {
                dialogVisible.value = false;
                resetFormData();
                swal({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                });
            },
        });
    } catch (error) {
        console.log(error);
    }
}

const deleteThuonghieu = (thuonghieu) => {
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
                router.delete('/admin/thuonghieus/destroy/' + thuonghieu.id, {
                    onSuccess: page => {
                        swal({
                            toast: true,
                            icon: 'success',
                            position: 'top-end',
                            showConfirmButton: false,
                            title: page.props.flash.success
                        });
                    }
                });
            } catch (error) {
                console.log(error);
            }
        }
    });
}
</script>

<template>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <el-dialog v-model="dialogVisible" :title="editMode ? 'Sửa thương hiệu' : 'Thêm thương hiệu'" width="30%">
            <form class="max-w-md mx-auto" @submit.prevent="editMode ? updateThuonghieu() : themThuonghieu()">
                <div class="relative z-0 w-full mb-5 group">
                    <input v-model="tenthuonghieu" type="text" name="floating_tenthuonghieu" id="floating_tenthuonghieu"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " required />
                    <label for="floating_tenthuonghieu"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Tên
                        thương hiệu
                    </label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="floating_mota_thuonghieu" id="floating_mota_thuonghieu"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " v-model="mota_thuonghieu" />
                    <label for="floating_mota_thuonghieu"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Mô
                        tả</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <label for="logo_url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logo</label>
                    <input @change="handleFileChange"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        id="logo_url" type="file">
                    <div v-if="imagePreview" class="mt-4">
                        <img :src="imagePreview" class="h-auto max-w-full" />
                    </div>
                </div>
                <button type="submit" style="margin-top: 5%;"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </el-dialog>

        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
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
                            Thêm thương hiệu
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Logo</th>
                                <th scope="col" class="px-4 py-3">Tên thương hiệu</th>
                                <th scope="col" class="px-4 py-3">Mô tả</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="thuonghieu in thuonghieus" :key="thuonghieu.id"
                                class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">
                                    <img v-if="thuonghieu.logo_url" :src="`/storage/${thuonghieu.logo_url}`"
                                        class="h-10 w-10 object-cover rounded-full" />
                                </td>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                        thuonghieu.tenthuonghieu }}</th>
                                <td class="px-4 py-3">{{ thuonghieu.mota_thuonghieu }}</td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button @click="openEditModal(thuonghieu)"
                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Edit
                                    </button>
                                    <button @click="deleteThuonghieu(thuonghieu)"
                                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>
