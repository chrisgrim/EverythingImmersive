<template>
<div class="organization-form" >

    <multiselect v-show="organizers.length > 0" v-model="searchModel" placeholder="Select or Create Organizer"
        label="organizationName" track-by="organizationName" deselectLabel=''
        :allow-empty="false"  :options="searchOptions" @select="onSelect" >
        <template slot="option" slot-scope="props">
            <img class="option__image" :src="props.option.organizationImagePath ? `/storage/${props.option.organizationImagePath}` : defaultImage"
            alt="defaultImage">
            <div class="option__desc">
                <span class="option__title">{{ props.option.organizationName }}</span>
                <span class="option__small">{{ props.option.organizationDescription }}</span>
            </div>
        </template>
    </multiselect>

    <div v-show="showFormFields">
        <div class="image-upload-field">
            <label class="image-upload-label">Company logo/image</label>
            <label class="image-upload-wrapper"
                    :style="{ backgroundImage: `url('${organizationImageModel ? organizationImageModel : defaultImage}')` }" >
                <span class="image-upload-layover">
                    <div class="text-center">{{ organizationImageModel ? 'Change' : 'Upload' }}</div>
                </span>
                <image-upload name="avatar" @loaded="onImageUpload"></image-upload>
            </label>
        </div>

        <div class="floating-form">
            <div class="floating-label">
                <input class="floating-input" type="url" v-model="organizer.organizationName" placeholder=" ">
                <label>Company name</label>
            </div>
            <div class="floating-label">
                <textarea type="text" class="floating-input" v-model="organizer.organizationDescription" placeholder=" " rows="8"></textarea>
                <label>Description of Production Company</label>
            </div>
            <div class="floating-label">
                <input class="floating-input" type="url" v-model="organizer.organizationWebsite" placeholder=" ">
                <label>Enter Production Website</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="organizer.twitterHandle" placeholder=" ">
                <label>enter twitter handle</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="organizer.facebookHandle" placeholder=" ">
                <label>enter facebook handle</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="organizer.instagramHandle" placeholder=" ">
                <label>enter instagram handle</label>
            </div>
        </div>
    </div>

    <div>
        <button type="submit" class="create" @click.prevent="createOrganizer"> Save and Continue </button>
    </div>
</div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
import _ from 'lodash';
import ImageUpload from './imageupload.vue';

export default {
    components: {
        ImageUpload,
    },
    props: {
        organizers: { type: Array },
        event: { type: Object },
    },
    data() {
        return {
            showFormFields: false,
            searchModel: '',
            organizationImageModel: '',
            defaultImage: '/storage/website-files/upload.png',
            organizer: this.initializeOrganizerObject(),
            searchOptions: this.initiazeSearchOptions(),
        };
    },
    mounted() {
        if (_.has(this.event, 'organizer.id') && this.event.organizer.id !== null) {
            this.updateOrganizerFields(this.event.organizer);
            this.searchModel = this.event.organizer;
        }
    },
    methods: {
        initiazeSearchOptions() {
            const newOrganizer = this.initializeOrganizerObject();
            newOrganizer.organizationName = 'Create New Organizer';

            return _.concat(newOrganizer, this.organizers);
        },
        initializeOrganizerObject() {
            return {
                id: '',
                organizationName: '',
                organizationDescription: '',
                organizationWebsite: '',
                organizationImagePath: '',
                twitterHandle: '',
                instagramHandle: '',
                facebookHandle: '',
            };
        },
        onSelect(organizer) {
            this.updateOrganizerFields(organizer);
        },
        onImageUpload(image) {
            this.organizationImageModel = image.src;
            this.organizer.organizationImagePath = image.file;
        },
        updateOrganizerFields(input) {
            if ((input !== null) && (typeof input === "object") && (input.id !== null)) {
                this.showFormFields = true;

                // if input object has organizer fields then updated organizer object with their values
                this.organizer = _.pick(input, _.intersection( _.keys(this.organizer), _.keys(input) ));
                this.organizationImageModel = this.organizer.organizationImagePath ? `/storage/${this.organizer.organizationImagePath}` : '';
                if(input.id === '') { this.organizer.organizationName = '' }
            }
        },
        // post the form data to server
        createOrganizer() {
            const params  = new FormData();
            const headers = {'Content-Type': 'application/x-www-form-urlencoded'};

            for (var field in this.organizer) {
                params.append(field, this.organizer[field]);
            }

            // TODO:: add client side validations
            axios.post('/create-your-event/' + this.event.slug + '/organizer', params, headers).catch(error => {
                module.status = error.response.data.status;
            });
            // TODO:: process server side errors instead of moving on by default
            window.location.href = '/create-your-event/' + this.event.slug + '/dates';
        },
    },
};
</script>
