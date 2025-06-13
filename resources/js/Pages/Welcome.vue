<template>
  <v-app>
    <v-container>
      <v-row>
        <v-col cols="12">
          <div class="logo" style="width:100px; height: 100px;"></div>
        
          <h1>Hello, World!zxxx sss</h1>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>
 
<script>
import { defineComponent } from "vue";

export default defineComponent({
 name: 'welcome',
    mounted: function() {
        window.setTimeout(function() {
            $('.logo').css('background-color', "#000fff");   
        }, 1000);
    } 
});
</script>
 