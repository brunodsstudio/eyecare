
<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >
      <v-sheet
        color="grey lighten-4"
        class="pa-4"
      >
        <v-avatar
          class="mb-4"
          color="grey darken-1"
          size="64"
        ></v-avatar>

        <div>john@vuetifyjs.com</div>
      </v-sheet>

      <v-divider></v-divider>

      <v-list>
        <v-list-item
          v-for="[icon, text, href] in links"
          :key="icon"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title><a :href="href">{{ text }}</a></v-list-item-title>
          </v-list-item-content>
        
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title>
            <slot name="header" />
        </v-toolbar-title>
    </v-app-bar>

    <v-main>
      <slot />
    </v-main>
  </v-app>
</template>

<script setup>

      defineProps({
          drawer: {
              type: Boolean,
              default:true,
              required:false
          },
      });

         
           const links =  [
                ['mdi-inbox-arrow-down', 'Pacotes', '/dashboard'],
                ['mdi-send', 'Exames', '/Exames'],
             
            ];
       
</script>