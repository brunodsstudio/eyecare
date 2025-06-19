<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head } from '@inertiajs/vue2';
import PdfPacote from "../Components/PDFPacote.vue";

</script>


<script>
export default {
  components: { PdfPacote },
  data() {
    return {
        examesDrop:[],
        examesDropAvulsos:[],
        examesDisable: true,
        addExameId:null,
        filtro: "",
        exameAvulso :null,
        pacote:[], //individual para impressao
        pacotes: [
            
        ], // todos
        fields: [
            { key: "name", label: "Nome do Exame" },
            { key: "laterality", label: "Lateralidade" },
            { key: "comment", label: "Comentário" },
            { key: "group", label: "Grupo" },
            { key: "actions", label: "Ações" }
        ],
        editModal: {
            show: false,
            pacoteId: null,
            exame: {
                id: null,
                name: '',
                laterality: '',
                comment: '',
                group: ''
            }
            }, 
        deleteModal: {
            show: false,
            pacoteId: null,
            exame: null
            },
        deleteModalPacote:{
            show: false,
            idPacoteDelete:null,
            name: ""
        },
        modalVisivel: {},
        modalVisivelPacoteA: {
            show:false,
            idExame:null
        },
        modalVisivelPacote: {
            show:false,
            name:null,
            obsercvations:null,
        },
        formExame: {
            name: "",
            laterality: "OD",
            comment: "",
            group: ""
        },
        mostrarPdf: false,
        pacoteSelecionado: null,
        logoUrl: "images/eyelogo.jpg",
        paciente: { nome: "João da Silva", cpf: "123.456.789-00" },
        medico: { nome: "Dra. Maria Oliveira", crm: "CRM-SP 123456" },
        }
    },
  methods: {
    editarExame(pacoteId, exame) {
        this.editModal.pacoteId = pacoteId;
        this.editModal.exame = { ...exame }; // clone para edição
        this.editModal.show = true;
    },
    salvarEdicao() {
        const pacote = this.pacotes.find(p => p.id === this.editModal.pacoteId);
        const index = pacote?.exames.findIndex(e => e.id === this.editModal.exame.id);
        if (index !== -1) {
        this.$set(pacote.exames, index, { ...this.editModal.exame });
        }
        this.editModal.show = false;
    },
    excluirExame(pacoteId, exame) {
        this.deleteModal = {
        show: true,
        pacoteId,
        exame
        };
    },
    excluirPacoteModal(pacoteId, pacoteNome){
        this.deleteModalPacote.idPacoteDelete = pacoteId;
        this.deleteModalPacote.name = pacoteNome;
        this.deleteModalPacote.show = true
      

    },
    confirmarExclusaoPacote(pacoteId){
        axios.delete('api/pacotes/'+pacoteId, {
            data: { 
            idPacote: pacoteId
            }
        })
            .then(response => {
                this.makeToast("success", "deletado com sucesso!")
                this.buscarpacotes()

            })
            .catch(error => {
                console.error(error);
        }); 
    },
    confirmarExclusao() {
        const pacote = this.pacotes.find(p => p.id === this.deleteModal.pacoteId);
        if (pacote) {
        pacote.exames = pacote.exames.filter(e => e.id !== this.deleteModal.exame.id);
        }
        this.deleteModal.show = false;
    },
    formatDate(dateStr) {
        return new Date(dateStr).toLocaleString();
    },
    examesFiltrados(pacote) {
      if (!this.filtro) return pacote.exames;
      return pacote.exames.filter(exame =>
        exame.name.toLowerCase().includes(this.filtro.toLowerCase())
      );
    },
    abrirModalAddExame(pacoteId) {
        this.formExame = {
        name: "",
        laterality: "OD",
        comment: "",
        group: ""
        };
        this.$set(this.modalVisivel, pacoteId, true);
    },
    
     abrirModalCriacaoPacoteA()
     {
        this.modalVisivelPacoteA.show = true;
     },
     abrirModalCriacaoPacote(){
        this.modalVisivelPacote.show = true
     },
     async salvarCriacaoPacoteA(){

         var fmr =  new FormData();
         fmr.append("idExame", this.modalVisivelPacoteA.idExame);
         const res = await axios.post(`/api/storePacoteExameAvulso`, fmr);
            this.buscarpacotes()
            this.makeToast("success", "avulso criado com sucesso!")

     },
     async salvarCriacaoPacote(){

         var fmr =  new FormData();
         fmr.append("name", this.modalVisivelPacote.name);
         fmr.append("observations", this.modalVisivelPacote.obsercvations);

         const res = await axios.post(`/api/pacotes`, fmr);
            this.buscarpacotes()
            this.makeToast("success", "Pacote criado com sucesso!")

     },
     makeToast(variant = null, msg) {
        this.$bvToast.toast(msg, {
          title: `Exames`,
          variant: variant,
          solid: true
        })
      },
    async addExameAoPacote(pacoteId) {
        try {

            const formExame = new FormData()
            formExame.append("idPacote", pacoteId)
            formExame.append("idExame", this.addExameId)

            const response = await axios.post(`/api/pacotes/${pacoteId}/attach-exame`, formExame);
            this.modalVisivel[pacoteId] = false;
            this.makeToast("success", "Adicionado com sucesso!")
            this.buscarpacotes();

        } catch (error) {
            console.error("Erro ao criar exame:", error);
            this.makeToast("danger", "Erro mao adiconar! :"+ error)
        }
    },
    async buscarpacotes(){

        await axios.get('api/exames')
        .then(response => {
            const dt = response.data.map(dta=>(
                 {
               "text" :dta.name +": "+ dta.laterality,
               "value" :dta.id
                }
            ))

            this.examesDrop = dt;
        })
        .catch(error => {
            console.error(error);
        });


         await axios.get('api/examesAvulsos')
        .then(response => {
            const dt = response.data.map(dta=>(
                {
               "text" :dta.name +": "+ dta.laterality,
               "value" :dta.id
                }
            ))
            this.examesDropAvulsos = dt;
        })
        .catch(error => {
            console.error(error);
        });

        this.pacotes = [];
        await  axios.get('api/pacotes')
        .then(response => {
            this.pacotes = response.data;

        /*response.data.map((m)=>{
            if(m.id !== 0)
            this.printPdf[m.id] = false; 
        })*/

        })
        .catch(error => {
            console.error(error);
        });

    },
    async carregarPdf(idPacote) {
      try {
        const response = await axios.get("/api/printpacote/"+ idPacote);
        this.pacoteSelecionado = response.data;
        this.mostrarPdf = true;
      } catch (err) {
        console.error("Erro ao carregar PDF do pacote:", err);
      }
    },
    fecharPdf() {
      this.mostrarPdf = false;
      this.pacoteSelecionado = null;
    },
    mostraDropExames(){
            this.examesDisable = false
    },
    escondeDropExames(){
            this.examesDisable = true
    }
    }
    ,created() {
        this.buscarpacotes();
    },

}
</script>

<style scoped>
.card {
  border-radius: 10px;
}
</style>


<template>
  <div class="container mt-4">

    <Head title="Dashboard" />

    <DefaultLayout>
    
    <h2>Pacotes e Exames</h2>
<hr>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <b-button-toolbar aria-label="Toolbar with button groups and dropdown menu">
                <b-button-group class="mx-1">
                    <b-button variant="primary" @click="abrirModalCriacaoPacoteA">+ Exame Avulso</b-button>
                    <b-button variant="success" @click="abrirModalCriacaoPacote">+ Pacote composto</b-button>
                </b-button-group>
            </b-button-toolbar>
           
        </div>
        
        </div>

    <br>
        

    <b-form-group label="Buscar Exame por Nome:" label-for="busca-input">
      <b-form-input id="busca-input" v-model="filtro" placeholder="Digite parte do nome do exame" />
    </b-form-group>

    <div v-for="pacote in pacotes" :key="pacote.id" class="mb-5">
        
      <b-card>

        <b-button v-if="pacote.name !== 'Avulso'" variant="success" size="sm" class="mt-2" @click="abrirModalAddExame(pacote.id)">
            + Adicionar Exame ao Pacote
        </b-button> 
       <span >&nbsp;</span>
         <b-button 
                variant="success"
                size="sm" 
                class="mt-2"
                @click="carregarPdf(pacote.id)">Imprimir PDF
            </b-button><span >&nbsp;</span>
         <b-button 
              size="sm"
              variant="danger"
              class="mt-2"
              @click="excluirPacoteModal(pacote.id, pacote.name)"
            >
              Excluir Pacote
            </b-button>
           
        <PdfPacote
                v-if="pacoteSelecionado"
                :mostrar="mostrarPdf"
                :dados="pacoteSelecionado"
                :paciente="paciente"
                :medico="medico"
                :logoUrl="logoUrl"
                @fechar="fecharPdf"
                />
        <br> <br>

        <h4>{{ pacote.name }} - {{ pacote.id }}</h4>
        <p><strong>Observações:</strong> {{ pacote.observations }}</p>
        <p><strong>Criado em:</strong> {{ formatDate(pacote.created_at) }}</p>

        <b-table
          :items="examesFiltrados(pacote)"
          :fields="fields"
          small
          responsive
          bordered
          class="mt-3"
        >
          <template #cell(actions)="row">
           
            <b-button v-if="pacote.name !== 'Avulso'"
              size="sm"
              variant="danger"
              class="ml-2"
              @click="excluirExame(pacote.id, row.item)"
            >
              Excluir
            </b-button>

             <b-button v-else="pacote.name == 'Avulso'"
              size="sm"
              variant="danger"
              class="ml-2"
               @click="excluirPacoteModal(pacote.id, pacote.name)"
            >
              Excluir
            </b-button>
           
          </template>
        </b-table>
      </b-card>


        <b-modal
        id="edit-exame-modal"
        v-model="editModal.show"
        title="Editar Exame"
        @ok="salvarEdicao"
        ok-title="Salvar"
        >
        <b-form>
            <b-form-group label="Nome">
            <b-form-input v-model="editModal.exame.name" />
            </b-form-group>

        </b-form>
        </b-modal>

        <!-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO -->
        <b-modal
            id="delete-confirm-modal"
            v-model="deleteModal.show"
            title="Confirmar Exclusão"
            @ok="confirmarExclusao"
            ok-variant="danger"
            ok-title="Excluir"
            cancel-title="Cancelar"
            >
            Tem certeza que deseja excluir o exame <strong>{{ deleteModal.exame?.name }}</strong>?
        </b-modal>

        

        <!-- Modal para criação de exame para esse pacote -->
        <b-modal
        :id="'modal-add-exame-' + pacote.id"
        v-model="modalVisivel[pacote.id]"
        title="Adicionar Exame ao Pacote"
        @ok="addExameAoPacote(pacote.id)"
        ok-title="Salvar"
        cancel-title="Cancelar"
        >
            <b-form>
                <b-form-group label="Nome do Exame">
                <b-form-select v-model="addExameId" :options="examesDrop" />
                </b-form-group>        
            </b-form>
        </b-modal>

    </div>

    <!-- Modal de Novo pacote avulso-->
     <b-modal
        v-model="modalVisivelPacoteA.show"
        title="Adicionar Pacote Avulso"
        ok-title="Salvar"
        @ok="salvarCriacaoPacoteA()"
        cancel-title="Cancelar"
        >
            <b-form>
                <b-form-group label="Nome do Exame [Somente Avulsos]">
                <b-form-select v-model="modalVisivelPacoteA.idExame" :options="examesDropAvulsos" />
                </b-form-group>        
            </b-form>
        </b-modal>

        <!-- Modal de Novo pacote composto-->
        <b-modal
        v-model="modalVisivelPacote.show"
        title="Adicionar Pacote Avulso"
        ok-title="Salvar"
        @ok="salvarCriacaoPacote()"
        cancel-title="Cancelar"
        >
            <b-form>
                <b-form-group label="Nome do pacote">
                     <b-form-input v-model="modalVisivelPacote.name" />
                </b-form-group> 
                <b-form-group label="Comentário">
                    <b-form-textarea v-model="modalVisivelPacote.obsercvations" rows="2" />
                </b-form-group>       
            </b-form>
        </b-modal>

    <!-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO pacote -->
        <b-modal
            id="deletePacote-confirm-modal"
            v-model="deleteModalPacote.show"
            title="Confirmar Exclusão"
            @ok="confirmarExclusaoPacote(deleteModalPacote.idPacoteDelete)"
            ok-variant="danger"
            ok-title="Excluir"
            cancel-title="Cancelar"
            >
            Tem certeza que deseja excluir o pacote <strong>{{ deleteModalPacote.name + " - " +deleteModalPacote.idPacoteDelete}}</strong>?
        </b-modal>

    </DefaultLayout>
  </div>
</template>



