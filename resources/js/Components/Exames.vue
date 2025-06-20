<template>
  <div class="container mt-4">
    <h2>Lista de Exames</h2>

    <b-form-group label="Buscar por Nome do Exame:">
      <b-form-input v-model="filtro" placeholder="Digite parte do nome..." />
    </b-form-group>

    <b-table
      :items="examesFiltrados"
      :fields="fields"
      :per-page="perPage"
      :current-page="paginaAtual"
      @page-change="paginaAtual = $event"
      responsive
      small
      bordered
    >
      <template #cell(actions)="row">
        <b-button size="sm" variant="warning" @click="editarExame(row.item)">Editar</b-button>
        <b-button size="sm" variant="danger" class="ml-2" @click="excluirExame(row.item)">Excluir</b-button>
      </template>
    </b-table>

    <b-pagination
      v-model="paginaAtual"
      :total-rows="examesFiltrados.length"
      :per-page="perPage"
      size="sm"
      class="mt-2"
    />

    <!-- Modal de Edição -->
    <b-modal v-model="editModal.show" title="Editar Exame" @ok="salvarEdicao" ok-title="Salvar">
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

    <!-- Modal de Exclusão -->
    <b-modal
      v-model="deleteModal.show"
      title="Confirmar Exclusão"
      @ok="confirmarExclusao"
      ok-variant="danger"
      ok-title="Excluir"
      cancel-title="Cancelar"
    >
      Deseja excluir o exame <strong>{{ deleteModal.exame?.name }}</strong>?
    </b-modal>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      exames: [],
      filtro: "",
      perPage: 5,
      paginaAtual: 1,
      fields: [
        { key: "name", label: "Nome" },
        { key: "laterality", label: "Lateralidade" },
        { key: "comment", label: "Comentário" },
        { key: "group", label: "Grupo" },
        { key: "created_at", label: "Criado em" },
        { key: "actions", label: "Ações" }
      ],
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
}
    };
  },
  mounted() {
    this.carregarExames();
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
    async carregarExames() {
      try {
        const res = await axios.get("/api/exames");
        this.exames = res.data;
      } catch (err) {
        console.error("Erro ao buscar exames:", err);
        // Fallback para teste:
        
      }
    },
    editarExame(exame) {
      this.editModal = {
        show: true,
        exame: { ...exame }
      };
    },
    async salvarEdicao() {
      try {
        const exame = this.editModal.exame;
        await axios.put(`/api/exames/${exame.id}`, exame);

        const index = this.exames.findIndex(e => e.id === exame.id);
        if (index !== -1) {
          this.$set(this.exames, index, { ...exame });
        }
        this.editModal.show = false;
      } catch (err) {
        console.error("Erro ao salvar edição:", err);
      }
    },
    excluirExame(exame) {
      this.deleteModal = {
        show: true,
        exame
      };
    },
    async confirmarExclusao() {
      try {
        const exame = this.deleteModal.exame;
        await axios.delete(`/api/exames/${exame.id}`);
        this.exames = this.exames.filter(e => e.id !== exame.id);
        this.deleteModal.show = false;
      } catch (err) {
        console.error("Erro ao excluir exame:", err);
      }
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
            const res = await axios.post(`/api/pacotes/${this.createModal.pacoteId}/exames`, novoExame);
            const pacote = this.pacotes.find(p => p.id === this.createModal.pacoteId);
            pacote.exames.push(res.data); // API retorna o exame com ID criado
            this.createModal.show = false;
        } catch (err) {
            console.error("Erro ao criar exame:", err);
        }
}

  }
};
</script>
