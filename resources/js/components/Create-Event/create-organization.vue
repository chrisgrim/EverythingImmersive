<template>
<div>
    <div class="organization-form">
        <multiselect 
        v-show="showSearchField" 
        v-model="searchModel" 
        placeholder="Select or Create Organizer"
        label="organizationName" 
        track-by="organizationName" 
        deselectLabel=''
        :allow-empty="false"  
        :options="searchOptions" 
        @select="onOrganizerSelect" >
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
            <input type="hidden" name="organizationImagePath"
                v-model="organizer.organizationImagePath"
                v-validate="'required'" data-vv-as="Production Company Image" >
            <span class="text-sm text-danger">{{ errors.first('organizationImagePath') }}</span>
        </div>
        <div class="floating-form">
            <div class="floating-label">
                <input type="text" class="floating-input" placeholder=" " name="organizationName"
                v-model="organizer.organizationName"
                v-validate="'required|min:3'" data-vv-as="Production Company Name">
                <label>Enter Production Company name</label>
                <span class="text-sm text-danger">{{ errors.first('organizationName') }}</span>
            </div>
            <div class="floating-label">
                <textarea type="text" class="floating-input" name="organizationDescription" data-vv-as="Production Company Description" v-validate="'required|min:3'" v-model="organizer.organizationDescription" placeholder=" " rows="8"></textarea>
                <label>Description of Production Company</label>
                <span class="text-sm text-danger">{{ errors.first('organizationDescription') }}</span>
            </div>
            <div class="floating-label">
                <input class="floating-input" type="url" v-model="organizer.organizationWebsite" name="organizationWebsite" v-validate="'required|url'" data-vv-as="Production Company Website" placeholder=" ">
                <label>Enter Production Website</label>
                <span class="text-sm text-danger">{{ errors.first('organizationWebsite') }}</span>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="organizer.twitterHandle" name="twitterHandle" v-validate="'max:15'" data-vv-as="Twitter Handle" placeholder=" ">
                <label>enter twitter handle</label>
                <span class="text-sm text-danger">{{ errors.first('twitterHandle') }}</span>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="organizer.facebookHandle" name="facebookHandle" v-validate="'max:50'" data-vv-as=" Facebook Handle" placeholder=" ">
                <label>enter facebook handle</label>
                <span class="text-sm text-danger">{{ errors.first('facebookHandle') }}</span>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="organizer.instagramHandle" name="instagramHandle" v-validate="'max:30'" placeholder=" ">
                <label>enter instagram handle</label>
                <span class="text-sm text-danger">{{ errors.first('instagramHandle') }}</span>
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
            searchModel: '',
            organizationImageModel: '',
            defaultImage: '/storage/website-files/upload.png',
            showSearchField: _.isEmpty(this.organizers) ? false : true,
            showFormFields: _.isEmpty(this.organizers) ? true : false,
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

        onOrganizerSelect(organizer) {
            this.updateOrganizerFields(organizer);
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
            async onImageUpload(image) {
                const { valid, errors } = await this,$validator.verify(image.file, 'image', {'name' : 'Organization Image'});
                if(!valid) {
                    this.errors.remove('organizationImagePath');
                    this.errors.add({ field: 'organizationImagePath', msg: errors[0]});
                    return false;
                }

                this.organizationImageModel = image.src;
                this.organizer.organizationImagePath = image.file;
            },
            async createOrganizer() {
            //do not go further if there are validation errors
            if( !await.this.$validator.validate()) { return false; }

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
         if (_.has(this.event, 'organizer.id') && this.event.organizer.id !== null) {
            this.updateOrganizerFields(this.event.organizer);
            this.searchModel = this.event.organizer;
        }
    },
};
</script>