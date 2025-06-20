<template>
  <div>
    <div class="p-4 border rounded bg-white">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h5><strong>Paciente:</strong> {{ paciente.nome }}</h5>
        <p><strong>CPF:</strong> {{ paciente.cpf }}</p>
        <p><strong>Doutor:</strong> {{ medico.nome }}</p>
      </div>
      <img :src="logoUrl" alt="Logo" style="width: 100px; height: auto;" />
    </div>

    <!-- Descrição do pacote -->
    <div class="mb-4">
      <h4>{{ dados.header.name }}</h4>
      <p><strong>Observações:</strong> {{ dados.header.observations }}</p>
      <p><strong>Criado em:</strong> {{ dados.header.created_at }}</p>
    </div>

    <!-- Grupos -->
    <div v-for="(grupo, grupoKey) in dados" :key="grupoKey" v-if="grupoKey !== 'header'">
      <h5 class="mt-4">{{ grupoKey }}</h5>
      <b-table striped hover small :items="formatarExames(grupo)" :fields="camposTabela" class="mt-2" />
    </div>

    <!-- Rodapé -->
    <div class="mt-5 border-top pt-3 text-right text-muted small">
      <p>{{ dataExtenso }}</p>
      <p>{{ medico.nome }} - {{ medico.crm }}</p>
    </div>
  </div>

    <PDFJsPacote
      v-if="mostrar"
      :id-pacote="idSelecionado"
      @fechar="mostrar = false"
    />
  </div>
</template>

<script>
import PDFJsPacote from "../Components/PDFJsPacote.vue";

export default {
  components: { PDFJsPacote },
  data() {
    return {
    logo:null,
        mostrar: true,
        idSelecionado: null,
        paciente: {
          nome: "João da Silva",
          cpf: "123.456.789-00",
        },
        medico: {
          nome: "Dra. Maria Oliveira",
          crm: "CRM-SP 123456",
        },
        camposTabela: [
        { key: "nome", label: "Nome" },
        { key: "laterality", label: "Lateralidade" },
        { key: "comment", label: "Comentário" },
        ],
        logoUrl: "http://"+window.location.host + "/images/eyelogo.jpg",
        dados:null,

      }
  },
  methods: {
    abrirPdf(id) {
      this.idSelecionado = id;
      this.mostrar = true;
    },
    makeToast(variant = null, msg) {
        this.$bvToast.toast(msg, {
          title: `Exames`,
          variant: variant,
          solid: true
        })
      },
    formatarExames(grupo) {
      return Object.values(grupo).map((exame) => ({
        nome: exame.id,
        laterality: exame.laterality,
        comment: exame.comment,
      }));
    },
    async carregarPdf(idPacote) {
      try {
        if(undefined !== idPacote){
          const response = await axios.get("/api/printpacote/"+ idPacote);
          this.dados = await response.data;
          this.makeToast("success", "Pacote Impresso com sucesso!")
        }
      } catch (err) {
        console.error("Erro ao carregar PDF do pacote:", err);
        this.makeToast("danger", "erro ao buscar informaçoes!: " + err)
      }
    },
  }, mounted(){

    const urlPath = window.location.pathname; // Example: "/blog/2023/article-title/"
    const segments = urlPath.split('/').filter(segment => segment); // Filter out empty strings
    const lastSegment = segments[segments.length - 1]; 

    this.idSelecionado = lastSegment

    this.carregarPdf(lastSegment);

    

  },computed: {
    dataExtenso() {
      return new Date().toLocaleDateString("pt-BR", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    },
  }
};
</script>