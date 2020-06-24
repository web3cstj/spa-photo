<template>
    <div class="photo">
        <div class="liste" v-if="photos">
            <div class="photo" v-for="(photo, i) in photos" :key="i"><img :src="photo" alt=""/></div>
        </div>
        <div>
            <input type="file" ref="photo" name="photo" id="photo" @change="changePhoto">
            <button @click="submitFile">Submit</button>
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
        changePhoto() {
            this.file = this.$refs.photo.files[0];
        },
        submitFile(){
            /*Initialize the form data*/
            let formData = new FormData();

            /*Add the form data we need to submit*/
            formData.append('file', this.file);

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

