<template>
<div>
    <div class="organization-form">
        <multiselect 
        v-show="organizers.length > 0" 
        v-model="searchModel" 
        placeholder="Select or Create Organizer"
        label="organizationName" 
        track-by="organizationName" 
        deselectLabel=''
        :allow-empty="false"  
        :options="searchOptions" 
        @select="onSelect" >
            <template slot="option" slot-scope="props">
                <img class="option__image" :src="props.option.organizationImagePath ? `/storage/${props.option.organizationImagePath}` : defaultImage"
                alt="defaultImage">
                <div class="option__desc">
                    <span class="option__title">{{ props.option.organizationName }}</span>
                    <span class="option__small">{{ props.option.organizationDescription }}</span>
                </div>
            </template>
            <span slot="noResult">Create A New</span>
        </multiselect>
    </div>
        
    <div v-show="showFormFields">
        <div class="image-upload-field">
            <label class="image-upload-label">Company logo/image</label>
            <label class="image-upload-wrapper"
                    :style="{ backgroundImage: `url('${organizationImageModel ? organizationImageModel : defaultImage}')` }" >
                <span class="image-upload-layover">
                    <div class="text-center">{{ organizationImageModel ? 'Change' : 'Upload' }}</div>
                </span>
                <image-upload @loaded="onImageUpload"></image-upload>
            </label>
        </div>
        <div class="floating-form">
            <div class="floating-label">
                <input class="floating-input" v-model="organizer.organizationName" placeholder=" ">
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

<script>
import _ from 'lodash';
import ImageUpload from '../imageupload.vue';
import Multiselect from 'vue-multiselect'


export default {
    components: { 
        ImageUpload,
        Multiselect,
    },
    
    props: {
    	organizers: { type: Array },
        event: { type: Object }
    },
    
    data() {
        return {
            showFormFields: false,
            searchModel: '',
            organizationImageModel: '',
            defaultImage: '/storage/website-files/upload.png',
            organizer: this.initializeOrganizerObject(),
            searchOptions: this.initializeSearchOptions(),
            eventUrl:_.has(this.event, 'slug') ? `/create-your-event/${this.event.slug}` : null,
        };
    },

    methods: {

        initializeSearchOptions() {
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
                tempImage: '',
                organizationImagePath: '',
                twitterHandle: '',
                facebookHandle: '',
                instagramHandle: ''
            }
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
                this.showAutoComplete = false;
                this.showFormFields = true;

                this.organizer = _.pick(input, _.intersection( _.keys(this.organizer), _.keys(input) ));
                this.organizationImageModel = this.organizer.organizationImagePath ? `/storage/${this.organizer.organizationImagePath}` : '';
                if(input.id === '') { this.organizer.organizationName = '' }
            }
        },

        createOrganizer() {
            const params = new FormData();
            const headers = {'Content-Type': 'application/x-www-form-urlencoded'};

            for (var field in this.organizer) {
                params.append(field, this.organizer[field]);
            }

            // post the form data to server
            axios.post(`${this.eventUrl}/organizer`, params, headers)
            .then(response => {
                // all is well. move on to the next page
                window.location.href = `${this.eventUrl}/dates`;
            })
            .catch(errorResponse => {
                // show if there are server side validation errors
                if (!_.has(errorResponse, 'response.data.errors')) { return false; }
                for (const [field, errors] of Object.entries(errorResponse.response.data.errors)) {
                    for (const error in errors) {
                        this.errors.add({ field: field, msg: errors[error] });
                    }
                }
            });
        },
    },

    mounted() {
        this.updateOrganizerFields(this.event.organizer)
    },
    
};
</script>