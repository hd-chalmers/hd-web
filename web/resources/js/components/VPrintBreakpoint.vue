<template>
    <div>
        Breakpoint:
        <span class="hidden-sm-and-up">
            XS - Small to large handset
        </span>
        <span class="hidden-xs-only hidden-md-and-up">
            SM - Small to medium tablet
        </span>
        <span class="hidden-sm-and-down hidden-lg-and-up">
            MD - Large tablet to laptop
        </span>
        <span class="hidden-xl-only hidden-md-and-down">
            LG - Desktop
        </span>
        <span class="hidden-lg-and-down">
            XL - 4k and ultra-wides
        </span>
    </div>
</template>

<script>
export default {
    name: "v-print-breakpoint"
}
</script>

<style scoped>

</style>
