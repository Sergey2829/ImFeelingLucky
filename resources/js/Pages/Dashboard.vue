<template>
    <Head title="Dashboard" />

    <div class="min-h-screen flex items-center justify-center">
        <a :href="link"  class="text-blue-500 underline">
             Your temporary game link
        </a>
    </div>
</template>

<script >


export default {
    props: {
        link: String
    }
}
</script>

