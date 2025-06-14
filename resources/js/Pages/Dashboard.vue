<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import VuetifyTable from '@/Components/VuetifyTable.vue';
import Dialog from '@/Components/Dialog.vue';

import { Head } from '@inertiajs/vue2';
</script>

<script>
    export default {
    components: {
       
    },
    data() {
        return {
        fields: [
            { name: 'name', title: 'Name' },
            { name: 'laterality', title: 'laterality' },
            { name: 'group', title: 'group' },
            { name: 'comment', title: 'comment' },
            
        ],
        exames:[],
        exame:null,
        };
    },mounted: function () {
        axios.get('api/exames')
        .then(response => {
           /* const dt = response.data.map(dta =>(
                {
                    name: dta.name, 
                    id: dta.id
                }
            ))*/

            const dt = response.data.map(dta=>(
                dta.name +": "+ dta.laterality
            ))

            this.exames = dt;
        })
        .catch(error => {
            console.error(error);
        });

    },watch: {
        
    },methods: {
        
    }
};

</script>

<template>
    <div>
    <Head title="Dashboard" />

    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

      
       
       
        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div> -->
         <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                  
            
        <div data-app>

        <v-row
            
                no-gutters
                style=""
            >
            <v-col 
                cols="12"
                sm="6"
                md="8"
                >
                    <v-autocomplete
                        v-model="exame"
                        class="mx-4"
                        :items="exames"
                        item-value="id"
                        item-title="name"
                        outlined
                        dense
                        filled
                        label="Exames"
                        prepend-icon="mdi-city"
                        
                    >
                    </v-autocomplete>
            </v-col>

            <v-col
            cols="6"
                md="4">
            <Dialog></Dialog>
            </v-col>
        </v-row>


        </div>
              <VuetifyTable></VuetifyTable>
        </div>
        </div>
      
        
    </DefaultLayout>
</div>
</template>
