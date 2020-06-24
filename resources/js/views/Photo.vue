<template>
    <div class="photo">
        <div>
            <input type="file" ref="photos" multiple name="photos" id="photos">
            <button @click="submitFile">Submit</button>
        </div>
        <div class="liste" v-if="photos">
            <span class="photo" v-for="(photo, i) in photos" :key="i"><img :src="photo" alt=""/></span>
        </div>
    </div>
</template>

<script>
import axios from "axios"
export default {
    name: 'Photo',
    data() {
        return {
            photos: null,
            file: '',
        };
    },
    props: {
    },
    components: {

    },
    mounted() {
        this.mettreAJour()
    },
    methods: {
        mettreAJour() {
            axios.get("/api/photo").then(response => {
                this.photos = response.data;
            });
        },
        submitFile(){
            /*Initialize the form data*/
            let formData = new FormData();
            const files = Array.from(this.$refs.photos.files);
            /*Add the form data we need to submit*/
            files.forEach(file => {
                formData.append('photos[]', file);
            });

            /*Make the request to the POST /api/photo URL*/
            const options = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            axios.post('/api/photo', formData, options).then((data) => {
                this.mettreAJour();
            }).catch(() => {
                console.log('FAILURE!!');
            });
        },
    },
}
</script>

<style lang="scss">
.photos {
    color: inherit;
}
</style>

