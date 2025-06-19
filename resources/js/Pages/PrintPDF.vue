<template>
  <div>

    <div id="pdf-content" style="display: block">
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
            
          <h4>{{ dados.header.name }}</h4>
          <p><strong>Observações:</strong> {{ dados.header.observations }}</p>
          <p><strong>Data do Pacote:</strong> {{ dados.header.created_at }}</p>
        </div>

        <div class="footer mt-5">
          <p>{{ dataExtenso }}</p>
          <p><span class="nomemedico"  style="border-top: 1px black">{{ medico.nome }} - CRM: {{ medico.crm }}</span></p>
        </div>
      </div>

      <!-- Página para cada grupo (exceto Exames Avulsos) -->
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

      <!-- Página para cada exame avulso -->
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
    props: {
        pacoteid:Number,
    }, 
  data() {
    return {
      paciente: {
        nome: "João da Silva",
        cpf: "123.456.789-00",
      },
      medico: {
        nome: "Dra. Maria Oliveira",
        crm: "CRM-SP 123456",
      },
      logoUrl: "images/eyelogo.jpg",
      dados: {
        header: {
          name: "Pacote Simples",
          observations: "teste simples",
          created_at: "2025-06-13 15:23:47",
        },
        "Exames Avulsos": {
          3: {
            id: "Biometria",
            laterality: "OE",
            comment: "BIometria",
          },
          11: {
            id: "Paquimetria",
            laterality: "AO",
            comment: "Paquimetria",
          },
        },
        "Grupo 1": {
          1: {
            id: "Fundo de Olho",
            laterality: "OD",
            comment: "Exame de rotina",
          },
          14: {
            id: "Mapeamento de retina",
            laterality: "OE",
            comment: "Mapeamento de retina",
          },
          4: {
            id: "Campimetria",
            laterality: "OE",
            comment: "Campimetria",
          },
        },
      },
    };
  },
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
  methods: {
    async carregarpacote() {
      try {
        const res = await axios.get("/api/exames/"+ pacoteid);
        this.exames = res.data;
      } catch (err) {
        console.error("Erro ao buscar exames:", err);
        // Fallback para teste:
        
      }
    },
    gerarPDF() {
      const element = document.getElementById("pdf-content");
      element.style.display = "block";
      html2pdf()
        .set({
          margin: 10,
          filename: "pacote_formatado.pdf",
          html2canvas: { scale: 2 },
          jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
        })
        .from(element)
        .save()
        .then(() => {
          element.style.display = "none";
        });
    },
  },
  mounted: function(){
    gerarPDF();
  }
};
</script>

<style scoped>
.nomemedico {
    border-top: 1px black ;
}
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
