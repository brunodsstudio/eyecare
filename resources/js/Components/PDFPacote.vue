<template>
    <div v-if="mostrar">
    <div id="pdf-content" style="display: none">
      <!-- Página de cabeçalho do pacote -->
      <div class="pagina-pdf">
        <div class="header">
          <img :src="logoUrl" style="width: 80px;" />
          <div>
            <h5>Paciente: {{ paciente.nome }}</h5>
            <p>CPF: {{ paciente.cpf }}</p>
            <p>Médico: {{ medico.nome }}</p>
          </div>
        </div>

        <div class="mt-4">
          <h4>{{ dados.header.observations }}</h4>
          <p><strong>Observações:</strong> {{ dados.header.observations }}</p>
          <p><strong>Data do Pacote:</strong> {{ dados.header.created_at }}</p>
        </div>

        <div class="footer mt-5">
          <p>{{ dataExtenso }}</p>
          <p>{{ medico.nome }} - CRM: {{ medico.crm }}</p>
        </div>
        <div class="page-break"></div>
      </div>

      <!-- Grupos -->
      <div
        v-for="(exames, grupo) in dados"
        v-if="grupo !== 'header' && grupo !== 'Exames Avulsos'"
        :key="grupo"
        class="pagina-pdf"
      >
        <div class="header">
          <img :src="logoUrl" style="width: 80px;" />
          <div>
            <h5>Paciente: {{ paciente.nome }}</h5>
            <p>CPF: {{ paciente.cpf }}</p>
            <p>Médico: {{ medico.nome }}</p>
          </div>
        </div>

        <div class="mt-4">
          <h4>{{ grupo }}</h4>
          <table class="table table-bordered mt-2">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Lateralidade</th>
                <th>Comentário</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(exame, key) in exames" :key="key">
                <td>{{ exame.id }}</td>
                <td>{{ exame.laterality }}</td>
                <td>{{ exame.comment }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="footer mt-5">
          <p>{{ dataExtenso }}</p>
          <p>{{ medico.nome }} - CRM: {{ medico.crm }}</p>
        </div>
        <div class="page-break"></div>
      </div>

      <!-- Exames Avulsos -->
      <div
        v-for="(exame, key) in dados['Exames Avulsos']"
        :key="'avulso-' + key"
        class="pagina-pdf"
      >
        <div class="header">
          <img :src="logoUrl" style="width: 80px;" />
          <div>
            <h5>Paciente: {{ paciente.nome }}</h5>
            <p>CPF: {{ paciente.cpf }}</p>
            <p>Médico: {{ medico.nome }}</p>
          </div>
        </div>

        <div class="mt-4">
          <h4>Exame Avulso</h4>
          <table class="table table-bordered mt-2">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Lateralidade</th>
                <th>Comentário</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ exame.id }}</td>
                <td>{{ exame.laterality }}</td>
                <td>{{ exame.comment }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="footer mt-5">
          <p>{{ dataExtenso }}</p>
          <p>{{ medico.nome }} - CRM: {{ medico.crm }}</p>
        </div>
        <div class="page-break"></div>
      </div>
    </div>
  </div>
  
</template>

<script>
import html2pdf from "html2pdf.js";

export default {
  name: "PdfPacote",
  props: ["mostrar", "dados", "paciente", "medico", "logoUrl"],
  
  computed: {
    dataExtenso() {
      return new Date().toLocaleDateString("pt-BR", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    },
  },
  watch: {
    mostrar(val) {
      console.log(val)
     if (val) this.gerarPDF();
    },
  },
  methods: {
    gerarPDF() {
      const el = document.getElementById("pdf-content");
      //el.style.display = "block";
      //const el = $("#pdf-content")
      //$("#pdf-content").css('display', "block")
      html2pdf()
        .set({
          margin: 10,
          filename: "pacote_formatado.pdf",
          html2canvas: { scale: 2 },
          jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
        })
        .from(el)
        .save()
        .then(() => {
          this.$emit("fechar");
        });
    }
  }, created(){
    if(this.mostrar) this.gerarPDF();
  } 
};
</script>

<style scoped>
.pagina-pdf {
  page-break-after: always;
  padding: 20px;
  font-size: 12px;
}

.header {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #ccc;
  padding-bottom: 10px;
}

.footer {
  border-top: 1px solid #ccc;
  padding-top: 10px;
  font-size: 10px;
  text-align: right;
}

.page-break {
  page-break-after: always;
}
</style>
