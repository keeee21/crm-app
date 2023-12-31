<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div>
        <h1>Inertia Test</h1>
        <a href="/">aタグ経由です</a><br><br>
        <Link href="/">Link経由です</Link>
        <br><br>
        <Link :href="route('inertia.index')">名前付きルート</Link>
    </div>
</template>
