<template>
    <AdminLayout>
        <ListLoaiSP :loaisps="loaisps"></ListLoaiSP>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../Components/AdminLayout.vue';
import ListLoaiSP from './ListLoaiSP.vue';

defineProps({
    loaisps: Array
});
</script>
