<template>
    <v-card>

    <v-card-title>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>

    <v-data-table
        :headers="headers"
        :items="data"
        :items-per-page="5"
        class="elevation-1"
    >

    <v-toolbar-title>My CRUD</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>

        <template v-slot:item.actions="{ item }">
            <v-icon
                small
                class="mr-2"
                @click="editItem(item)"
            >
                mdi-pencil
            </v-icon>
            <v-icon
                small
                @click="deleteItem(item)"
            >
                mdi-delete
            </v-icon>
            </template>
    </v-data-table>

   </v-card>
</template>

<script>
  export default {
    components: {
  },
    data () {
      return {
        data: [],
        search: '',
        headers: [
            {
                text: 'Pacote nome',
                align: 'start',
                sortable: false,
                value: 'name',
            },
            { text: 'observations', 
                value: 'observations' 
            },
            {   text: 'Actions', 
                value: 'actions', 
                sortable: false 
            }
        ],
        
      }
    }, methods: {
        getData() {
            return axios
                .get("api/pacotes", {
                dataType: "json",
                })
                .then((response) => {
                    this.data = response.data
                    console.log(response.data)
                })
                .catch((err) => alert(err));
        },
        
    }, mounted(){
        this.getData();
    }
}
</script>