<template>
<div>
    <div class="organization-form">
        <h2> Add a cover image</h2>
    </div>
    <div>
        <p>Choose an image that best shows off your event</p>
    </div>
        
    <div class="image-upload-field">
        <form method="POST" enctype="multipart/form-data">
            <label class="image-upload-label">Event image</label>
            <label class="image-upload-wrapper"
                    :style="{ backgroundImage: `url('${eventImage ? eventImage : defaultImage}')` }" >
                <span class="image-upload-layover">
                    <div class="text-center">{{ eventImage ? 'Change' : 'Upload' }}</div>
                </span>
                <image-upload name="eventImage" @loaded="onImageUpload"></image-upload>
            </label>
        </form>
    </div>
    <div>
        <button type="submit" class="create" @click.prevent="createImage()"> Save and Continue </button>
    </div>
</div>

</template>

<script>
import _ from 'lodash';
import ImageUpload from '../imageupload.vue';


export default {
    components: { 
        ImageUpload,
    },
    
    props: {
        event: { type: Object }
    },
    
    data() {
        return {
            eventImage: this.event.eventImagePath ? `/storage/${this.event.eventImagePath}` : '',
            defaultImage: '/storage/website-files/upload.png',
            eventUrl:_.has(this.event, 'slug') ? `/create-your-event/${this.event.slug}` : null,
        };
    },

    methods: {

        onImageUpload(image) {
            this.eventImage = image.src;
            this.event.eventImagePath = image.file;

        },

        createImage() {
            let data = new FormData();
            data.append('eventImage', this.eventImage);
            const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

            console.log(this.eventImage);

            axios.post('/create-your-event/' + this.event.slug + '/images', {
                data: this.data,
                _method: 'patch',
                
            })
            .then(response => {
                // all is well. move on to the next page
                console.log(response.data);
            });
        },
    },
    
};
</script>