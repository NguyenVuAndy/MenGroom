<template>
    <AdminLayout>
        <ListSanPham :sanphams="sanphams"></ListSanPham>
    </AdminLayout>
</template>

<script setup>
defineProps({
    sanphams: Array
});

// import sanphams from '@/routes/admin/sanphams';
import AdminLayout from '../Components/AdminLayout.vue';
import ListSanPham from './ListSanPham.vue';
</script>