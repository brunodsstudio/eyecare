

<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head } from '@inertiajs/vue2';

</script>

<script>
export default {
  data() {
    return {
      exames: [],
      filtro: "",
      perPage: 15,
      paginaAtual: 1,
      editModal: {
        show: false,
        exame: {}
      },
      deleteModal: {
        show: false,
        exame: null
      },
      createModal: {
        show: false,
        pacoteId: null,
        exame: {
            name: "",
            laterality: "OD",
            comment: "",
            group: ""
        }
      },
      fields: [
        { key: "name", label: "Nome" },
        { key: "laterality", label: "Lateralidade" },
        { key: "comment", label: "Comentário" },
        { key: "group", label: "Grupo" },
        { key: "actions", label: "Ações" }
      ],
      
    };
  },
  computed: {
    examesFiltrados() {
      if (!this.filtro) return this.exames;
      return this.exames.filter(e =>
        e.name.toLowerCase().includes(this.filtro.toLowerCase())
      );
    }
  },
  methods: {
    editar(exame) {
      this.editModal.exame = { ...exame };
      this.editModal.show = true;
    },
    salvarEdicao() {
      const index = this.exames.findIndex(e => e.id === this.editModal.exame.id);
      if (index !== -1) {
        this.$set(this.exames, index, { ...this.editModal.exame });
      }
      this.editModal.show = false;
    },
    excluir(exame) {
      this.deleteModal = {
        show: true,
        exame
      };
    },
    confirmarExclusao() {
      //this.exames = this.exames.filter(e => e.id !== this.deleteModal.exame.id);

      const del = new FormData()
      del.append("exameId", this.deleteModal.exame.id)

      axios.delete('api/exames/'+this.deleteModal.exame.id, {
        data: { 
          id: this.deleteModal.exame.id
        }
      })
        .then(response => {
            this.makeToast("success", "deleteado com sucesso!")
            this.exames = response.data;

            this.exames = []

            axios.get('api/exames')
              .then(response => {
                  this.exames = response.data;
              })
              .catch(error => {
                  console.error(error);
              });

        })
        .catch(error => {
            console.error(error);
        });

      this.deleteModal.show = false;
    },
    abrirModalCriacao(pacoteId) {
        this.createModal.pacoteId = pacoteId;
        this.createModal.exame = {
            name: "",
            laterality: "OD",
            comment: "",
            group: ""
        };
        this.createModal.show = true;
    },
    async criarExame() {
        const novoExame = { ...this.createModal.exame };
        try {
            const res = await axios.post(`/api/exames`, novoExame);
            //const pacote = this.pacotes.find(p => p.id === this.createModal.pacoteId);
            //pacote.exames.push(res.data); // API retorna o exame com ID criado
            this.exames = []
            this.makeToast("success", "criado com sucesso!")
            axios.get('api/exames')
            .then(response => {
                this.exames = response.data;
                console.log("recarregou");
            })
            .catch(error => {
                console.error(error);
            });
  

            this.createModal.show = false;
        } catch (err) {
            console.error("Erro ao criar exame:", err);
        }
    },
    makeToast(variant = null, msg) {
        this.$bvToast.toast(msg, {
          title: `Exames`,
          variant: variant,
          solid: true
        })
      }
  }, 
  mounted: function(){
    axios.get('api/exames')
        .then(response => {
            this.exames = response.data;
        })
        .catch(error => {
            console.error(error);
        });
  }
};
</script>

<template>
  <div class="container mt-4">
    <Head title="Dashboard" />

    <DefaultLayout>

    <b-form-group label="Buscar por Nome:" label-for="buscar">
      <b-form-input
        id="buscar"
        v-model="filtro"
        placeholder="Digite o nome do exame"
      />
    </b-form-group>

    <b-button variant="success" size="sm" @click="abrirModalCriacao()">
    + Adicionar Exame
    </b-button>

    <b-table
      :items="examesFiltrados"
      :fields="fields"
      :per-page="perPage"
      :current-page="paginaAtual"
      responsive
      bordered
      small
      class="mt-3"
    >
      <template #cell(actions)="row">
       <!-- <b-button size="sm" variant="warning" @click="editar(row.item)">Editar</b-button> -->
        <b-button size="sm" variant="danger" class="ml-2" @click="excluir(row.item)">Excluir</b-button>
      </template>
    </b-table>

    <b-pagination
      v-model="paginaAtual"
      :total-rows="examesFiltrados.length"
      :per-page="perPage"
      size="sm"
      class="my-2"
    />

    <!-- Modal de Edição -->
    <b-modal v-model="editModal.show" title="Editar Exame" @ok="salvarEdicao">
      <b-form>
        <b-form-group label="Nome">
          <b-form-input v-model="editModal.exame.name" />
        </b-form-group>
        <b-form-group label="Lateralidade">
          <b-form-select v-model="editModal.exame.laterality" :options="['OD', 'OE', 'AO']" />
        </b-form-group>
        <b-form-group label="Comentário">
          <b-form-textarea v-model="editModal.exame.comment" rows="2" />
        </b-form-group>
        <b-form-group label="Grupo">
          <b-form-input v-model="editModal.exame.group" />
        </b-form-group>
      </b-form>
    </b-modal>

    <!-- Modal de Confirmação de Exclusão -->
    <b-modal
      v-model="deleteModal.show"
      title="Confirmar Exclusão"
      @ok="confirmarExclusao"
      ok-title="Excluir"
      ok-variant="danger"
      cancel-title="Cancelar"
    >
      Deseja realmente excluir o exame <strong>{{ deleteModal.exame?.name }}</strong>?
    </b-modal>

    <!-- Modal de Criação de Exame -->
    <b-modal
    id="create-exame-modal"
    v-model="createModal.show"
    title="Adicionar Novo Exame"
    @ok="criarExame"
    ok-title="Criar"
    cancel-title="Cancelar"
    >
    <b-form>
        <b-form-group label="Nome">
        <b-form-input v-model="createModal.exame.name" />
        </b-form-group>
        <b-form-group label="Lateralidade">
        <b-form-select v-model="createModal.exame.laterality" :options="['OD', 'OE', 'AO']" />
        </b-form-group>
        <b-form-group label="Comentário">
        <b-form-textarea v-model="createModal.exame.comment" rows="2" />
        </b-form-group>
        <b-form-group label="Grupo">
        <b-form-select v-model="createModal.exame.group" :options="['Individual', 'Grupo 1', 'Grupo 2', 'Grupo 3','Grupo 4', 'Grupo 5']" />
        </b-form-group>
    </b-form>
    </b-modal>

 

  </DefaultLayout>
  </div>
</template>
