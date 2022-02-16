<template>
    <div class="app">
        <navbar></navbar>
        <router-view></router-view>
    </div>
</template>
<script>
import Navbar from "./components/Navbar";
import './styles/app.scss';

export default {
    name: 'App',
    components: {
        Navbar
    }
}
</script>
