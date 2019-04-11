<template>
<div>
  <div>
        <br>
        <h4>Organization Name</h4>
  </div>
    <div class="autocomplete">
        <input type="text"
        v-model="search"
        @input="onChange"
        @keydown.down="onArrowDown"
        @keydown.up="onArrowUp"
        @keydown.enter.prevent="onEnter" 
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
           
            <div id="New Organizer" v-if="isNew">
                <div>
                    <br>
                    <h4>Organization Description</h4>
                </div>
                <div>
                    <input type="text" v-model="description">
                </div>
                
      
            </div>

            <div id="Exisiting Organizer" v-if="exists">
                <div >
                    <div>
                        <br>
                        <h4>Organization Description</h4>
                    </div>
                    <div>
                        {{ description }}
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <button type="submit" class="create" @click.prevent="create"> Save and Continue </button>
        </div>
    </div>
    
  
</template>

<script>
  export default {
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
            search: this.event.organizer.organizationName,
            description: this.event.organizer.organizationDescription,
            results: [],
            isOpen:false,
            isNew:false,
            exists:false,
            arrowCounter: -1,
            result:'',
            organizationId: this.event.organizer_id,
        };
    },

    computed: {
        existingOrganization() {
            return this.items[this.event.organizer_id - 1];
        }

    },
    

    methods: {

        create() {
            var data = {
                'organizationName': this.search,
                'organizationDescription': this.description,
            };

            axios.post('/create-your-event/' + this.event.slug + '/organizer', data);
            window.location.href = '/create-your-event/' + this.event.slug + '/description';

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
        },
        setResult(result) {
            this.search = result.organizationName;
            this.description = result.organizationDescription;
            this.organizationId = result.id;
            this.isOpen = false;
            this.exists = true;
            this.isNew = false;
            this.result = result;
        },
        onChange() {
            this.isOpen = true;
            this.filterResults();
            this.exists = false;
            this.isNew = true;
            this.description = '';
            this.organizationId = '';

        },
        filterResults() {
          	this.results = this.items.filter(item => item.organizationName.toLowerCase().indexOf(this.search.toLowerCase()) > -1);
        },
        
    },
};
</script>