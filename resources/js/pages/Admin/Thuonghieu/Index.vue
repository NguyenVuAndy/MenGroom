<template>
    <AdminLayout>
        <ListThuonghieu :thuonghieus="thuonghieus"></ListThuonghieu>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../Components/AdminLayout.vue';
import ListThuonghieu from './ListThuonghieu.vue';

defineProps({
    thuonghieus: Array
});
</script>
