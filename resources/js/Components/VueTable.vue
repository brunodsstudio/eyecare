<template>
  <div>
  <vuetable
    :fields="fields"
    :api-url="apiUrl"
    :sort-by="sortBy"
    :per-page="perPage"
    data-path=""
    pagination-path=""
  />

  </vuetable>
</div>

</template>

<script>
import Vuetable from 'vuetable-2';

export default {
  components: {
    Vuetable
  },
  data() {
    return {
      apiUrl: '/api/exames',
      fields: [
        { name: 'name', title: 'Name' },
        { name: 'laterality', title: 'laterality' },
        { name: 'group', title: 'group' },
        { name: 'comment', title: 'comment' },
        
      ],
      sortBy: 'name',
      perPage: 10
    };
  }
};
</script>