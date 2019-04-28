<template>
<div>
    <div>
        <br>
        <h4>Production Company Name</h4>
    </div>
    <div class="autocomplete floating-form">
        <div class="floating-label">
            <input type="text"
            v-model="search"
            @input="onChange"
            @keydown.down="onArrowDown"
            @keydown.up="onArrowUp"
            @keydown.enter.prevent="onEnter" 
            class="floating-input"
            placeholder=" " 
            />
                <div 
                v-show="isOpen"
                class="autocomplete-results">
                    <div 
                    v-for="(result, i) in results"
                    :key="i"
                    @click="setResult(result)"
                    class="autocomplete-result"
                    :class="{ 'is-active': i === arrowCounter }"
                    >
                        {{ result.organizationName }}
                    </div>
                </div>
            <label>Production Company name</label>
        </div>
    </div>
    <div class="profile-image" :style="{ backgroundImage: 'url(' + organizerImage + ')' }">
        
    </div>
           
    <div id="New Organizer" v-if="isNew">
        <div style="backgroundImage: url('/storage/website-files/upload.png'); background-repeat:no-repeat; display:inline-block; background-size: contain;" >
                <label class="imgclick float" :style="{ backgroundImage: 'url(' + avatar + ')' }">
                    <image-upload name="avatar" @loaded="onLoad"></image-upload>
                </label>
        </div>
        <div class="floating-form">
            <div class="floating-label">
                <textarea type="text" class="floating-input" v-model="description" placeholder=" " rows="8"></textarea>
                <label>Description of Production Company</label>
            </div>
            <div class="floating-label">
                <input class="floating-input" type="url" v-model="organizerWebsite" placeholder=" ">
                <label>Enter Production Website</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="twitter" placeholder=" ">
                <label>enter twitter handle</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="facebook" placeholder=" ">
                <label>enter facebook handle</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="instagram" placeholder=" ">
                <label>enter instagram handle</label>
            </div>
        </div>
    </div>

    <div id="Exisiting Organizer" v-if="exists">
        <div>
            <div>
                <br>
                <h4>Organization Description</h4>
            </div>
            <div>
                {{ description }}
            </div>
            <div>
                facebook:
                {{ facebook }}
            </div>
            <div>
                instgram:
                {{ instagram }}
            </div>
            <div>
                twitter:
                {{ twitter }}
            </div>
            <div>
                Website:
                <br>
                {{ organizerWebsite }}
            </div>
        </div>
    </div>
    <div class="">
        <button type="submit" class="create" @click.prevent="create"> Save and Continue </button>
    </div>
</div>

</template>

<script>
    import ImageUpload from './imageupload.vue';
    export default {

    components: { 
        ImageUpload 
    },
    
    props: {
    	items: {
    		type: Array,
    	},
        event: {
            type: Object,
        }
    },
    
    data() {
        return {
            search: '',
            description: '',
            twitter: '',
            facebook: '',
            instagram: '',
            results: [],
            isOpen:false,
            isNew:false,
            exists:false,
            arrowCounter: -1,
            result:'',
            organizationId: this.event.organizer_id,
            organizerImage:'',
            organizerWebsite:'',
            avatar: '',
            file: '',
        };
    },

    computed: {
        existingOrganization() {
            return this.items[this.event.organizer_id - 1];
        },

    },
    

    methods: {
        onLoad(avatar) {
                this.avatar = avatar.src;
                this.file = avatar.file;
        },
        create() {
            let data = new FormData();
            //this is image I want to add to data
            data.append('avatar', this.file)
            data.append('organizationName',this.search)
            data.append('organizationDescription',this.description)
            data.append('organizationWebsite',this.organizerWebsite)
            data.append('twitterHandle',this.twitter)
            data.append('facebookHandle',this.facebook)
            data.append('instagramHandle',this.instagram)

            axios.post('/create-your-event/' + this.event.slug + '/organizer', data).catch(error => {
                module.status = error.response.data.status;
            });

            window.location.href = '/create-your-event/' + this.event.slug + '/dates'; 
        },

        onArrowDown() {
          if (this.arrowCounter < this.results.length) {
            this.arrowCounter = this.arrowCounter + 1;
          }
        },
        onArrowUp() {
          if (this.arrowCounter > 0) {
            this.arrowCounter = this.arrowCounter - 1;
          }
        },
        onEnter() {
            this.result = this.results[this.arrowCounter];
            this.search = this.result.organizationName;
            this.organizationId = this.result.id;
            this.description = this.result.organizationDescription;
            this.isOpen = false;
            this.exists = true;
            this.isNew = false;
            this.arrowCounter = -1;
            this.facebook = this.result.facebookHandle;
            this.instagram = this.result.instagramHandle;
            this.twitter = this.result.twitterHandle;
            this.organizerWebsite = this.result.organizationWebsite;
            this.organizerImage = '/storage/' + this.result.organizationImagePath;
        },
        setResult(result) {
            this.search = result.organizationName;
            this.description = result.organizationDescription;
            this.organizationId = result.id;
            this.isOpen = false;
            this.exists = true;
            this.isNew = false;
            this.result = result;
            this.facebook = result.facebookHandle;
            this.instagram = result.instagramHandle;
            this.twitter = result.twitterHandle;
            this.organizerWebsite = result.organizationWebsite;
            this.organizerImage = '/storage/' + result.organizationImagePath;
        },
        onChange() {
            this.isOpen = true;
            this.filterResults();
            this.exists = false;
            this.isNew = true;
            this.description = '';
            this.organizationId = '';
            this.facebook = '';
            this.instagram = '';
            this.twitter = '';
            this.organizerImage = '';
            this.organizerWebsite = '';

        },
        filterResults() {
          	this.results = this.items.filter(item => item.organizationName.toLowerCase().indexOf(this.search.toLowerCase()) > -1);
        },
        init() {
                this.search = this.event.organizer.organizationName;
                this.description = this.event.organizer.organizationDescription;
                this.facebook = this.event.organizer.facebookHandle;
                this.instagram = this.event.organizer.instagramHandle;
                this.twitter = this.event.organizer.twitterHandle;
                this.organizerImage = '/storage/' + this.event.organizer.organizationImagePath;
                this.organizerWebsite = this.event.organizer.organizationWebsite;
                this.exists = true;
                this.avatar = this.event.organizer.organizationImagePath;
        }
    },
    mounted() {
        this.init()
    },
};
</script>