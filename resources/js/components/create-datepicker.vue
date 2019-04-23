<template>
  <div>
    <div class="datepicker-trigger">
      <input
        type="text"
        id="datepicker-trigger"
        placeholder="Select dates"
        :value="formatFirstDate(dateOne)"
      >

      <AirbnbStyleDatepicker
        :trigger-element-id="'datepicker-trigger'"
        :closeAfterSelect="false"
        :mode="'single'"
        :monthsToShow="1"
        :fullscreen-mobile="true"
        :startOpen="true"
        :date-one="dateOne"
        @date-one-selected="val => { dateOne = val }"
      />
    </div>

    <div class="datepicker-trigger">
      <input
        type="text"
        id="datepicker-trigger1"
        placeholder="Select dates"
        :value="formatSecondDate(dateTwo)"
      >

      <AirbnbStyleDatepicker
        :trigger-element-id="'datepicker-trigger1'"
        :closeAfterSelect="false"
        :mode="'single'"
        :monthsToShow="1"
        :fullscreen-mobile="true"
        :startOpen="true"
        :date-two="dateTwo"
        @date-two-selected="val => { dateTwo = val }"
      />
    </div>
    
    
    
  </div>
</template>

<script>
import format from 'date-fns/format'

export default {
  data() {
    return {
      dateFormat: 'D MMM',
      dateOne: '',
      dateTwo: ''
    }
  },
    methods: {
        formatFirstDate(dateOne) {
            let formattedDates = ''
                if (dateOne) {
                    formattedDates = format(dateOne, this.dateFormat)
                } 
            return formattedDates
        },

        formatSecondDate(dateTwo) {
            let formattedDates = ''
                if (dateTwo) {
                    formattedDates = format(dateTwo, this.dateFormat)
                } 
            return formattedDates
        },
    },
}
</script>