<template>
    <vue-particles id="tsparticles" @particles-loaded="particlesLoaded" url="js/particles.json" />

</template>
<script setup>
const particlesLoaded = async container => {
    console.log("Particles container loaded", container);
};
</script>
