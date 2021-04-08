<template>
    <img :src="imageSrc" alt="post" />
</template>

<script>
export default {
    data() {
        return {
            imageSrc: ''
        };
    },
    props:[
        'url',
    ],
    created() {
        axios
            .get(this.url)
            .then( response => this.imageSrc = response.data.media_details.sizes.medium.source_url );
    }
};
</script>

<style></style>
